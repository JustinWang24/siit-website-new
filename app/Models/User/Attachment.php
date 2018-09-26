<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 25/9/18
 * Time: 4:45 AM
 */

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attachment extends Model
{
    /**
     * 以前的教育经历或者获奖的证明文件
     */
    const EDUCATION_AND_ACADEMIC_ACHIEVEMENT    = 1;
    /**
     * 相关的英语水平证书与翻译件
     */
    const ENGLISH_CERTIFICATES_AND_TRANSCRIPT   = 2;
    /**
     * 之前的可用于转学分的证明文件
     */
    const RECOGNITION_OF_PREVIOUS_LEARNING      = 3;
    /**
     * 护照文件
     */
    const PASSPORT      = 4;

    public $timestamps = false;
    protected $table = 'attachments';
    protected $fillable = [
        'user_id','type','path','name'
    ];

    /**
     * 关联的学生账户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * 保存
     * @param $data
     * @return int
     */
    public static function Persistent($data){
        $model = new Attachment();
        if(isset($data['id']) && !empty($data['id'])){
            // 更新操作
            $id = $data['id'];
            unset($data['id']);
            return DB::table($model->table)->where('id',$id)->update($data);
        }else{
            return DB::table($model->table)->insertGetId($data);
        }
    }
}