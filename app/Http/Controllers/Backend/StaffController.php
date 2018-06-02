<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Brand as Campus;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * 员工列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $this->dataForView['pages'] = Staff::orderBy('name','asc')->paginate(config('system.PAGE_SIZE'));
        $this->dataForView['allCampus'] = Campus::all();
        $this->dataForView['menuName'] = 'staff';
        return view('backend.pages.index_staff', $this->dataForView);
    }

    /**
     * 添加员工的表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        $this->dataForView['menuName'] = 'staff';
        $staff = new Staff();
        $this->dataForView['allCampus'] = Campus::all();
        $this->dataForView['staff'] = $staff;
        $this->dataForView['vuejs_libs_required'] = [
            'staff_manager'
        ];
        return view('backend.pages.staff_form', $this->dataForView);
    }

    /**
     * 加载员工视图
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request){
        $this->dataForView['staff'] = Staff::find($id);
        $this->dataForView['allCampus'] = Campus::all();
        $this->dataForView['menuName'] = 'staff';
        $this->dataForView['actionName'] = 'edit';
        $this->dataForView['vuejs_libs_required'] = [
            'staff_manager'
        ];
        return view('backend.pages.staff_form', $this->dataForView);
    }

    /**
     * 删除员工
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id){
        $page = Staff::find($id);
        if($page){
            $page->delete();
        }
        return redirect('backend/staff/index');
    }
}
