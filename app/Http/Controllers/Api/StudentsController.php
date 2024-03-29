<?php

namespace App\Http\Controllers\Api;

use App\Mail\UserConfirmEmail;
use App\Mail\UserVerificationCode;
use App\Models\Dealer\DealerStudent;
use App\Models\User\StudentProfile;
use App\Models\Utils\JsonBuilder;
use App\Models\Utils\UserGroup;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;

class StudentsController extends Controller
{
    /**
     * 注册的时候， 如果点击下一步， 就会保存学生的profile
     * @param Request $request
     * @return string
     */
    public function save_profile_ajax(Request $request){
        $data = $request->all();
        $bean = [];

        foreach ($data as $item) {
            $name = str_replace('student[','',$item['name']);
            $name = str_replace(']','',$name);
            $bean[$name] = empty($item['value']) ? '0' : $item['value'];
        }

        $user = isset($bean['user_id']) ? User::GetByUuid($bean['user_id']) : null;
        if($user){
            $profile = $user->studentProfile;
            if(is_null($profile)){
                // 表示这个学生还没有自己的Profile
                $profile = new StudentProfile();
                $profile->user_id = $user->id;
            }
            foreach ($bean as $fieldName=>$value) {
                if($fieldName !== 'user_id'){
                    $profile->$fieldName = $value;
                }
            }
            $profile->save();
            return JsonBuilder::Success();
        }
        return JsonBuilder::Error();
    }

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
                if(!env('APP_DEBUG', false)){
                    Mail::to($email)->send(new UserVerificationCode($vCode,$name));
                }
            }
        }

        return JsonBuilder::Success($result);
    }

    /**
     * 学生在Intake之前，如果还没在系统有账户，那么会先通过这个方式常见自己的账户
     * @param Request $request
     * @return string
     * @throws \Exception
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
            'group_id'=>$data['group_id'],
            'status'=>true
        ]);

        if($user){
            StudentProfile::Persistence([],$user);
            // 如果注册成功，需要给学生发送电子邮件
            Mail::to(trim($data['email']))->send(new UserConfirmEmail($user, $data['password']));
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

    /**
     * 加载指定学生的所提交过的附件文档的方法
     * @param Request $request
     * @return string
     */
    public function load_student_documents_ajax(Request $request){
        $studentUuid = $request->get('uuid');
        $user = User::GetByUuid($studentUuid);
        if($user && (env('APP_DEBUG')) ? true : $user->isStudent()){
            $data = [
                'passport'      =>$user->passportDocuments(),
                'education'     =>$user->documentsForEducationAndAcademicAchievements(),
                'english'       =>$user->documentsForEnglishLanguageProficiency(),
                'recognition'   =>$user->documentsForRecognitionOfPriorLearning(),
            ];
            return JsonBuilder::Success($data);
        }
        return JsonBuilder::Error();
    }

    /**
     * 管理后台搜索学生的功能
     * @param Request $request
     * @return string
     */
    public function search_ajax(Request $request){
        $result = [];

        if($request->get('d')){
            $where = [
                ['student_name','like','%'.$request->get('s').'%'],
                ['group_id','=',$request->get('d')]
            ];
            $ds = DealerStudent::where($where)
                ->orderBy('id','desc')
                ->take(config('system.PAGE_SIZE'))
                ->get();
            foreach ($ds as $d) {
                $result[] = [
                    'value'=>$d->student_name,
                    'id'=>$d->user_id
                ];
            }
        }else{
            $users = User::where(['name','like','%'.$request->get('s').'%'])
                ->orderBy('id','desc')
                ->take(config('system.PAGE_SIZE'))
                ->get();
            foreach ($users as $user) {
                $result[] = [
                    'value'=>$user->name,
                    'id'=>$user->id
                ];
            }
        }
        return count($result)>0 ? JsonBuilder::Success($result) : JsonBuilder::Error();
    }
}
