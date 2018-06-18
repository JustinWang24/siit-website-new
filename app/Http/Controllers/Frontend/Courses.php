<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Utils\Axcelerate\AxcelerateClient;
use App\User;
use FlipNinja\Axcelerate\Users\AxUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class Courses extends Controller
{

    public function my_courses(Request $request){
        $this->dataForView['menuName'] = 'my_courses';
        $user = User::GetById($request->session()->get('user_data.id'));
        if(!$user){
            // 没有登录或者session expired, 去登录
            return redirect()->route('customer_login');
        }

        $this->dataForView['user'] = $user;
        if($this->_needLoginToAxcelerate()){
            // todo 检查是否有自动登录的可能
            // 获取登录Axe的信息
            $loginDetail = $user->getDecryptAxeLoginDetail();
            // 定义是否登录成功的标志
            $axLoginSuccess = false;

            if(!empty($loginDetail)){
                // todo 保存过信息, 则去尝试登录
                $axUser = $this->_tryToLoginToAxe($user);
                if($axUser){
                    if($axUser->isLoggedIn()){
                        // 把需要的ax相关登录信息保存到session中
                        $this->_saveAxUserInSession($axUser);
                        $axLoginSuccess = true;
                    }else{
                        // 不算登录成功
                        $request->session()->flash('msg',['content'=>$axUser->getLoginErrorMessage(),'status'=>'danger']);
                    }
                }
            }

            if(!$axLoginSuccess){
                // todo 没有保存过信息, 或者自动登录失败, 则显示登录表单
                return view(_get_frontend_theme_path('customers.axe.login'),$this->dataForView);
            }
            // 自动登录成功了
        }

        // todo 不需要登录操作
    }

    public function my_courses_login(Request $request){
        $student = $request->get('student');
        $user = User::GetById($request->session()->get('user_data.id'));
        $user->getEncryptAxeLoginDetail(
            $student['username'],
            $student['password']
        );
        if($user->save()){
            Session::put('user_data.ax_login',$user->axc_login_details);
        }
        return redirect()->route('student_courses');
    }

    /**
     * 尝试让当前的用户登录
     * @param User $user
     * @return bool|\FlipNinja\Axcelerate\Users\AxUser
     */
    private function _tryToLoginToAxe(User $user){
        $axeLoginDetail = $user->getDecryptAxeLoginDetail();
        if(!is_array($axeLoginDetail) || !isset($axeLoginDetail['username']) || !isset($axeLoginDetail['password'])){
            return false;
        }
        return AxcelerateClient::GetInstance()->users()->login($axeLoginDetail['username'], $axeLoginDetail['password']);
    }

    /**
     * 把登录成功后的信息保存到session中
     * @param AxUser $axUser
     */
    private function _saveAxUserInSession(AxUser $axUser){
        Session::put('user_data',[
            // 和Axe使用相关的信息
            'ax_user_id'    =>$axUser->id,
            'ax_token'      =>$axUser->get('axtoken'),
            'ax_expired_at' =>$axUser->get('expires')
        ]);
    }
}
