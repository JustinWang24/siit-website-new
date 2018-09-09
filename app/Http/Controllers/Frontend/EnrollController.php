<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\IntakeItem;
use App\Models\Catalog\Product;
use App\Models\Dealer\DealerOrder;
use App\Models\Dealer\DealerStudent;
use App\Models\Group;
use App\Models\Order\Order;
use App\Models\Utils\JsonBuilder;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\StudentProfile;
use App\Models\Utils\Axcelerate\AxcelerateClient;
use Log;
use Mpdf\Mpdf;
use App\Models\Catalog\Product\OptionItem;

class EnrollController extends Controller
{
    /**
     * 学生注册课程的表单显示
     * @param $intakeItemId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function course_enroll($intakeItemId=null, Request $request){
        $this->dataForView['pageTitle'] = 'Intake Latest';
        $this->dataForView['metaKeywords'] = 'Intake Latest';
        $this->dataForView['metaDescription'] = 'Intake Latest';

        // 检查是否为agent来的信息
        $agent = null;
        if(!empty($request->get('agent'))){
            // 提交的agent参数如果为零， 也是empty的，所以$agent依然会是null
            $agent = Group::GetByCode($request->get('agent'));
        }

        // 获取提交的intance参数， 它是Axcelerate的instantId_Type
        $instanceIdAndType = $request->get('instance');

        // 检查是否能够提取出用户的信息
        $studentProfile = null;
        $studentUserId = null;
        if($request->session()->get('user_data')){
            $studentUserId = $request->session()->get('user_data.id');
            $user = User::GetById($studentUserId);
            if($user){
                $studentProfile = $user->studentProfile;
            }
        }elseif($request->has('sd')){
            // 表示用户没有登录
            $uuid = $request->get('sd');
            $user = User::GetByUuid($uuid);
            if($user){
                $this->_saveUserInSession($user);
                // 将学生的档案数据传给 View
                $studentProfile = $user->studentProfile;
            }
        }

        if(is_null($studentProfile)){
            // 如果此时还是没有找到学生的档案， 那么再尝试一个办法
            // 检查是否能够提取出用户的信息
            if(!empty($request->get('user_id'))){
                // 表示用户没有登录
                $uuid = $request->get('user_id');
                $user = User::GetByUuid($uuid);
                if($user){
                    $this->_saveUserInSession($user);
                    // 将学生的档案数据传给 View
                    $studentProfile = $user->studentProfile;
                }
            }
        }
        // 向View 传送 $studentProfile
        $this->dataForView['studentProfile'] = $studentProfile;

        // todo: 检查intake, 如果是 inax- 开头的，表示非 Axcelerate 的课程
        $course = Product::GetByUuid($request->get('product_id'));

        if( $course && empty($course->axcelerate_course_id) ){
            /**
             * 课程没有 axcelerate_course_id 表示非 Axcelerate的课程
             */
            $all = $request->all();

            /**
             * 获取Intake 的ID, 下面的两个方式必能获得，c_intake 这个参数在用户没有登录的情况下会被提交上来
             */
            $intakeId = $request->get('intake_id') ? $request->get('intake_id') : $request->get('c_intake');
            $this->_handleNotAxcelerateCourse($course, $intakeId, $agent);

            $productOptions = [];
            foreach ($all as $key=>$value) {
                if(strpos($key,'product_option_') !== false){
                    $productOptions[] = $value;
                }
            }
            if(empty($productOptions)){
                // 查找一下, 是否是在用户之前没有登录的情况下的提交
                $this->dataForView['productOptions'] = $request->get('c_options');
            }else{
                // 如果用户已经登录的状态, 那么这样设置课程的选项
                $this->dataForView['productOptions'] = implode(',',$productOptions);
            }
        }else{
            // Axcelerate 课程
            $this->_handleAxcelerateCourse($intakeItemId,$instanceIdAndType, $agent, $request, $course);
        }

        return view(_get_frontend_theme_path('enroll.course_enroll'),$this->dataForView);
    }

    /**
     * 处理非 Axcelerate 的课程流程
     * @param Product $course
     * @param string $intakeId
     * @param Group|null $dealer
     */
    private function _handleNotAxcelerateCourse(Product $course, $intakeId, Group $dealer=null){
        // 根据给定的值, 查询经销商 ID 或者 Code
        $this->dataForView['dealer'] = $dealer;
        // 如果该课程已经过期了
        $this->dataForView['intakeItem'] = new IntakeItem();
        $this->dataForView['intakeId'] = $intakeId; // 表示客户选取的开学日期
        $this->dataForView['instanceIdAndType'] = null;
        $this->dataForView['axcelerateInstance'] = null;
        $this->dataForView['course'] = $course;
    }

    /**
     * 专门处理 Axcelerate 课程的方法
     * @param $intakeItemId
     * @param $instanceIdAndType
     * @param Group $dealer
     * @param Request $request
     * @param Product $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function _handleAxcelerateCourse($intakeItemId, $instanceIdAndType, Group $dealer=null, Request $request, Product $course=null){
        // 如果没有传入课程对象， 要想办法取得课程数据
        if(is_null($course)){
            $intakeItem = $intakeItemId ? IntakeItem::GetById($intakeItemId) : null;
            if($intakeItem){
                $course = $intakeItem->inTake->course;
            }else{
                // 一定要找出product uuid
                $courseUuid = 0;
                if(str_start($intakeItemId,'ax-')){
                    $courseUuid = str_replace('ax-','',$intakeItemId);
                }elseif (str_start($intakeItemId,'unax-')){
                    $courseUuid = str_replace('unax-','',$intakeItemId);
                }

                if($request->get('product_id')){
                    $course = Product::GetByUuid($request->get('product_id'));
                }else{
                    if(strpos($intakeItemId,'unax-') === 0){
                        $courseUuid = str_replace('unax-','',$intakeItemId);
                    }elseif (strpos($intakeItemId,'ax-') === 0){
                        $courseUuid = str_replace('ax-','',$intakeItemId);
                    }
                    $course = $courseUuid ? Product::GetByUuid($courseUuid) : null;
                }
            }
        }

        // 必须要有 Axcelerate 的 instance 数据
        $axcelerateInstance = AxcelerateClient::GetAxcelerateInstanceDetailByIdAndType($instanceIdAndType);

        if(is_null($axcelerateInstance)){
            // 没有从Axcelerate 找到 instance, 那么返回
            session()->flash('msg', ['content' => 'The intake date is not available, please choose another date!', 'status' => 'danger']);
            return redirect('/catalog/product/'.$course->uri.'?agent='.($dealer ? $dealer->group_code : 0));
        }

        // 根据给定的值, 查询经销商 ID 或者 Code
        $this->dataForView['dealer'] = $dealer;

        // 如果该课程已经过期了
        $this->dataForView['instanceIdAndType'] = $instanceIdAndType;
        $this->dataForView['axcelerateInstance'] = $axcelerateInstance;
        $this->dataForView['intakeItem'] = isset($intakeItem) ? $intakeItem : null;
        $this->dataForView['course'] = $course;
    }


    /**
     * 学生注册
     * 1: 保存学生在注册表格中填写的所有个人信息已经上传的附件
     * 2: 如果不存在Axcelerate Contact, 会创建一个; 如果已经有了, 会直接使用 user 表记录中的 axcelerate_contact_id
     * 3: 取得 Axcelerate 的 Instance
     * 4: 以Place Order 的方式保存订单, 成功之后情况购物车的内容
     * 5: 向 Axcelerate 进行 Enrol 的操作; 如果成功, 跳转到enrol成功页面; 如果失败, 删除订单及订单项, 跳转到之前的预定页面, 带上报错信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function course_enroll_confirm(Request $request){
        $studentProfileData = $request->get('student');
        $enrollData = $request->get('enroll');

        // 获取中介的信息
        $dealer = null;
        if(!empty($enrollData['voucher'])){
            $dealer = Group::GetByCode($enrollData['voucher']);
        }

        $storagePath = _buildUploadFolderPath();
        // 可能上传的文件
        if($request->hasFile('passport_first_page_image')){
            // 个人护照
            $studentProfileData['passport_first_page_image'] = $request->file('passport_first_page_image')
                ->store($storagePath, 'public');
        }

        if($request->hasFile('english_test_certificate_image')){
            // 英语考试成绩
            $studentProfileData['english_test_certificate_image'] = $request->file('english_test_certificate_image')
                ->store($storagePath, 'public');
        }

        if($request->hasFile('disability_required_file')){
            $studentProfileData['disability_required_file'] = $request->file('disability_required_file')
                ->store($storagePath, 'public');
        }
        if($request->hasFile('applying_exemptions_files')){
            $uploaded = $request->file('applying_exemptions_files');
            if(is_array($uploaded)){
                foreach ($uploaded as $key=>$file) {
                    $path = $file->store($storagePath,'public');
                    $studentProfileData['applying_exemptions_files'][] = $path;
                }
            }else{
                if($uploaded){
                    $path = $uploaded->store($storagePath,'public');
                    $studentProfileData['applying_exemptions_files'][] = $path;
                }
            }
        }

        // 先看看这个学生在系统中有没有profile
        $user = User::GetByUuid(session('user_data.uuid'));


        if($user){
            if(!$user->studentProfile){
                // Todo 如果学生没有profile, 那么先创建一个
                StudentProfile::Persistence($studentProfileData, $user);
            }else{
                // todo 更新学生的profile
                StudentProfile::Persistence($studentProfileData, $user, true);
            }

            // 现在学生已经有了Profile了
            // Todo 先检查一下, 是否需要Axcelerate的配合
            $course = Product::GetByUuid($enrollData['course_id']);
            $cart = $this->getCart();   // 1: 创建一个购物车

            if($course->axcelerate_course_id){
                // Todo 处理课程的登记
                // Todo 1: 根据给定的Email, 去Axcelerate取查找，看是否可以取得对应的 contact ID
                $contact = $user->getAxcelerateContact();
                $axcelerateInstance = AxcelerateClient::GetAxcelerateInstanceDetailByIdAndType($enrollData['instance']);
                $errorMsg = 'Sorry, system is busy now, Please try again!';
                if($contact && $axcelerateInstance){
                    // 获取 Axcelerate Contact 对象成功
                    // todo 保存订单
                    $cart->add($course->id,$course->getProductName(),1,$course->getFinalPriceGstNumeric(),$enrollData);
                    $orderPlaced = Order::PlaceOrder(
                        $user,
                        $cart,
                        $enrollData['instance'],
                        null,
                        null,
                        $axcelerateInstance,
                        $dealer
                    );
                    // todo 保存订单操作完成

                    if($orderPlaced){
                        $cart->destroy();
                        // 如果有中介的信息, 建立连接
                        $this->connectOrderToAgent($orderPlaced, $dealer,$user);
                        // todo 3: 订单保存成功, 开始向 Axcelerate 提交数据
                        try{
                            $result = $contact->enrolmentForInstance($axcelerateInstance)
                                ->enrol($orderPlaced,$enrollData);
                        }catch (\Exception $e){
                            $errorMsg = $e->getCode().': '.$e->getMessage();
                            $result = false;
                        }

                        if($result && isset($result['LEARNERID'])){
                            $orderPlaced->axe_learner_id = $result['LEARNERID'];
                            $orderPlaced->axe_invoice_id = $result['INVOICEID'];
                            $orderPlaced->save();

                            // todo 4: 订单已经提交到了 Axcelerate, 显示界面, 让用户去查收邮件
                            session()->flash(
                                'msg',
                                ['content' => trans('general.enrol_success'), 'status' => 'success']
                            );
                            return redirect()->route('enrol.offer_letter');
                        }else{
                            // 向 Axcelerate 进行 enrol 失败了
                            $orderPlaced->removeAll();
                        }
                    }
                }

                Log::info('AxcelerateEnrolFailed',$enrollData);
                // 操作失败
                session()->flash('msg', ['content' => $errorMsg, 'status' => 'danger']);
                return redirect('/catalog/course/book/'.$enrollData['intake_item'].'?agent='.$studentProfileData['agent_id'].'&instance='.$enrollData['instance'].'&product_id='.$course->uuid);
            }else{
                // Todo 获取非Axcelerate课程的 options
                $productOptionsId = explode(',',$enrollData['productOptions']);
                $notes = null;
                $costFromOption = 0;

                foreach ($productOptionsId as $productOptionId) {
                    /**
                     * @var OptionItem $optionItem
                     */
                    $optionItem = OptionItem::find($productOptionId);
                    $notes .= trans('general.'.$optionItem->productOption->name).': '.trans('general.'.$optionItem->label).PHP_EOL;
                    $costFromOption += $optionItem->extra_value;
                }

                // 不需要 Axcelerate 配合的课程
                $cart->add(
                    $course->id,
                    $course->getProductName(),
                    1,
                    $course->getFinalPriceGstNumeric() + $costFromOption,
                    $enrollData
                );

                $orderPlaced = Order::PlaceOrder(
                    $user,
                    $cart,
                    str_random(8),
                    $notes,
                    null,
                    null,
                    $dealer
                );

                /**
                 * 只要创建过订单了，就清空购物车
                 */
                $cart->destroy();

                if($orderPlaced){
                    $this->connectOrderToAgent($orderPlaced, $dealer, $user);

                    // todo 3: 订单保存成功, 开始向 Axcelerate 提交数据
                    session()->flash('msg', [
                        'content' => trans('general.enrol_success'), 'status' => 'success']
                    );
                    return redirect()->route('enrol.offer_letter');
                }else{
                    session()->flash('msg', [
                        'content' => trans('general.system_busy'), 'status' => 'danger']
                    );
                    return redirect('/catalog/product/'.$course->getProductUrl());
                }
            }

        }
        return redirect()->route('customer_login');
    }

    /**
     * @param Order|null $order
     * @param Group|null $dealer
     * @param User|null $student
     */
    protected function connectOrderToAgent(Order $order=null, Group $dealer=null, User $student=null){
        if($order && $dealer && $student){
            // 把该学生分配给中介
            DealerStudent::Persistent($dealer, $student);
            // 把订单分配给中介
            DealerOrder::Persistent($order, $dealer);
        }
    }

    /**
     * 显示offer letter的页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_offer_letter(Request $request){
        $this->dataForView['pageTitle'] = trans('enrolment.title_offer_letter');
        $this->dataForView['metaKeywords'] = '';
        $this->dataForView['metaDescription'] = '';
        $this->dataForView['siteConfig'] = $this->siteConfig;

        // 获取学生最后一个待定的订单
        $this->dataForView['order'] = Order::where('user_id',session('user_data.id'))->orderBy('id','desc')->first();
        $student = User::GetById(session('user_data.id'));
        $this->dataForView['student'] = $student;
        $this->dataForView['studentProfile'] = $student->studentProfile;
        $this->dataForView['vuejs_libs_required'] = [
            'offer_letter',
        ];

        return view(_get_frontend_theme_path('enroll.offer_letter'),$this->dataForView);
    }

    /**
     * 下载Offer letter 文件 PDF
     * @param $uuid
     * @throws \Mpdf\MpdfException
     * @throws \Throwable
     */
    public function get_offer_letter($uuid){
        $order = Order::GetByUuid($uuid);
        if($order){
            $this->dataForView['order'] = $order;
            $this->dataForView['student'] = $order->customer;
            $this->dataForView['studentProfile'] = $order->customer->studentProfile;

            $html = view(_get_frontend_theme_path('enroll.pdf_offer_letter'),$this->dataForView)->render();
            $mpdf = new Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
    }

    /**
     * 保存Offer letter的签名. 每个订单的offer letter 签名文件, 就是订单的UUID.png
     * @param Request $request
     * @return string
     */
    public function confirm_offer_letter(Request $request){
        $data = $request->get('signature');

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        try{
            file_put_contents(
                Order::BuildStudentSignaturePath($request->get('order')),
                $data
            );
            return JsonBuilder::Success(['r'=>url('/frontend/my_orders/'.session('user_data.uuid'))]);
        }catch (\Exception $exception){
            return JsonBuilder::Error();
        }
    }
}