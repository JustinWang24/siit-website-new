<?php

namespace App\Models\Dealer;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;

class DealerBillOrder extends Model
{
    protected $fillable = [
        'dealer_bill_id','order_id',
        'order_serial_number','order_total'
    ];

    public function dealerBill(){
        return $this->belongsTo(DealerBill::class);
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
