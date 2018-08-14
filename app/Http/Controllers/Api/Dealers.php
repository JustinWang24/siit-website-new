<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Models\Utils\JsonBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Dealers extends Controller
{
    /**
     * 搜索经销商
     * @param Request $request
     * @return string
     */
    public function search(Request $request){
        $dealers = Group::select('id','name','group_code','address')
            ->where('name','like','%'.$request->get('q').'%')
            ->orWhere('group_code','like','%'.$request->get('q').'%')
            ->take(20)
            ->get();

        $result = [];

        foreach ($dealers as $dealer) {
            $result[] = [
                'value'=>$dealer->name.' - '.$dealer->group_code,
                'address'=>$dealer->address,
                'id'=>$dealer->id
            ];
        }

        return count($result)>0 ? JsonBuilder::Success($result) : JsonBuilder::Error();
    }
}
