<?php

namespace App\Models;

use App\Models\Dealer\DealerOrder;
use App\Models\Dealer\DealerStudent;
use App\Models\Shipment\DeliveryFee;
use App\Models\Utils\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Class Group 用户组
 * @package App\Models
 */
class Group extends Model
{
    const STATUS_ACTIVE  = 0;
    const STATUS_DISABLE = 1;

    const DEFAULT_COMMISSION_RATE   = 0;
    const DEFAULT_DISCOUNT_RATE     = 20; // 经销商的学生打八折

    public $timestamps = false;
    protected $fillable = [
        'name','phone','address','city','state','postcode',
        'country','has_min_order_amount','shipping_fee',
        'fax','status','extra','email','commission',
        'group_code','password','phone_alt','begin_at',
        'finish_at','contact_person','discount_rate'
    ];

    /**
     * 经销商所关联的学生
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupStudents(){
        return $this->hasMany(DealerStudent::class);
    }

    /**
     * 经销商关联的学生总数
     * @return int
     */
    public function studentsCount(){
        return DealerStudent::where('group_id',$this->id)
            ->count();
    }

    /**
     * 经销商所关联的订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupOrders(){
        return $this->hasMany(DealerOrder::class);
    }

    /**
     * 经销商所关联的订单总数
     * @return int
     */
    public function ordersCount(){
        return DealerOrder::where('group_id',$this->id)
            ->count();
    }

    /**
     * 该经销商的订单总额
     * @return int
     */
    public function ordersTotal(){
        $result = DealerOrder::select(DB::raw('SUM(order_total) as total'))
            ->where('group_id',$this->id)
            ->where('order_status',OrderStatus::$APPROVED)
            ->first();
        return $result->total ? $result->total : 0;
    }

    /**
     * 经销商登录
     * http://siit.test/catalog/product/Advanced-Diploma-of-Financial-Planning?agent=S600036
     * @param $username
     * @param $password
     * @return Group
     */
    public static function Login($username, $password){
        return self::where('email',$username)
            ->where('password',$password)
            ->where('status',self::STATUS_ACTIVE)
            ->first();
    }

    public static function GetByCode($code){
        return self::where('group_code',$code)
            ->where('status',self::STATUS_ACTIVE)
            ->first();
    }

    /**
     * 返回代理商的折扣率
     * @return float
     */
    public function getDiscountRate(){
        return self::DEFAULT_DISCOUNT_RATE/100;
    }

    /**
     * Persistent Group Data
     * @param $data
     * @return mixed
     */
    public static function Persistent($data){
        return self::create($data);
    }

    /**
     * 计算额外的邮寄费用. 如果没有给定用户, 那么运费返回无效的 -1
     * @param User $customer
     * @param int $orderAmount
     * @param float $totalWeight
     * @return int
     */
    public static function CalculateDeliveryCharge(User $customer=null, $orderAmount, $totalWeight = 0.0){
        if($customer){
            // 登录用户
            return DeliveryFee::CalculateFee(
                $customer->group_id,
                $orderAmount,
                $customer->country,
                $customer->state,
                $customer->postcode,
                $totalWeight
            );
        }else{
            // 未登陆用户, 返回 -1
            return -1;
        }
    }

    /**
     * 返回经销商地址
     * Return group address text
     * @return string
     */
    public function getAddressText(){
        return $this->address ?
            $this->address.', '.$this->city.' '.$this->postcode.', '.$this->state.' '.$this->country
            : null;
    }
}
