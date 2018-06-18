<?php
/**
 * Created by PhpStorm.
 * User: Justin Wang
 * Date: 18/6/18
 * Time: 11:55 PM
 */
namespace FlipNinja\Axcelerate\Users;

use FlipNinja\Axcelerate\Resource;

class AxUser extends Resource
{
    public $idAttribute = 'userid';

    /**
     * Check if login action succeeded
     * @return bool
     */
    public function isLoggedIn(){
        return $this->get('status') == 'success';
    }

    /**
     * Get message of why logging in action is failed
     * @return string
     */
    public function getLoginErrorMessage(){
        return $this->get('status').': '.$this->get('message');
    }
}
