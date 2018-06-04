<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalog\InTake;
use App\Models\Catalog\Product;

class IntakesController extends Controller
{
    /**
     * 开学列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $this->dataForView['intakes'] = InTake::orderBy('id','desc')->paginate(config('system.PAGE_SIZE'));
        $this->dataForView['menuName'] = 'intakes';
        return view('backend.pages.index_intakes', $this->dataForView);
    }

    /**
     * 添加开学的表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        $this->dataForView['menuName'] = 'intakes';
        $intake = new InTake();
        $this->dataForView['courses'] = Product::all();
        $this->dataForView['intake'] = $intake;
        $this->dataForView['vuejs_libs_required'] = [
            'intake_manager'
        ];
        return view('backend.pages.intake_form', $this->dataForView);
    }

    /**
     * 加载开学视图
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request){
        $this->dataForView['intake'] = InTake::find($id);
        $this->dataForView['courses'] = Product::all();
        $this->dataForView['menuName'] = 'intakes';
        $this->dataForView['actionName'] = 'edit';
        $this->dataForView['vuejs_libs_required'] = [
            'intake_manager'
        ];
        return view('backend.pages.intake_form', $this->dataForView);
    }

    /**
     * 删除员工
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id){
        $page = InTake::find($id);
        if($page){
            $page->delete();
        }
        return redirect('backend/intakes/index');
    }
}
