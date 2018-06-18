<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 18/6/18
 * Time: 11:55 PM
 */
namespace FlipNinja\Axcelerate\Users;

use FlipNinja\Axcelerate\Manager;
use FlipNinja\Axcelerate\ManagerContract;
use FlipNinja\Axcelerate\Exceptions\AxcelerateException;

class UserManager extends Manager implements ManagerContract
{
    const SUCCESS = 'success';
    /**
     * User Login
     * @param $username
     * @param $password
     * @return bool|AxUser
     */
    public function login($username, $password){
        try{
            $response = $this->getConnection()
                ->post('user/login',['username'=>$username, 'password'=>$password]);
            return new AxUser($response, $this);
        }catch (AxcelerateException $e){
            // Log your error
            return false;
        }
    }

    /**
     * Update user's password
     * @param $username
     * @param $oldPassword
     * @param $newPassword
     * @param $verifyPassword
     * @return bool
     */
    public function changePassword($username, $oldPassword, $newPassword, $verifyPassword){
        try{
            $response = $this->getConnection()
                ->post('user/changePassword',
                    [
                        'username'=>$username,
                        'oldPassword'=>$oldPassword,
                        'newPassword'=>$newPassword,
                        'verifyPassword'=>$verifyPassword,
                    ]
                );
            return $response && isset($response['STATUS']) ? $response['STATUS']==self::SUCCESS : false;
        }catch (AxcelerateException $e){
            // Log your error
            return false;
        }
    }
}
