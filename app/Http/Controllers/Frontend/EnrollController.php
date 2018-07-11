<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\IntakeItem;
use App\Models\Catalog\Product;
use App\Models\Group;
use App\Models\Order\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\StudentProfile;
use App\Models\Utils\Axcelerate\AxcelerateClient;
use Log;

class EnrollController extends Controller
{
    /**
     * 学生注册课程的表单显示
     * @param $intakeItemId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function course_enroll($intakeItemId, Request $request){
        // 检查是否为agent来的信息
        $agentCode = $request->get('agent');
        $instanceIdAndType = $request->get('instance');

        $intakeItem = IntakeItem::GetById($intakeItemId);
        if(!$intakeItem){
            return view(_get_frontend_theme_path('pages.404'),$this->dataForView);
        }

        $course = $intakeItem->inTake->course;

        // 必须要有 Axcelerate 的 instance 数据
        $axcelerateInstance = AxcelerateClient::GetAxcelerateInstanceDetailByIdAndType($instanceIdAndType);

        if(is_null($axcelerateInstance)){
            // 没有从Axcelerate 找到 instance, 那么返回
            session()->flash('msg', ['content' => 'The intake date is not available, please choose another date!', 'status' => 'danger']);
            return redirect('/catalog/product/'.$course->uri.'?agent='.$agentCode);
        }

        if($agentCode){
            // 根据给定的值, 查询经销商 ID 或者 Code
            $this->dataForView['dealer'] = Group::where('group_code',$agentCode)
                ->orWhere('id',$agentCode)
                ->first();
        }

        // 检查是否能够提取出用户的信息
        $this->dataForView['studentProfile'] = null;
        if($request->has('sd') && empty($request->session()->get('user_data'))){
            // 表示用户没有登录
            $uuid = $request->get('sd');
            $user = User::GetByUuid($uuid);
            if($user){
                $this->_saveUserInSession($user);
                // 将学生的档案数据传给 View
                $this->dataForView['studentProfile'] = $user->studentProfile;
            }
        }

        // 如果该课程已经过期了
        $this->dataForView['instanceIdAndType'] = $instanceIdAndType;
        $this->dataForView['axcelerateInstance'] = $axcelerateInstance;
        $this->dataForView['intakeItem'] = $intakeItem;
        $this->dataForView['course'] = $course;
        $this->dataForView['pageTitle'] = 'Intake Latest';
        $this->dataForView['metaKeywords'] = 'Intake Latest';
        $this->dataForView['metaDescription'] = 'Intake Latest';

        return view(_get_frontend_theme_path('enroll.course_enroll'),$this->dataForView);
    }


    /**
     * 学生注册
     * 1: 保存学生在注册表格中填写的所有个人信息已经上传的附件
     * 2: 如果不存在Axcelerate Contact, 会创建一个; 如果已经有了, 会直接使用 user 表记录中的 axcelerate_contact_id
     * 3: 取得 Axcelerate 的 Instance
     * 4: 以Place Order 的方式保存订单, 成功之后情况购物车的内容
     * 5: 向 Axcelerate 进行 Enrol 的操作; 如果成功, 跳转到enrol成功页面; 如果失败, 删除订单及订单项, 跳转到之前的预定页面, 带上报错信息
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function course_enroll_confirm(Request $request){
        $studentProfileData = $request->get('student');
        $enrollData = $request->get('enroll');

        $storagePath = _buildUploadFolderPath();
        // 可能上传的文件
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
            // Todo 处理课程的登记
            // Todo 1: 根据给定的Email, 去Axcelerate取查找，看是否可以取得对应的 contact ID
            $contact = $user->getAxcelerateContact();
            $axcelerateInstance = AxcelerateClient::GetAxcelerateInstanceDetailByIdAndType($enrollData['instance']);
            if($contact && $axcelerateInstance){
                // 获取 Axcelerate Contact 对象成功
                // todo 保存订单
                $cart = $this->getCart();   // 1: 创建一个购物车
                $course = Product::GetByUuid($enrollData['course_id']);

                $cart->add($course->id,$course->getProductName(),1,$course->getFinalPriceGstNumeric(),$enrollData);
                $orderPlaced = Order::PlaceOrder(
                    $user,
                    $cart,
                    $enrollData['instance'],null,null,$axcelerateInstance);
                // todo 保存订单操作完成

                if($orderPlaced){
                    $cart->destroy();
                    // todo 3: 订单保存成功, 开始向 Axcelerate 提交数据

                    try{
                        $result = $contact->enrolmentForInstance($axcelerateInstance)
                            ->enrol($orderPlaced,$enrollData);
                    }catch (\Exception $e){
                        $result = false;
                    }

                    if($result && isset($result['LEARNERID'])){
                        $orderPlaced->axe_learner_id = $result['LEARNERID'];
                        $orderPlaced->axe_invoice_id = $result['INVOICEID'];
                        $orderPlaced->save();

                        // todo 4: 订单已经提交到了 Axcelerate, 显示界面, 让用户去查收邮件
                        session()->flash('msg', ['content' => 'Hi , thank you very much for your enrollment, one of our staff will contact you very soon!', 'status' => 'success']);
                        return redirect()->route('customer.checkout');
                    }else{
                        // 向 Axcelerate 进行 enrol 失败了
                        $orderPlaced->removeAll();
                    }
                }
            }
            Log::info('AxcelerateEnrolFailed',$enrollData);
            // 操作失败
            session()->flash('msg', ['content' => 'Sorry, system is busy now, Please try again!', 'status' => 'danger']);
            return redirect('/catalog/course/book/'.$enrollData['intake_item'].'?agent='.$studentProfileData['agent_id'].'&instance='.$enrollData['instance']);
        }
        return redirect()->route('customer_login');
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

        $this->dataForView['vuejs_libs_required'] = [
            'offer_letter',
        ];

        return view(_get_frontend_theme_path('enroll.offer_letter'),$this->dataForView);
    }
}