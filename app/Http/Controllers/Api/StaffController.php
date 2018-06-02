<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Utils\JsonBuilder;

class StaffController extends Controller
{
    /**
     * 为后台提供的保存 Staff 信息的方法
     * @param Request $request
     * @return string
     */
    public function save(Request $request){
        $pageData = $request->get('staff');
        if($pageId = Staff::Persistent($pageData)){
            return JsonBuilder::Success([
                'msg'=>$pageId
            ]);
        }else{
            return JsonBuilder::Error();
        }
    }
}
