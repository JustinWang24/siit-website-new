<?php

namespace App\Models\Catalog;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Utils\ContentTool;

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
        'scheduled',
        'online_date',
        'offline_date',
        'clicks',
        'seats',    // 最多报名人数
        'enrolment_count',  // 已报名人数
        'title',
        'code',
        'description',
        'description_cn',
        'last_updated_user_id',
    ];

    public $dates = [
        'scheduled','online_date','offline_date','created_at','updated_at'
    ];

    public function course(){
        return $this->belongsTo(Product::class,'course_id');
    }

    public function account(){
        return $this->belongsTo(User::class, 'last_updated_user_id');
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

        if(!isset($data['id']) || is_null($data['id']) || empty(trim($data['id']))){
            unset($data['id']);
            $page = self::create(
                $data
            );
            if($page){
                return $page->id;
            }else{
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
