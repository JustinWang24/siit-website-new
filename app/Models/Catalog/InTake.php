<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 入学通知记录表
 * Class InTake
 * @package App\Models\Catalog
 */

class InTake extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'scheduled',
        'online_date',
        'offline_date',
        'clicks',
        'enrolment_count',
        'title',
        'code',
        'description',
        'description_cn',
        'last_updated_user_id',
    ];

    public $dates = [
        'scheduled','online_date','offline_date'
    ];
}
