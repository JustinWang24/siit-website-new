<?php

namespace App\Models\Settings;

class PaymentMethod
{
    const MODE_OFF  = 'off';    // 表示不适用
    const MODE_TEST = 'test';   // 表示测试模式
    const MODE_LIVE = 'live';   // 表示生产模式

    public $timestamps = false;
    protected $fillable = [
        'name',
        'method_id',
        'api_token_test',
        'api_token',
        'api_secret_test',
        'api_secret',
        'hook_success',
        'hook_error',
        'notes',
        'mode',
    ];


    /**
     * 获取所有的有效支付方式, 只要不是Off即可
     * @return mixed
     */
    public static function GetAllAvailable(){
        return [];
    }

    /**
     * 获取Stripe的 secret
     * @return string
     */
    public static function GetStripeSecret(){
        return env('STRIPE_API_SECRET','sk_test_cFdBdJuw7c6RL5o5Qk7NTfBt');
    }

    /**
     * 根据当前的mode自动返回
     * @return string
     */
    public function getApiToken(){
        return env('STRIPE_API_TOKEN','pk_test_OMlRUa8UTaXOn2FW8Aj3ZwLg');
    }

    /**
     * 根据当前的mode自动返回对应的secret
     * @return string
     */
    public function getApiSecret(){
        return env('STRIPE_API_SECRET','sk_test_cFdBdJuw7c6RL5o5Qk7NTfBt');
    }

    /**
     * 是否为生产模式
     * @return bool
     */
    public function isLiveMode(){
        return env('STRIPE_API_TOKEN',false);
    }

    /**
     * 是否为测试模式
     * @return bool
     */
    public function isTestMode(){
        return env('STRIPE_API_TOKEN',false) === false;
    }
}
