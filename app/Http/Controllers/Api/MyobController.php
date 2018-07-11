<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyobController extends Controller
{
    private $myobApiKey;
    private $myobApiSecret;
    private $myobApiUrl;
    private $scope = 'CompanyFile';
    private $redirectUri = 'siit';

    private $myobApi = null;
    private $accessToken = null;

    public function __construct()
    {
        parent::__construct();
        $this->myobApiKey = env('MYOB_APP_KEY', false);
        $this->myobApiSecret = env('MYOB_APP_SECRET', false);
        $this->myobApiUrl = env('MYOB_APP_URL', false);
//        $this->myobApi = new \myob_api_oauth();

//        $this->accessToken = $this->myobApi->getAccessToken(
//            $this->myobApiKey,$this->myobApiSecret,
//            'redirect_url','access_code',$this->scope
//        );

    }

    public function test(){
        $params = '?client_id='.
            $this->myobApiKey.
            '&redirect_uri='.
            urlencode($this->redirectUri).
            '&response_type=code&scope='.$this->scope;
        /**
         * https://secure.myob.com/oauth2/account/authorize
         */
        return 'https://secure.myob.com/oauth2/account/authorize'.$params;
    }
}
