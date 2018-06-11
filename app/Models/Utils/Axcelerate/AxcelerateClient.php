<?php

namespace App\Models\Utils\Axcelerate;

use FlipNinja\Axcelerate\Axcelerate;
use FlipNinja\Axcelerate\Exceptions\AxcelerateException;
use Log;

class AxcelerateClient
{
    const STATUS_OK = 200;
    private static $instance = null;

    /**
     * 获取 Axcelerate 的对象实例
     * @return Axcelerate|null
     */
    public static function GetInstance(){
        if(self::$instance == null){
            self::$instance = new Axcelerate(
                self::GetApiToken(),
                self::GetWebServiceToken(),
                self::GetEnv()
            );
        }
        return self::$instance;
    }

    /**
     * 获取 AxcelerateContactManager 对象实例
     * @return \FlipNinja\Axcelerate\Contacts\ContactManager
     */
    public static function GetContactManager(){
        return self::GetInstance()->contacts();
    }

    /**
     * 获取 AxcelerateCourseManager 对象实例
     * @return \FlipNinja\Axcelerate\Courses\CourseManager
     */
    public static function GetCourseManager(){
        return self::GetInstance()->courses();
    }

    public static function GetApiToken(){
        return env('AXCELERATE_API_TOKEN', 'E6B33A65-2DD7-4FB1-9FC9B2B3C927F03C');
    }

    public static function GetWebServiceToken(){
        return env('AXCELERATE_WEB_TOKEN', '4A19582D-67AE-469E-A0D8CD5DEEE87082');
    }

    public static function GetEnv(){
        return env('AXCELERATE_PRODUCTION',false) ? Axcelerate::PRODUCTION_BASE : Axcelerate::STAGING_BASE;
    }

    /**
     * 获取某个指定的 instance 详情 , 需要 InstanceID 字段和 type
     * @param null $idAndType
     * @return \FlipNinja\Axcelerate\Courses\Instance|null
     */
    public static function GetAxcelerateInstanceDetailByIdAndType($idAndType=null){
        if($idAndType){
            $segments = explode('_',$idAndType);
            if(count($segments) == 2){
                list($instanceId, $type) = $segments;
                try{
                    return self::GetCourseManager()->findInstance(['InstanceID'=>$instanceId,'type'=>$type]);
                }catch (AxcelerateException $exception){
                    Log::info('AxcelerateException',['msg'=>$exception->getMessage(),'InstanceID'=>$instanceId,'type'=>$type]);
                }
            }
        }
        return null;
    }
}
