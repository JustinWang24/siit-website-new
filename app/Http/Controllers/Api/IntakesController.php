<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalog\InTake;
use App\Models\Utils\JsonBuilder;

class IntakesController extends Controller
{
    /**
     * 为后台提供的保存 Intake 信息的方法
     * @param Request $request
     * @return string
     */
    public function save(Request $request){
        $pageData = $request->get('intake');
        if($pageId = InTake::Persistent($pageData)){
            return JsonBuilder::Success([
                'msg'=>$pageId
            ]);
        }else{
            return JsonBuilder::Error();
        }
    }
}
