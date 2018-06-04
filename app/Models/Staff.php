<?php

namespace App\Models;

use App\Models\Catalog\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Utils\ContentTool;
use Hash;

class Staff extends Model
{
    use SoftDeletes;

    // 和员工的分组相关
    const TRAINING_STAFF = 1;
    const STAFF_MEMBERS = 2;

    // 和培训师种类相关
    const TRANSLATING_TRAINER               = 1;
    const INTERPRETING_TRAINER              = 2;
    const TESOL_FINANCIAL_PLANNING_TRAINER  = 3;

    // 和工作部门相关
    const DIVISION_ADMIN_STUDENT_SERVICE    = 1;
    const DIVISION_MARKETING                = 2;
    const DIVISION_FINANCE                  = 3;

    // 特殊页面
    const PAGE_TRAINING_STAFF = 'training-staff';
    const PAGE_STAFF_MEMBERS = 'staff-members';

    protected $fillable = [
        'type',
        'job_group',
        'division',
        'brand_id', // 所属的campus
        'name',
        'feature_image',
        'job_title',
        'content',
        'email',
        'phone',
        'fax',
        'password',

        'status',
        'staff_badge_code', // 员工的编号
        'wechat_qrcode',   // 员工的微信ID
    ];

    /**
     * 员工所属的校区
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campus(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    /**
     * 获取员工的头像
     * @return string
     */
    public function getAvatarUrl(){
        return asset($this->feature_image);
    }

    /**
     * 获取Training Staff
     * @param $type
     * @return array
     */
    public static function RetrieveTrainingStaffItems($type){
        $campuses = Brand::where('status',true)->orderBy('name','desc')->get();
        $data = [];
        foreach ($campuses as $campus) {
            $data[$campus->name] = self::where('type',$type)
                ->where('status',true)
                ->where('brand_id',$campus->id)
                ->orderBy('job_group','asc')
                ->orderBy('name')
                ->get();
        }
        return $data;
    }

    /**
     * 获取 Staff Members
     * @return array
     */
    public static function RetrieveStaffMembers(){
        return self::where('type',self::STAFF_MEMBERS)
            ->where('status',true)
            ->orderBy('division','asc')
            ->orderBy('name')
            ->get();
    }

    /**
     * 持久化Staff
     * @param $data
     * @return int
     */
    public static function Persistent($data){
        $data = ContentTool::RemoveNewLine($data);

        /**
         * 如果给定了密码，则产生加密的密码
         */
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

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

    /**
     * 和获取工作部门相关的方法
     * @return array
     */
    public static function GetStaffTypes(){
        return [
            self::TRAINING_STAFF => 'Training Staff',
            self::STAFF_MEMBERS => 'Staff Members',
        ];
    }

    public static function GetStaffTypeName($key){
        $groups = self::GetStaffTypes();
        return isset($groups[$key]) ? $groups[$key] : 'N.A';
    }

    /**
     * 和获取工作部门相关的方法
     * @return array
     */
    public static function GetDivisions(){
        return [
            self::DIVISION_ADMIN_STUDENT_SERVICE => 'Admission & Student Services Division',
            self::DIVISION_MARKETING => 'Marketing Division',
            self::DIVISION_FINANCE => 'Finance Division',
        ];
    }

    public static function GetDivisionName($key){
        $groups = self::GetDivisions();
        return isset($groups[$key]) ? $groups[$key] : 'N.A';
    }

    /**
     * 和获取培训师种类相关的方法
     * @return array
     */
    public static function GetJobGroups(){
        return [
            self::TRANSLATING_TRAINER => 'Translating Trainer',
            self::INTERPRETING_TRAINER => 'Interpreting Trainer',
            self::TESOL_FINANCIAL_PLANNING_TRAINER => 'TESOL & Financial Planning Trainer',
        ];
    }

    public static function GetJobGroupName($key){
        $groups = self::GetJobGroups();
        return isset($groups[$key]) ? $groups[$key] : 'N.A';
    }
}
