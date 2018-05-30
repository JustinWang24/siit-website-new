<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    const PUBLIC_EVENT = 1;     // 公共的 Event
    const PRIVATE_EVENT = 2;    // 私密的 Event

    protected $fillable = [
        'layout',
        'title',
        'title_cn',
        'uri',
        'content',
        'seo_keyword',
        'seo_description',
        'feature_image',
        'type',
        'teasing',
        'start',
        'end',
        'location',
        'attendees_limit',
        'clicks',
    ];

    protected $dates = [
        'created_at','updated_at','start','end'
    ];
}
