<?php

namespace App\Http\Controllers\Backend;

use App\Models\Catalog\IntakeItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Catalog\InTake;
use App\Models\Catalog\Product;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

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

    /**
     * 加载 Intake 的所有 Items 并编辑
     * @param $intakeId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function items_manager($intakeId, Request $request){
        $this->dataForView['intake'] = InTake::find($intakeId);
        $this->dataForView['intakeItems'] = IntakeItem::where('in_take_id',$intakeId)->get();
        $this->dataForView['languages'] = IntakeItem::GetSupportedLanguages();
        $this->dataForView['menuName'] = 'intakes';
        $this->dataForView['vuejs_libs_required'] = [
            'intake_items_manager'
        ];
        return view('backend.pages.intake_item_form', $this->dataForView);
    }

    /**
     * 保存 Intake 的 Items
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save_items(Request $request){
        $inTakeId = $request->get('in_take_id');
        $itemIds = $request->get('item_id');
        $seats = $request->get('seats');
        $scheduled = $request->get('scheduled');
        foreach ($itemIds as $index => $id) {
            if(is_null($id)){
                IntakeItem::create([
                    'in_take_id'=>$inTakeId,
                    'language_id'=>$index+1,
                    'seats'=>$seats[$index],
                    'scheduled'=>$scheduled[$index],
                ]);
            }else{
                IntakeItem::where('id',$id)
                    ->where('in_take_id',$inTakeId)
                    ->update([
                        'seats'=>$seats[$index],
                        'scheduled'=>$scheduled[$index],
                    ]);
            }
        }
        return redirect('/backend/intakes/index');
    }
}
