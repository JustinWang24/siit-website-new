<?php

namespace App\Models\Dealer;

use App\Models\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DealerStudent extends Model
{
    protected $fillable = [
        'group_id','user_id','group_name','student_name'
    ];

    /**
     * 关联的经销商
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group(){
        return $this->belongsTo(Group::class);
    }

    /**
     * 关联的学生
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(){
        return $this->belongsTo(User::class);
    }

    /**
     * 保存
     * @param $data
     * @return mixed
     */
    public static function Persistent($data){
        return self::create($data);
    }
}
