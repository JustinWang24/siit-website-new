<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Customer\Wholesaler;
use App\Models\User\StudentProfile;
use App\Models\Utils\JsonBuilder;
use App\Models\Utils\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Utils\UserGroup as UserGroupTool;
use App\Events\UserCreated;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Hash;
use App\Models\Newsletter\UserSubscribe;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\CustomizedAuthenticatesUsers;
use DB;

class CustomersController extends Controller
{
    use CustomizedAuthenticatesUsers;
    /**
     * 加载普通客户登录表单的方法
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request){
        $this->dataForView['menuName'] = 'customer';
        $this->dataForView['the_referer'] = $request->headers->get('referer');

        return view(
            _get_frontend_theme_path('customers.login'),
            $this->dataForView
        );
    }

    /**
     * Customer Login Check
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login_check(Request $request){
        $this->validateLogin($request);
        $user = $this->_getUserFromRequestData($request);

        if($user && Hash::check($request->get('password'), $user->password)){
            $this->_saveUserInSession($user);
            $referrer = $request->get('the_referer');
            if($referrer == url('frontend/customers/login')){
                $referrer = '/';
            }elseif(strpos($referrer,'password/reset') !== false){
                $referrer = '/';
            }
            return redirect($referrer);
        }else{
            return redirect('frontend/customers/login');
        }
    }

    /**
     * 用户登录的Ajax方法
     * @param Request $request
     * @return string
     */
    public function login_check_ajax(Request $request){
        $user = $this->_getUserFromRequestData($request);
        if($user && Hash::check($request->get('password'), $user->password)){
            // 登录成功
            $this->_saveUserInSession($user);
            return JsonBuilder::Success(['uuid'=>$user->uuid]);
        }else{
            return JsonBuilder::Error(['msg'=>trans('auth.username_password_wrong')]);
        }
    }

    /**
     * 从request的email数据中提取email
     * @param Request $request
     * @return mixed
     */
    private function _getUserFromRequestData(Request $request){
        return User::where('email',$request->get('email'))
            ->where('role',UserGroupTool::$GENERAL_CUSTOMER)
            ->first();
    }

    /**
     * 加载普通客户注册表单的方法
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(Request $request){
        $this->dataForView['menuName'] = 'customer';
        $this->dataForView['the_referer'] = $request->headers->get('referer');
        return view(
            _get_frontend_theme_path('customers.register'),
            $this->dataForView
        );
    }

    /**
     * 批发商客户的注册方法
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register_wholesale(Request $request){
        $this->dataForView['menuName'] = 'wholesale';
        $this->dataForView['the_referer'] = $request->headers->get('referer');
        return view(
            _get_frontend_theme_path('customers.register_wholesale'),
            $this->dataForView
        );
    }

    /**
     * Save wholesaler account action
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function save_wholesale(Request $request){
        $userData = $request->all();

        // 检查提交的信息是否正确
        $validator = Validator::make($userData, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address'=>'required|string|max:80',
            'city'=>'required|string|max:40',
            'state'=>'required|string|max:20',
            'postcode'=>'required|numeric',
            'wholesale.company_name'=>'required|string|max:255',
            'wholesale.accountant_name'=>'required|string|max:50',
            'wholesale.accountant_email'=>'required|string|email|max:50',
            'wholesale.accountant_phone'=>'required|numeric',
        ]);

        $validator->validate();

        $wholesaleData = $request->get('wholesale');
        $initPassword = $userData['password'];

        $userData['password'] = Hash::make($userData['password']);
        $userData['role'] = UserGroupTool::$WHOLESALE_CUSTOMER;
        $userData['uuid'] = Uuid::uuid4()->toString();

        DB::beginTransaction();
        $user = User::create($userData);

        if($user){
            // 记录用户的订阅记录: 如果用户选择了订阅且是有效的邮件地址
            $subscribe_me = false;
            if(isset($userData['subscribe_me'])){
                $subscribe_me = true;
            }
            if($subscribe_me && filter_var($user->email, FILTER_VALIDATE_EMAIL)){
                UserSubscribe::create([
                    'user_id'=>$user->id,
                    'type'=>UserGroupTool::$WHOLESALE_CUSTOMER,
                    'email'=>$user->email
                ]);
            }

            $wholesaleData['user_id'] = $user->id;
            $wholesaler = Wholesaler::create($wholesaleData);
            if($wholesaler){
                // 创建成功
                // 发布事件
                event(new UserCreated($user,$initPassword));
                DB::commit();

                $this->_saveUserInSession($user);
                $referrer = $request->get('the_referer');
                if($referrer == url('frontend/wholesalers/register')){
                    $referrer = '/';
                }
                return redirect($referrer);
            }
        }
        DB::rollback();
        session()->flash('msg', ['content'=>'Account: "'.$userData['email'].'" can not be created, please try again!','status'=>'danger']);
        return redirect('frontend/wholesalers/register');
    }

    /**
     * @return array
     */
    public function forget_password()
    {
        $this->dataForView['pageTitle'] = 'Forget password';
        return view(_get_frontend_theme_path('customers.password.email'),$this->dataForView);
    }

    /**
     * 检查给定的电子邮件是否存在的方法
     * @param Request $request
     * @return string
     */
    public function is_email_exist(Request $request){
        $user = User::where('email',$request->get('email'))->orderBy('id','desc')->first();
        if($user){
            // 表示这个账户存在
            return JsonBuilder::Success('no');
        }else{
            return JsonBuilder::Success('ok');
        }
    }

    /**
     * 保存客户数据的方法
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request){
        $data = $request->all();

        $subscribe_me = false;
        if(isset($data['subscribe_me'])){
            $subscribe_me = true;
        }
        unset($data['_token']);
        unset($data['subscribe_me']);

        // 获取Referer
        $referer = $data['the_referer'];

        if($request->has('id')){
            // 更新操作
            $id = $data['id'];
            unset($data['id']);
            $user = User::find($id);
            foreach ($data as $field_name => $field_value) {
                $user->$field_name = $field_value;
            }
            if($user->save()){
                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" has been updated successfully!','status'=>'success']);
            }else{
                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" can not be updated, please try again!','status'=>'danger']);
            }
        }else{
            // 这个是注册用户的位置
//            $validator = Validator::make($request->all(), [
//                'name' => 'required|string|max:30',
//                'email' => 'required|string|email|max:50|unique:users',
//                'password' => 'required|string|min:6|confirmed',
//                'address'=>'required|string|max:80',
//                'city'=>'required|string|max:40',
//                'state'=>'required|string|max:20',
//                'postcode'=>'required|numeric'
//            ]);
//            $validator->validate();
//
//            $initPassword = $data['password'];
//            $userData = [
//                'uuid'=>Uuid::uuid4()->toString(),
//                'password'=>Hash::make($data['password']),
//            ];
//            $data['uuid'] = $userData['uuid'];
//            $data['password'] = $userData['password'];
////            $data['group_id'] = UserGroupTool::$GENERAL_CUSTOMER;
//            $data['role'] = UserGroup::$GENERAL_CUSTOMER;
//
//            // 添加操作
//            if($user = User::create($data)){
//                // 发布事件
//                event(new UserCreated($user,$initPassword));
//
//                // 记录用户的订阅记录: 如果用户选择了订阅且是有效的邮件地址
//                if($subscribe_me && filter_var($user->email, FILTER_VALIDATE_EMAIL)){
//                    UserSubscribe::create([
//                        'user_id'=>$user->id,
//                        'type'=>UserGroupTool::$GENERAL_CUSTOMER,
//                        'email'=>$user->email
//                    ]);
//                }
//
//                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" has been created successfully!','status'=>'success']);
//            }else{
//                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" can not be created, please try again!','status'=>'danger']);
//            }
            $result = $this->_saveNewCustomer($request->all());
            $user = isset($result['userObject']) ? $result['userObject'] : null;
            // 添加操作
            if($user){
                // 发布事件
                event(new UserCreated($user,$result['initPassword']));

                // 记录用户的订阅记录: 如果用户选择了订阅且是有效的邮件地址
                if($subscribe_me && filter_var($user->email, FILTER_VALIDATE_EMAIL)){
                    UserSubscribe::create([
                        'user_id'=>$user->id,
                        'type'=>UserGroupTool::$GENERAL_CUSTOMER,
                        'email'=>$user->email
                    ]);
                }
                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" has been created successfully!','status'=>'success']);
            }else{
                session()->flash('msg', ['content'=>'Account: "'.$data['name'].'" can not be created, please try again!','status'=>'danger']);
            }
        }

        if(!empty($referer)){
            // 从哪里来到哪里去
            if($referer == url('/').'/'){
                $referer = '/frontend/customers/login';
            }
            return redirect($referer);
        }else{
            // 重定向到结账页面
            return redirect('frontend/place_order_checkout');
        }
    }

    /**
     * 用户在快速结账的时候提交的数据的保存操作
     * @param Request $request
     * @return string
     */
    public function quick_checkout_register(Request $request){
        // 要检查用户提交的email是否已经被系统保存过了
        $data = $request->get('shippingForm');
        if(isset($data['email'])){
            $email = $data['email'];
            $user = User::GetByEmail($email);
            if($user){
                // 这个邮件已经被使用了
                return JsonBuilder::Error(
                    [
                        'errorMsg'=>trans('validation_rules.email_is_unique'),
                        'errorCode'=>User::ERROR_CODE_EMAIL_UNIQUE,
                    ]
                );
            }else{
                // 这个邮件没有别人使用过, 可以生成新的用户
                $result = $this->_saveNewCustomer($data, false);
                $user = $result['userObject'];
                if($user){
                    // 保存成功了, 说明可以进行下一步
                    return JsonBuilder::Success(['uuid'=>$user->uuid]);
                }else{
                    // 保存失败, 可能系统繁忙, 提醒用户从新提交一次
                    return JsonBuilder::Error(
                        [
                            'errorMsg'=>trans('general.system_busy'),
                            'errorCode'=>User::ERROR_CODE_CREATE_NEW_FAILED
                        ]
                    );
                }
            }
        }else{
            return JsonBuilder::Error(
                [
                    'errorMsg'=>trans('validation_rules.email_is_required'),
                    'errorCode'=>User::ERROR_CODE_EMAIL_REQUIRED,
                ]
            );
        }
    }

    /**
     * 保存用户提交的request数据的私有方法
     * @param $data
     * @param bool $passwordIsRequired
     * @return array
     * @throws \Exception
     */
    private function _saveNewCustomer($data,$passwordIsRequired = true){
        // 这个是注册用户的位置
        $rules = [
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:50|unique:users',
            'address'=>'required|string|max:80',
            'city'=>'required|string|max:40',
            'state'=>'required|string|max:20',
            'postcode'=>'required|numeric'
        ];
        if($passwordIsRequired){
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        $validator = Validator::make($data, $rules);
        $validator->validate();

        // 用户有一个默认的密码
        $initPassword = '123456';
        if(isset($data['password'])){
            $initPassword = $data['password'];
        }

        $userData = [
            'uuid'=>Uuid::uuid4()->toString(),
            'password'=>Hash::make($initPassword),
        ];
        $data['uuid'] = $userData['uuid'];
        $data['password'] = $userData['password'];
        $data['role'] = UserGroup::$GENERAL_CUSTOMER;

        return [
            'userObject'=>User::create($data),
            'initPassword' => $initPassword
        ];
    }

    /**
     * 展示客户自己的profile
     * @param null $uuid
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function my_profile($uuid=null, Request $request){
        if($uuid && $uuid == session('user_data.uuid')){
            // 表示当前的用户是正常的
            /**
             * @var User $user
             */
            $user = User::find(session('user_data.id'));
            $this->dataForView['menuName'] = 'my_profile';
            $this->dataForView['user'] = $user;
            $this->dataForView['studentProfileArray'] = $user->studentProfile->toArray();
            $this->dataForView['vuejs_libs_required'] = ['my_profile'];
            $this->dataForView['passportFields'] = StudentProfile::$passportFields;
            $this->dataForView['certsFields'] = StudentProfile::$certsFields;

            return view(
                _get_frontend_theme_path('customers.my_profile'),
                $this->dataForView
            );
        }

        if($request->isMethod('post')){
            // 客户更新Profile的申请
            if($request->get('id') == session('user_data.uuid')){
                // 正常状况
                $user = User::find(session('user_data.id'));
                $data = $request->all();
                if(isset($data['_token']))
                    unset($data['_token']);
                if(isset($data['id']))
                    unset($data['id']);

                foreach ($data as $fieldName => $fieldValue) {
                    $user->$fieldName = $fieldValue;
                }
                if($user->save()){
                    session()->flash('msg', ['content' => 'Your profile has been updated successfully!', 'status' => 'success']);
                }else{
                    session()->flash('msg', ['content' => 'System is busy, please try later!', 'status' => 'danger']);
                }
                return redirect('frontend/my_profile/'.session('user_data.uuid'));
            }
        }
    }

    public function update_my_profile(Request $request){
        /**
         * @var User $user
         */
        $user = User::find(session('user_data.id'));
        if($user){
            $profile = $user->studentProfile;

            $storagePath = _buildUploadFolderPath();
            // 可能上传的文件
            foreach (StudentProfile::$passportFields as $passportField) {
                if($request->hasFile($passportField)){
                    // 个人护照
                    $profile->$passportField = $request->file($passportField)
                        ->store($storagePath, 'public');
                }
            }

            foreach (StudentProfile::$certsFields  as $certsField) {
                if($request->hasFile($certsField)){
                    // 个人护照
                    if($certsField == 'applying_exemptions_files'){
                        $uploaded = $request->file('applying_exemptions_files');
                        $files = [];
                        if(is_array($uploaded)){
                            foreach ($uploaded as $key=>$file) {
                                $path = $file->store($storagePath,'public');
                                $files[] = $path;
                            }
                        }else{
                            if($uploaded){
                                $path = $uploaded->store($storagePath,'public');
                                $files[] = $path;
                            }
                        }
                        $profile->applying_exemptions_files = $files;
                    }else{
                        $profile->$certsField = $request->file($certsField)
                            ->store($storagePath, 'public');
                    }
                }
            }

            $sp = $request->get('sp');
            foreach ($sp as $fieldName=>$value) {
                $profile->$fieldName = $value;
            }
            if($profile->save()){
                session()->flash('msg', ['content' => 'Your profile has been updated successfully!', 'status' => 'success']);
            }else{
                session()->flash('msg', ['content' => 'System is busy, please try later!', 'status' => 'danger']);
            }
            return redirect('frontend/my_profile/'.session('user_data.uuid'));
        }
    }

    /**
     * 客户顾客的登录密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_password(Request $request){
        if(session('user_data.uuid') == $request->get('id')){
            // 表示当前登录用户是准备操作的用户
            $user = User::GetByUuid($request->get('id'));
            if($user){
                $user->password = \Illuminate\Support\Facades\Hash::make($request->get('new_password'));
                if($user->save()){
                    session()->flash('msg', ['content' => 'Your password has been updated successfully!', 'status' => 'success']);
                }
            }else{
                session()->flash('msg', ['content' => 'System is busy, please try later!', 'status' => 'danger']);
            }
            return redirect('frontend/my_profile/'.session('user_data.uuid'));
        }
        return view('404',$this->dataForView);
    }
}
