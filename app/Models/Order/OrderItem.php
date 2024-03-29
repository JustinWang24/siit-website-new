<?php

namespace App\Models\Order;

use App\Models\Catalog\InTake;
use App\Models\Utils\OrderStatus;
use Carbon\Carbon;
use FlipNinja\Axcelerate\Courses\Instance;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use App\Models\Catalog\Product;
use App\Models\Catalog\Product\OptionItem;

class OrderItem extends Model
{
    protected $fillable = [
        'uuid','serial_number','operator_id',
        'user_id','product_id','operator_name','product_name',
        'subtotal','quantity','price','order_id',
        'status','payment_type','notes','discount','discount_reason','intake_start_date','intake_id','finish_date'
    ];

    public $dates = ['intake_start_date','finish_date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    /**
     * 持久化一个订单的Item
     * @param Order $order
     * @param CartItem $cartItem
     * @param string $operatorName
     * @param int $cartItemIndex
     * @param Instance|null $instance
     * @return bool
     * @throws \Exception
     */
    public static function Persistent(Order $order, CartItem $cartItem, $operatorName='n.a', $cartItemIndex=0, Instance $instance=null){
        $product = Product::GetByUuid($cartItem->id);

        if($product){
            $notes = '';
            $options = $cartItem->options;

            // 用来保存订单项中的产品的附加Option所带来的价格增量
            $priceExtra = 0;

            /**
             * @var InTake $intake
             */
            $intake = null;

            if($options && count($options)>0){
                foreach ($options as $key => $option) {
                    // 专门处理产品的Colour
                    if ($key === 'colour'){
                        $extra_money = $option['extra_money']>0 ? ' +'.config('system.CURRENCY').number_format($option['extra_money'],2) : null;
                        $name = '<span class="note-option-name">Colour: </span>';
                        $value = '<span class="note-option-value">'
                            .$option['name']
                            .$extra_money
                            .'</span>';
                        $notes .= '<p class="note-option-item">'.$name.$value.'</p>';
                    }

                    if($key === 'intake' && !empty($option)){
                        $intake = InTake::find($option);
                        if($intake){
                            $name = '<span class="note-option-name">'.trans('general.Intake').': </span>';
                            $value = '<span class="note-option-value">'
                                .$intake->title.' '
                                .$intake->online_date->format('d/M/Y') . '-' . $intake->offline_date->format('d/M/Y')
                                .'</span>';
                            $notes .= '<p class="note-option-item">'.$name.$value.'</p>';
                            // 把有效的座位减去一个
                            if($intake->seats > 0){
                                $intake->seats = $intake->seats - 1;
                                $intake->save();
                            }
                        }
                    }

                    if($key === 'productOptions' && !empty($option)){
                        $currentOptions = explode(',',$option);
                        foreach ($currentOptions as $currentOptionId) {
                            /**
                             * @var OptionItem $optionItem
                             */
                            $optionItem = OptionItem::find($currentOptionId);
                            if($optionItem){
                                $name = '<span class="note-option-name">'.$optionItem->productOption->name.': '.$optionItem->label.'</span>';
                                if($optionItem->extra_value > 0){
                                    $value = '<span class="note-option-value">$'.$optionItem->extra_value.'</span>';
                                }else{
                                    $value = '<span class="note-option-value"></span>';
                                }
                                $notes .= '<p class="note-option-item">'.$name.$value.'</p>';
                            }
                        }
                    }

                    if (is_array($option) && isset($option['name']) && isset($option['value'])){
                        // 处理非 Colour 的选项
                        $name = '<span class="note-option-name">'.$option['name'].'</span>';
                        $value = '<span class="note-option-value">'.$option['value'].'</span>';
                        $notes .= '<p class="note-option-item">'.$name.$value.'</p>';
                    }
                    $priceExtra += self::ParseProductOptionDataInCart($option);
                }
            }

            $theProductPrice = $product->getSpecialPriceGST() ? $product->getSpecialPriceGST() : $product->getDefaultPriceGST();
            if(is_string($theProductPrice)){
                $theProductPrice = floatval(str_replace(',','',$theProductPrice));
            }
            $priceFinal = $theProductPrice + $priceExtra;

            $intake_start_date = null;
            $intake_finish_date = null;
            if($instance){
                $intake_start_date = $instance->get('startdate')=='n.a'
                    ? Carbon::tomorrow('Australia/Melbourne')
                    : $instance->get('startdate');

                if (is_string($intake_start_date)){
                    $intake_start_date = Carbon::parse($intake_start_date);
                }

                $intake_finish_date = $instance->get('finishdate')=='n.a'
                    ? null
                    : $instance->get('finishdate');
            }

            $dataOrderItem = [
                'order_id'=>$order->id,
                'uuid'=>Uuid::uuid4()->toString(),
                'serial_number'=>$order->serial_number.'-'.$cartItemIndex,
                'user_id'=>$order->user_id,
                'product_id'=>$product->id,
                'operator_name'=>$operatorName.'-'.$product->brand,
                'product_name'=>$product->name,
                // Use special price if possible
                'price'=>$priceFinal,
                'quantity'=>$cartItem->qty,
                'subtotal'=>$cartItem->qty * $priceFinal,
                /**
                 * 订单项的状态初始是 PENDING, 因为某个订单项有可能是无法完成的
                 */
                'status'=>OrderStatus::$PENDING,
                'payment_type'=>$order->payment_type,
                'notes'=>$notes,
                'in_take_id'=>$intake ? $intake->id : null,
                'intake_start_date' =>$intake ? $intake->online_date : $intake_start_date,
                'finish_date'       =>$intake ? $intake->offline_date : $intake_finish_date
            ];

            $orderItem = self::create($dataOrderItem);
            if($orderItem){
                return $orderItem->subtotal;
            }else{
                return false;
            }
        }
        return false;
    }

    /**
     * 解析购物车对象中的option数组, 取出正确的附加价值浮点数然后返回
     * @param $optionData
     * @return float|int
     */
    public static function ParseProductOptionDataInCart($optionData){
        if(is_array($optionData)){
            $validValueString = null;
            if(isset($optionData['value']) && $optionData['value']){
                $validValueString =  $optionData['value'];
            }

            if(isset($optionData['extra_money']) && $optionData['extra_money']){
                $validValueString =  $optionData['extra_money'];
            }

            if($validValueString && strpos($validValueString,config('system.CURRENCY')) !== false){
                list($useless, $floatValueString) = explode(config('system.CURRENCY'), $validValueString);
                if(strlen($floatValueString)>0){
                    // 附加的价值是不可能为负值的, 如果为负值, 则返回0
                    return floatval($floatValueString)>=0 ? floatval($floatValueString) : 0;
                }else{
                    return 0;
                }
            }
        }else{
            // 不是数组, 直接返回0
            return 0;
        }
    }
}
