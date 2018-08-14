<?php

namespace App\Http\Controllers\Backend;

use App\Models\Dealer\DealerOrder;
use App\Models\Dealer\DealerStudent;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Groups extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 经销商后台管理 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $this->dataForView['groups'] = Group::where('id','>',1)->orderBy('name','asc')->paginate(config('system.PAGE_SIZE'));
        $this->dataForView['menuName'] = 'groups';
        return view('backend.groups.index', $this->dataForView);
    }

    public function import(){
        $files = scandir(__DIR__.'/tmp');

        $done = [
            'Agentlist -CHINESE+VIETNAMESE + KOREAN.XLSX',
            'BNE Agent List.xlsx',
            'Chinese Agents List - 23052018-1.xls',
            '.DS_Store',
            'Hindi Punjabi  Agent Email.xlsx',
            'Minor language Agent List&MELAgent List-1.xlsx'
        ];

        $groupCodeStart = 600000;

        foreach ($files as $file) {
            if(in_array($file,$done)){
                continue;
            }

            if($file != '.' && $file != '..'){
                $fileName = __DIR__.'/tmp/'.$file;

                try{
                    $type = strpos(strtolower($file),'.xlsx') !== false ? 'Xlsx' : 'Xls';
                    $reader = IOFactory::createReader($type);
                    $spreadsheet = $reader->load($fileName);

                    foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
                        $worksheetTitle = $worksheet->getTitle();
                        dump($worksheetTitle);
                        foreach ($worksheet->getRowIterator() as $row) {
                            $cellIterator = $row->getCellIterator();
                            $cellIterator->setIterateOnlyExistingCells(false);
                            if($row->getRowIndex() > 1){
                                $group = new Group();
                                foreach ($cellIterator as $key=>$cell) {
                                    switch ($key){
                                        case 'A':
                                            $group->name = $cell;
                                            break;
                                        case 'B':
                                            $group->email = $cell;
                                            break;
                                        case 'C':
                                            $group->address = $cell;
                                            break;
                                        case 'D':
                                            $group->phone = $cell;
                                            break;
                                        case 'E':
                                            $group->contact_person = $cell;
                                            break;
                                        case 'F':
                                            $group->extra = $cell;
                                            break;
                                        default:
                                            break;
                                    }
                                }

                                if(!empty(trim($group->name))){
                                    $group->category = $worksheetTitle;
                                    $group->group_code = substr($worksheetTitle,0,1).($groupCodeStart++);
                                    $group->password = '123456';
                                    $group->save();
                                }
                            }
                        }
                        dump('done');
                        die(0);
                    }

                }catch (\Exception $exception){
                    dump($exception->getMessage());
                }
            }

        }

    }

    public function add(){
        $this->dataForView['group'] = new Group();
        $this->dataForView['menuName'] = 'groups';
        return view('backend.groups.form', $this->dataForView);
    }

    public function edit($id){
        $this->dataForView['group'] = Group::find($id);
        $this->dataForView['menuName'] = 'groups';
        return view('backend.groups.form', $this->dataForView);
    }

    public function delete($id){
        Group::where('id',$id)->delete();
        return redirect()->route('groups');
    }

    /**
     * 保存经销商信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request){
        $groupData = $request->all();
        unset($groupData['_token']);

        if(empty($groupData['id'])){
            unset($groupData['id']);
            Group::Persistent($groupData);
        }else{
            $id = $groupData['id'];
            unset($groupData['id']);

            Group::where('id', $id)
                ->update($groupData);
        }

        return redirect()->route('groups');
    }

    /**
     * 查看某个经销商的学生
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view_students(Request $request){
        $this->dataForView['dealer'] = Group::find($request->get('group'));
        $this->dataForView['ds'] = DealerStudent::where('group_id',$request->get('group'))
            ->orderBy('user_id','desc')
            ->paginate(config('system.PAGE_SIZE'));
        return view('backend.groups.students',$this->dataForView);
    }

    /**
     * 查看某个经销商的订单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view_orders(Request $request){
        $this->dataForView['dealer'] = Group::find($request->get('group'));
        $this->dataForView['dos'] = DealerOrder::where('group_id',$request->get('group'))
            ->orderBy('id','desc')
            ->paginate(config('system.PAGE_SIZE'));
        return view('backend.groups.orders',$this->dataForView);
    }
}
