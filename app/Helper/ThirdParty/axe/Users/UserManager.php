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
            $axUser = new AxUser($response, $this);

            // Check the response message for Axcelerate Change_password flag
            if($axUser->get('message') == 'You must change your password'){
                $axUser->FLAG_NEED_TO_CHANGE_PASSWORD = true;
            }
            return $axUser;
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
            $params = [
                'username'=>$username,
                'oldPassword'=>$oldPassword,
                'newPassword'=>$newPassword,
                'verifyPassword'=>$verifyPassword,
            ];
            $response = $this->getConnection()
                ->post('user/changePassword',$params);
            return $response && isset($response['STATUS']) ? $response['STATUS']==self::SUCCESS : false;
        }catch (AxcelerateException $e){
            // Log your error
            return false;
        }
    }
}
