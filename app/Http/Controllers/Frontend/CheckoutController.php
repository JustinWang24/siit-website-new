<?php
/**
 * 网站前端用的结算控制器类
 */
namespace App\Http\Controllers\Frontend;

use App\Events\Order\Created as OrderCreated;
use App\Models\Settings\PaymentMethod;
use App\Models\Utils\OrderStatus;
use App\Models\Utils\Payment\RoyalPayTool;
use App\Models\Utils\PaymentTool;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
//use Omnipay;
use App\Events\OrderPlaced;
use App\Jobs\Payment\StripePayment;

class CheckoutController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pay_order(Request $request){
        $customer = User::GetByUuid($request->get('user'));
        $order = Order::GetByUuid($request->get('order'));
        $this->dataForView['order'] = $order;
        $this->dataForView['user'] = $customer;

        $this->dataForView['vuejs_libs_required'] = [
            'payment_accordion',
            'guest_checkout'
        ];

        return view(
            _get_frontend_theme_path('checkout.place_order_checkout'),
            $this->dataForView
        );
    }

    /**
     * 完成Place Order方式订单的方法
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Models\Utils\Payment\RoyalPay\Lib\RoyalPayException
     */
    public function place_order_checkout(Request $request){
        // 检查用户是否登录了, 如果没有登录,那么去登录页
        if(!session()->has('user_data.id')){
            $customer = null;
        }else{
            $customer = User::find(session('user_data.id'));
        }

        $order = Order::GetByUuid($request->get('order'));
        $this->dataForView['order'] = $order;

        // 首先确认是post方式并且检查用户选择的支付方式
        if($request->isMethod('post')){
            // 先尝试获取Customer的数据
            if(is_null($customer)){
                $customer = User::GetByUuid($request->get('customerUuid'));
                $this->_saveUserInSession($customer);
            }

            $paymentMethodFound = $request->has('payment_method') && PaymentTool::SupportThis($request->get('payment_method'));
            if(!$paymentMethodFound){
                // 客户没有选择支付方式, 那么就继续留在当前页面
                session()->flash(
                    'msg',
                    ['content' => 'Please select a valid payment method!', 'status' => 'danger']);
            }else{
                $order = Order::GetByUuid($request->get('order'));
                if($order){
                    // 保留提交的订单留言
                    if(!empty($request->get('notes'))){
                        $order->notes .= PHP_EOL . $request->get('notes');

                    }
                    $order->status = OrderStatus::$COMPLETE;
                    $order->save();
                    // 保存支付方式
//                    PaymentTool::GetMethodTypeById($request->get('payment_method'));


                    /**
                     * 订单生成成功, 发布订单创建事件
                     * 如果是Place Order, 那么不需要进行支付处理
                     */
                    if($request->get('payment_method') == PaymentTool::$METHOD_ID_PLACE_ORDER){
                        event(new OrderCreated($order, $customer,$request));
                        session()->flash('msg', ['content'=>'Order #'.$order->serial_number.' has been handled!','status'=>'success']);
                        // 默认的收款方式, 因此不需要更新订单的收费渠道了
                        // 将学生导向Offer letter的页面
                        return redirect('/frontend/my_orders/'.session('user_data.uuid'));
                    }elseif($request->get('payment_method') == PaymentTool::$METHOD_ID_WECHAT){
                        // 微信支付
                        $royalPayTool = new RoyalPayTool();
                        return redirect($royalPayTool->purchase($order)->getQrRedirectUrl());
                    }elseif($request->get('payment_method') == PaymentTool::$METHOD_ID_STRIPE){
                        // Stripe 信用卡支付
                        $job = new StripePayment($order, $request, $customer,new PaymentMethod());
                        if($job->handle()){
                            // 一切顺利
                            session()->flash('msg', ['content'=>'Order #'.$order->serial_number.' is in progress!','status'=>'success']);
                            return redirect('/frontend/my_orders/'.session('user_data.uuid'));
                        }else{
                            session()->flash('msg', ['content'=>'System is Busy, Please try again!','status'=>'danger']);
                        }
                    }else{
                        // 不是 place order 订单, 那么进行支付处理
                        event(new OrderPlaced(null,$customer,$request,$order));
                    }
                }else{
                    session()->flash('msg', ['content'=>'System is Busy, Please try again!','status'=>'danger']);
                }
            }
        }

        $this->dataForView['user'] = $customer;

        $this->dataForView['vuejs_libs_required'] = [
//            'paypal_button',
            'payment_accordion',
            'guest_checkout'
        ];

        return view(
            _get_frontend_theme_path('checkout.place_order_checkout'),
            $this->dataForView
        );
    }
}
