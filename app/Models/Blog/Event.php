<?php

namespace App\Models\Blog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utils\ContentTool;

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

    public static function Persistent($data){
        $data = ContentTool::RemoveNewLine($data);

        // URI的处理
        if(substr($data['uri'],0,1) !== '/'){
            $data['uri'] = '/'.$data['uri'];
        }

        // 处理Event 的结束和开始时间 Fri Jun 01 2018 20:00:00 GMT+1000 (AEST)

        if(!isset($data['id']) || is_null($data['id']) || empty(trim($data['id']))){
            unset($data['id']);
            $data['content'] = $data['content'];
            // 处理Event 的结束和开始时间 2018-06-12T00:00:00.000Z
            $data['start'] = Carbon::parse($data['start'])->setTimezone('Australia/Melbourne');
            $data['end'] = Carbon::parse($data['end'])->setTimezone('Australia/Melbourne');

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

            // 处理Event 的结束和开始时间 2018-06-12T00:00:00.000Z
            if(strpos($data['start'],'.000Z') !== false){
                $data['start'] = Carbon::parse($data['start'])->setTimezone('Australia/Melbourne');
            }
            if(strpos($data['end'],'.000Z') !== false) {
                $data['end'] = Carbon::parse($data['end'])->setTimezone('Australia/Melbourne');
            }

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
