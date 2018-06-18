<?php

namespace App\Models\User\Student;

use App\User;
use FlipNinja\Axcelerate\Manager;
use FlipNinja\Axcelerate\ManagerContract;

class AxcelerateProxy  extends Manager implements ManagerContract
{
    /** @var AxcelerateProxy $_PROXY */
    private static $_PROXY = null;

    /** @var User $_USER */
    private static $_USER = null;

    /**
     * 简单单例模式
     * @param User $user
     * @return AxcelerateProxy|null
     */
    public static function GetProxyInstance(User $user){
        if(!self::$_PROXY){
            self::$_PROXY = new AxcelerateProxy($user);
            self::$_USER = $user;
        }
        return self::$_PROXY;
    }

    /**
     * @return mixed
     */
    private function _getContactId(){
        return self::$_USER->axcelerate_contact_id;
    }

    /**
     * @return mixed
     */
    private function _getContactObject(){
        return self::$_USER->axcelerate_contact_json;
    }

    /**
     * 执行登录的操作, 参数必须 ['username'=>'u', 'password' => 'p']
     * @param $loginDetail
     * @return mixed
     */
    public function userLogin($loginDetail){
        if(self::$_USER){
            return $this->getConnection()
                ->post('user/login',$loginDetail);
        }
        return false;
    }
}
