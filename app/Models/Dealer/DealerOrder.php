<?php

namespace App\Models\Dealer;

use App\Models\Group;
use App\Models\Order\Order;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'group_id','order_id','user_id',
        'order_serial_number','order_total','order_status'
    ];

    public function student(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function dealer(){
        return $this->belongsTo(Group::class,'group_id');
    }

    public function order(){
        return $this->belongsTo(Order::class);
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
