<?php

namespace App\Http\Controllers\Api;

use App\Mail\UserConfirmEmail;
use App\Mail\UserVerificationCode;
use App\Models\Utils\JsonBuilder;
use App\Models\Utils\UserGroup;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Ramsey\Uuid\Uuid;
use Mail;

class StudentsController extends Controller
{
    /**
     * 验证用户的邮件是否存在
     * @param Request $request
     * @return string
     */
    public function verify_email(Request $request){
        $email = trim($request->get('email'));
        $name = trim($request->get('name'));
        $result = [
            'result' => 'not_valid', // 假设: 用户提交的不是验证的有效邮件地址
            'vCode' => '',           // 如果用户提交的email不存在, 那么就返回验证码
            'emailExisted' => true,           // 假设: 用户提交的不是验证的有效邮件地址
        ];

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result['result'] = 'valid';
            $user = User::where('email',$email)->first();
            if(!$user){
                // 表示用户提供的电子邮件不存在
                $vCode = str_random(6);
                // 对返回前端的 vcode 进行一下变形
                $index = 3;
                $result['vCode'] = $this->transformVcode($vCode,$index);
                $result['id'] = $index;
                $result['emailExisted'] = false;
                if(!env('APP_DEBUG')){
                    Mail::to($email)
                        ->send(new UserVerificationCode($vCode,$name));
                }
            }
        }

        return JsonBuilder::Success($result);
    }

    /**
     * 学生在Intake之前，如果还没在系统有账户，那么会先通过这个方式常见自己的账户
     * @param Request $request
     * @return string
     */
    public function verify_register(Request $request){
        // 相当于学生注册
        $data = $request->get('student');
        $user = User::create([
            'name'=>trim($data['name']),
            'email'=>trim($data['email']),
            'password'=>Hash::make($data['password']),
            'uuid'=>Uuid::uuid4()->toString(),
            'role'=>UserGroup::$GENERAL_CUSTOMER,
            'group_id'=>$data['group_id']
        ]);

        if($user){
            // 如果注册成功，需要给学生发送电子邮件
            if(!env('APP_DEBUG')){
                Mail::to(trim($data['email']))->send(new UserConfirmEmail($user, $data['password']));
            }
            return JsonBuilder::Success(['uuid'=>$user->uuid]);
        }else{
            // 注册失败了
            return JsonBuilder::Error();
        }

        // 返回注册成功的学生的UUID
    }

    /**
     * 变形字符串
     * @param $vCode
     * @param $index
     * @return string
     */
    private function transformVcode($vCode,$index){

        $firstThree = substr($vCode,0,$index);
        $lastThree = substr($vCode,$index);
        return $lastThree.$firstThree;
    }
}
