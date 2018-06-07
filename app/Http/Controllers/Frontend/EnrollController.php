<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Catalog\IntakeItem;
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
