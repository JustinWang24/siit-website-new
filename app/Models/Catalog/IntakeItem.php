<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class IntakeItem extends Model
{
    protected $fillable = ['in_take_id','language_id','seats','enrolment_count','scheduled'];
    protected $dates = ['scheduled'];

    const Mandarin      = 1;
    const Cantonese     = 2;
    const Korean        = 3;
    const Vietnamese    = 4;
    const Hindi         = 5;
    const Nepali        = 6;
    const Punjabi       = 7;

    public function inTake(){
        return $this->belongsTo(InTake::class);
    }

    /**
     * 获取语言的名称
     * @param $key
     * @return mixed|string
     */
    public static function GetLanguageName($key){
        $s = self::GetSupportedLanguages();
        return isset($s[$key]) ? $s[$key] : 'N.A';
    }

    public static function GetSupportedLanguages(){
        return [
            self::Mandarin => 'Mandarin',
            self::Cantonese => 'Cantonese',
            self::Korean => 'Korean',
            self::Vietnamese => 'Vietnamese',
            self::Hindi => 'Hindi',
            self::Nepali => 'Nepali',
            self::Punjabi => 'Punjabi'
        ];
    }
}
