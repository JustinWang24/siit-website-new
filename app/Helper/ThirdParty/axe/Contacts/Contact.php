<?php

namespace FlipNinja\Axcelerate\Contacts;

use FlipNinja\Axcelerate\Resource;
use FlipNinja\Axcelerate\Courses\Instance;
use FlipNinja\Axcelerate\Exceptions\AxcelerateException;

class Contact extends Resource
{
    public $idAttribute = 'contactid';

    /**
     * Save or update Contact's details
     *
     * @param $attributes
     * @return bool
     */
    public function save($attributes)
    {
        if ($this->id) {
            return $this->update($attributes);
        }
        $response = $this->manager->getConnection()->create('contact', $attributes);
        if ($response) {
            $this->attributes = $response;
            return true;
        }
        return false;
    }

    /**
     * Update Contact's details
     *
     * @param array $attributes Attributes to update
     * @return bool
     */
    public function update($attributes)
    {
        $response = $this->manager->getConnection()->update('contact/' . $this->id, $attributes);

        if ($response) {
            $this->attributes = $response;
            return true;
        }

        return false;
    }

    /**
     * Returns an Enrolment that can be used to update enrolment or it's subjects
     *
     * @param Instance $instance The instance the enrolment is for
     * @return Enrolment
     */
    public function enrolmentForInstance(Instance $instance)
    {
        return new Enrolment($this->manager, $this, $instance);
    }

    /**
     * Get enrolments of current contact.
     * @return array|bool
     */
    public function enrolments(){
        try{
            $response = $this->manager->getConnection()->get(
                'contact/enrolments',
                ['contactID'=>$this->id]
            );
            $enrolments = [];
            foreach ($response as $item) {
                $instanceData = [
                    'instanceid'=>$item['INSTANCEID'],
                    'type'=>$item['TYPE']
                ];
                $instance = new Instance($instanceData,$this->manager);
                $enrolment = new Enrolment($this->manager,$this,$instance);
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
