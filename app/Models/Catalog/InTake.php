<?php

namespace App\Models\Catalog;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Utils\ContentTool;
use DB;

/**
 * 入学通知记录表
 * Class InTake
 * @package App\Models\Catalog
 */

class InTake extends Model
{
    use SoftDeletes;

    const TYPE_PUBLIC = 1;
    const TYPE_PRIVATE = 2;
    const TYPE_AGENT_ONLY = 3;
    const TYPE_INTERNAL_STAFF_ONLY = 4;

    protected $fillable = [
        'course_id',
        'type',
        'online_date',
        'offline_date',
        'title',
        'code',
        'seats',
        'description',
        'description_cn',
        'last_updated_user_id',
    ];

    public $dates = [
        'online_date','offline_date','created_at','updated_at'
    ];

    public function course(){
        return $this->belongsTo(Product::class,'course_id');
    }

    public function account(){
        return $this->belongsTo(User::class, 'last_updated_user_id');
    }

    public function intakeItems(){
        return $this->hasMany(IntakeItem::class);
    }

    public static function GetLatest(){

    }

    /**
     * 取得所有类型
     * @return array
     */
    public static function GetAllTypes(){
        return [
            self::TYPE_PUBLIC => 'Public',
            self::TYPE_PRIVATE => 'Private'
        ];
    }

    /**
     * 取得类型的名称
     * @param $type
     * @return mixed|string
     */
    public static function GetTypeName($type){
        $types = self::GetAllTypes();
        return isset($types[$type]) ? $types[$type] : 'N.A';
    }

    /**
     * 持久化 Intake
     * @param $data
     * @return int
     */
    public static function Persistent($data){
        $data = ContentTool::RemoveNewLine($data);
        if(!empty($data['online_date'])){
            $data['online_date'] = Carbon::parse($data['online_date'])->setTimezone('Australia/Melbourne');
        }
        if(!empty($data['offline_date'])){
            $data['offline_date'] = Carbon::parse($data['offline_date'])->setTimezone('Australia/Melbourne');
        }

        if(!isset($data['id']) || is_null($data['id']) || empty(trim($data['id']))){
            // 添加新的, 这个时候, 要同时生成所有的 ITEMS
            unset($data['id']);
            DB::beginTransaction();
            $page = self::create(
                $data
            );
            if($page){
                $langs = IntakeItem::GetSupportedLanguages();
                $allDone = true;
                foreach ($langs as $key=>$lang){
                    $allDone = IntakeItem::create(
                        [
                            'in_take_id'=>$page->id,
                            'language_id'=>$key,
                        ]
                    );
                    if(!$allDone){
                        break;
                    }
                }
                if($allDone){
                    DB::commit();
                    return $page->id;
                }else{
                    DB::rollback();
                    return 0;
                }
            }else{
                DB::rollback();
                return 0;
            }
        }else{
            $page = self::find($data['id']);
            unset($data['id']);

            foreach ($data as $field_name=>$field_value) {
                $page->$field_name = $field_value;
            }
            if($page->save()){
                return $page->id;
            }else{
                return 0;
            }
        }
    }
}
