<?php

namespace App\Models\User;

use App\Models\Utils\Axcelerate\AxcelerateClient;
use App\User;
use FlipNinja\Axcelerate\Contacts\Contact;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    public static $passportFields = ['passport_first_page_image','passport_expiry_date'];
    public static $certsFields = ['english_test_certificate_image','document_evidence','applying_exemptions_files'];

    protected $casts = [
        'applying_exemptions_files' => 'array', // 可能保存多个文件的路径
        'gender' => 'boolean',
        'disability_required' => 'boolean',
        'is_pr' => 'boolean',
        'applying_exemptions' => 'boolean',
        'authorize_to_agent' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    /**
     * 持久化学生的profile
     * @param $data
     * @param User $user
     * @param bool $isUpdateAction
     * @return bool
     */
    public static function Persistence($data, User $user, $isUpdateAction = false){
        if($isUpdateAction){
            $row = $user->studentProfile;
        }else{
            $row = new StudentProfile();
        }

        $data['user_id'] = $user->id;
        foreach ($data as $fieldName => $fieldValue) {
            $row->$fieldName = $fieldValue;
        }

        try{
            $row->save();

            // 构造ax需要的数据结构
            $contactData = $user->_convertToAttributesData();

            $manager = AxcelerateClient::GetContactManager();
            $contact = $manager->findByEmail($user->email);

            if($contact && $contact->id){
                // Axcelerate中已经存在了这个用户， 那么更新操作
                $contact->update($contactData);
            }else{
                $contact = new Contact($contactData, $manager);
                if($contact->save($contactData)){
                    $user->axcelerate_contact_id = $contact->id;
                    $user->save();
                }
            }
        }catch (\Exception $exception){
            return false;
        }
    }
}
