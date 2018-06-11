<?php

namespace App\Models\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $casts = [
        'applying_exemptions_files' => 'array', // 可能保存多个文件的路径
        'gender' => 'boolean',
        'disability_required' => 'boolean',
        'is_pr' => 'boolean',
        'applying_exemptions' => 'boolean',
        'authorize_to_agent' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * 持久化学生的profile
     * @param $data
     * @param User $user
     * @param bool $isUpdateAction
     * @return bool
     */
    public static function Persistence($data, User $user, $isUpdateAction = false){
        if($isUpdateAction){
            $row = $user->studentProfile;
        }else{
            $row = new StudentProfile();
        }

        $data['user_id'] = $user->id;
        foreach ($data as $fieldName => $fieldValue) {
            $row->$fieldName = $fieldValue;
        }
        return $row->save();
    }

    public function t(){

    }
}
