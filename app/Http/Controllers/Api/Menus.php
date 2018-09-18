<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/16
 * Time: 23:11
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Utils\JsonBuilder;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
class Menus extends Controller
{
    public function submenu($id){
        $sublevel = intval($id -1);
        $submenus = Menu::where('level',$sublevel)->get(['id','name','name_cn']);
        return Response::json($submenus);
    }
}