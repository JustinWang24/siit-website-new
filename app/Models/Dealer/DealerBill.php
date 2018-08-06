<?php

namespace App\Models\Dealer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DealerBill extends Model
{
    use SoftDeletes;

    const STATUS_PENDING            = 1;
    const STATUS_DEALER_CONFIRMED   = 2;
    const STATUS_APPROVED           = 3;
    const STATUS_PAID               = 4;

    protected $fillable = [
        'group_id','start_at','end_at','total','status'
    ];

    public $dates = ['start_at','end_at','created_at','updated_at'];

    /**
     * 账单关联的订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(){
        return $this->hasMany(DealerBillOrder::class);
    }

    /**
     * 账单所关联的订单数
     * @return int
     */
    public function orderCount(){
        return DealerBillOrder::where('dealer_bill_id',$this->id)
            ->count();
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
