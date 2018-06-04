<?php

namespace App\Models\Utils\Axcelerate;

use GuzzleHttp\Client as GuzzleHttpClient;

class AxcelerateClient
{
    private static $instance = null;
    private static $WEB_SERVICE_TOKEN = null;
    private static $API_TOKEN = null;
    private static $BASE_URL = null;    // 所要用到的API调用地址

    private static $restfulClient = null;   // RESTful 客户端

    private function __construct()
    {
        self::$WEB_SERVICE_TOKEN = env('AXCELERATE_WEB_TOKEN', false);
        self::$API_TOKEN = env('AXCELERATE_API_TOKEN', false);
        self::$BASE_URL = env('AXCELERATE_BASE_URL', 'https://admin.axcelerate.com.au/api/');
        self::$restfulClient = new GuzzleHttpClient();
    }

    public static function GetInstance(){
        if(self::$instance == null){
            self::$instance = new AxcelerateClient();
        }
        return self::$instance;
    }
}
