<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 6/8/18
 * Time: 10:28 PM
 */

namespace App\Http\Controllers\Group;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Dealer\DealerStudent;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->dataForView['pageTitle'] = 'Partner Portal';
    }

    /**
     * 显示经销商登录界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        return view('dealer.login.form',$this->dataForView);
    }

    /**
     * 经销商退出登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('group.login');
    }

    /**
     * 经销商登录的处理
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login_action(Request $request){
        $group = Group::Login($request->get('email'),$request->get('password'));
        if($group){
            // 登录成功
            $this->_saveGroupInSession($group);
            return redirect()->route('group.portal');
        }else{
            return redirect()->route('group.login');
        }
    }

    /**
     * 经销商首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function portal(Request $request){
        $this->dataForView['menuName'] = 'courses';
        $this->dataForView['products'] = Product::orderBy('name','asc')
            ->paginate(config('system.PAGE_SIZE'));

        return view('dealer.portal.index',$this->dataForView);
    }

    /**
     * 获取当前经销商的学生列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function students(Request $request){
        $this->dataForView['menuName'] = 'students';
        $this->dataForView['groupStudents'] = DealerStudent::where('group_id',$request->session()->get('group_data.id'))
            ->orderBy('id','desc')
            ->paginate(config('system.PAGE_SIZE'));
        return view('dealer.portal.students',$this->dataForView);
    }

    /**
     * 获取当前经销商的订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orders(Request $request){
        $this->dataForView['menuName'] = 'orders';
        $this->dataForView['groupStudents'] = DealerStudent::where('group_id',$request->session()->get('group_data.id'))
            ->orderBy('id','desc')
            ->paginate(config('system.PAGE_SIZE'));
        return view('dealer.portal.orders',$this->dataForView);
    }

    /**
     * 获取当前经销商的结算列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payments(Request $request){
        $this->dataForView['menuName'] = 'payments';
        $this->dataForView['groupStudents'] = DealerStudent::where('group_id',$request->session()->get('group_data.id'))
            ->orderBy('id','desc')
            ->paginate(config('system.PAGE_SIZE'));
        return view('dealer.portal.orders',$this->dataForView);
    }

    /**
     * @param Group $group
     */
    private function _saveGroupInSession(Group $group){
        Session::put('group_data',$group->toArray());
    }
}