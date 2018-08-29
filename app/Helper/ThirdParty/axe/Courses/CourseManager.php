<?php

namespace FlipNinja\Axcelerate\Courses;

use FlipNinja\Axcelerate\Contacts\Contact;
use FlipNinja\Axcelerate\Contacts\Enrolment;
use FlipNinja\Axcelerate\Manager;
use FlipNinja\Axcelerate\ManagerContract;
use FlipNinja\Axcelerate\Exceptions\AxcelerateException;

class CourseManager extends Manager implements ManagerContract
{
    /**
     * Find an instance with attributes
     *
     * @throws AxcelerateException if multiple instances are found
     * @param array $attributes Attributes to match with
     * @return Instance|null
     */
    public function findInstance($attributes)
    {
        $instances = $this->searchInstances($attributes);

        if (count($instances) > 1) {
            throw new AxcelerateException('Search attributes were not specific enough to find a single instance.');
        }

        return $instances ? $instances[0] : null;
    }

    /**
     * 根据课程的 ID 获取包含的 instances
     * @param $courseId
     * @param $location
     * @return array
     */
    public function getClassesByCourseId($courseId,$location=null){
        $defaults = [
            'ID'=>$courseId,
            'type'=>'p',
        ];
        $instances = [];
        if ($response = $this->getConnection()->get('course/instances', $defaults)) {
            foreach ($response as $instance) {
                if($location){
                    $location = strtoupper($location);
                    if($location == $instance['LOCATION'])
                        $instances[] = new Instance($instance, $this);
                }else{
                    $instances[] = new Instance($instance, $this);
                }
            }
        }
        return $instances;
    }

    /**
     * Search for instances that match the attributes
     *
     * @param array $attributes Attributes to match with
     * @return Instance[]
     */
    public function searchInstances($attributes)
    {
        // Default search parameters
        $defaults = [
            'everything' => true, // A lovely parameter that overwrites the defaults
            'displayLength'=>config('system.PAGE_SIZE'),
            'enrolmentOpen'=>true,
            'public'=>true,
        ];
        $instances = [];
        if ($response = $this->getConnection()->post('course/instance/search', array_merge($defaults, $attributes))) {
            foreach ($response as $instance) {
                $instances[] = new Instance($instance, $this);
            }
        }
        return $instances;
    }

    /**
     * Get all courses from AxCelerate
     * @param $attributes
     * @return array
     */
    public function getAll($attributes)
    {
        // Default search parameters
        $defaults = [
            'isactive'=>true,
            'type'=>'p'
        ];
        $instances = [];
        if ($response = $this->getConnection()->get('courses', array_merge($defaults,$attributes))) {
            foreach ($response as $instance) {
                $instances[] = new Instance($instance, $this);
            }
        }
        return $instances;
    }
}
