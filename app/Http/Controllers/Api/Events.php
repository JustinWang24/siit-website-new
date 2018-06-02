<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Event;
use App\Models\Utils\JsonBuilder;

class Events extends Controller
{
    /**
     * 为后台提供的保存 Event 信息的方法
     * @param Request $request
     * @return string
     */
    public function save(Request $request){
        $pageData = $request->get('event');
        if($pageId = Event::Persistent($pageData)){
            return JsonBuilder::Success([
                'msg'=>$pageId
            ]);
        }else{
            return JsonBuilder::Error();
        }
    }

    /**
     * 判断是否uri已经存在了
     * @param Request $request
     * @return string
     */
    public function is_uri_unique(Request $request){
        // 检查给定的ID
        $id = $request->get('id');
        if(empty($id)){
            // 这个相当于新添加页面时的验证
            $page = Event::where('uri',$request->get('uri'))->first();
        }else{
            // 这个相当于修改页面时的验证
            $page = Event::where('uri',$request->get('uri'))->where('id','<>',$id)->first();
        }

        return $page ? JsonBuilder::Error() : JsonBuilder::Success();
    }
}
