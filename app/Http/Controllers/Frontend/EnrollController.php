<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\IntakeItem;
use App\Models\Group;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnrollController extends Controller
{

    /**
     * 学生注册课程的表单显示
     * @param $intakeItemId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function course_enroll($intakeItemId, Request $request){
        $intakeItem = IntakeItem::GetById($intakeItemId);

        // 检查是否为agent来的信息
        $agentCode = $request->get('agent');
        if($agentCode){
            // 根据给定的值, 查询经销商 ID 或者 Code
            $this->dataForView['dealer'] = Group::where('group_code',$agentCode)
                ->orWhere('id',$agentCode)
                ->first();
        }

        // 检查是否能够提取出用户的信息
        if($request->has('sd') && empty($request->session()->get('user_data'))){
            // 表示用户没有登录
            $uuid = $request->get('sd');
            $user = User::GetByUuid($uuid);
            if($user){
                $this->_saveUserInSession($user);
            }
        }

        if($intakeItem){
            $today = Carbon::today();
            $course = $intakeItem->inTake->course;
            // 如果该课程已经过期了
            if($intakeItem->scheduled < $today){
                // 已经过了开学时间了, 那么显示已经过期页面
                session()->flash('msg', ['content' => 'The intake date of "'.$course->name.'" is not available, please choose another date!', 'status' => 'danger']);
                return redirect('/catalog/product/'.$course->uri);
            }else{
                $this->dataForView['intakeItem'] = $intakeItem;
                $this->dataForView['course'] = $course;

                $this->dataForView['pageTitle'] = 'Intake Latest';
                $this->dataForView['metaKeywords'] = 'Intake Latest';
                $this->dataForView['metaDescription'] = 'Intake Latest';

                return view(_get_frontend_theme_path('enroll.course_enroll'),$this->dataForView);
            }
        }else{
            return view(_get_frontend_theme_path('pages.404'),$this->dataForView);
        }
    }
}
