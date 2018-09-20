<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog\Event;

class Events extends Controller
{
    /**
     * 新闻列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $this->dataForView['pages'] = Event::orderBy('start','desc')->paginate(config('system.PAGE_SIZE'));
        $this->dataForView['menuName'] = 'events';
        return view('backend.pages.index_events', $this->dataForView);
    }

    /**
     * 添加新闻的表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        $this->dataForView['menuName'] = 'events';
        $page = new Event();
        $this->dataForView['page'] = $page;
        $this->dataForView['vuejs_libs_required'] = [
            'events_manager'
        ];
        return view('backend.pages.event_form', $this->dataForView);
    }

    /**
     * 加载新闻视图
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request){
        $this->dataForView['page'] = Event::find($id);
        $this->dataForView['menuName'] = 'events';
        $this->dataForView['actionName'] = 'edit';
        $this->dataForView['vuejs_libs_required'] = [
            'events_manager'
        ];
        return view('backend.pages.event_form', $this->dataForView);
    }

    /**
     * 删除新闻
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id){
        $page = Event::find($id);
        if($page){
            $page->delete();
        }
        return redirect('backend/events/index');
    }
}
