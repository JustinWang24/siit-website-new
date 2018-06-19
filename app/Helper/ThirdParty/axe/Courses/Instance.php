<?php

namespace FlipNinja\Axcelerate\Courses;

use FlipNinja\Axcelerate\Resource;
use FlipNinja\Axcelerate\Exceptions\AxcelerateException;
use FlipNinja\Axcelerate\Contacts\Contact;
use FlipNinja\Axcelerate\Contacts\Enrolment;

class Instance extends Resource
{
    public $idAttribute = 'instanceid';

    /**
     * Get enrolments of current instance.
     * @return array|bool
     */
    public function enrolments(){
        try{
            $response = $this->manager->getConnection()->get(
                'course/enrolments',
                ['instanceID'=>$this->id]
            );
            $enrolments = [];
            foreach ($response as $item) {
                $contactData = [
                    'contactid'=>$item['CONTACTID'],
                    'surname'=>$item['SURNAME'],
                    'givenname'=>$item['GIVENNAME'],
                    'id'=>$item['ID'],
                ];
                $contact = new Contact($contactData,$this->manager);
                $enrolment = new Enrolment($this->manager,$contact,$this);
                $enrolment->setActivitiesArray($item['ACTIVITIES']);
                $enrolments[] = $enrolment;
            }
            return $enrolments;
        }catch (AxcelerateException $exception){
            // Log error
            return false;
        }
    }
}
