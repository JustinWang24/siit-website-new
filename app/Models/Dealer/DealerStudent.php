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
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 保存
     * @param Group $dealer
     * @param User $student
     * @return DealerStudent
     */
    public static function Persistent(Group $dealer, User $student){
        $ds = self::Locate($dealer, $student);
        if(empty($ds)){
            return self::create([
                'group_id'=>$dealer->id,
                'user_id'=>$student->id,
                'group_name'=>$dealer->name,
                'student_name'=>$student->name
            ]);
        }
        return $ds;
    }

    /**
     * @param Group $dealer
     * @param User $student
     * @return DealerStudent|null
     */
    public static function Locate(Group $dealer, User $student){
        return self::where('group_id',$dealer->id)
            ->where('group_id',$student->id)
            ->orderBy('id','desc')
            ->first();
    }
}
