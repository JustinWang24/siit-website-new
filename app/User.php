<?php

namespace App;

use App\Models\Group;
use App\Models\Utils\Axcelerate\AxcelerateClient;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserGroup;
use App\Models\User\StudentProfile;
use FlipNinja\Axcelerate\Contacts\Contact;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const ERROR_CODE_EMAIL_UNIQUE       = 70;       // Email字段为unique
    const ERROR_CODE_EMAIL_REQUIRED     = 71;       // Email字段为必须
    const ERROR_CODE_CREATE_NEW_FAILED  = 72;       // 创建新用户记录失败

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','phone','fax',
        'address','city','postcode','state','country','uuid','group_id','status',
        'axcelerate_contact_json','axcelerate_contact_id',
        'moodle_id','moodle_data_json',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 获取学生用户关联的Axcelerate Contact 对象
     * @return Contact|null
     */
    public function getAxcelerateContact(){
        $contactManager = AxcelerateClient::GetContactManager();
        $contact = null;

        if(is_null($this->axcelerate_contact_id)){
            $contact = $contactManager->findByEmail($this->email);
            if($contact){
                // 表示从 Axcelerate 获取到了数据, 那么就自动将取得的数据进行更新
                $this->axcelerate_contact_id = $contact->get('contactid');
                $this->phone    = $contact->get('mobilephone') ? $contact->get('mobilephone') : $contact->get('phone');
                $this->address  = $contact->get('address1') . ($contact->get('address2') ? ' '.$contact->get('address2') : '');
                $this->city     = $contact->get('city');
                $this->postcode = $contact->get('postcode');
                $this->state    = $contact->get('state');
                $this->country  = $contact->get('country');
                $this->status   = $contact->get('contactactive') == 'n.a' ? false : $contact->get('contactactive');
                $this->axcelerate_contact_json = $contact->toJson();
                $this->save();
            }else{
                // 表示没有从Axcelerate找到对应的数据，也即表示该用户还没有注册过, 那么就去更新一下
                $attributes = $this->_convertToAttributesData();
                if($attributes){
                    $contact = new Contact($attributes,$contactManager);
                    if($contact->save($attributes)){
                        $this->axcelerate_contact_id = $contact->id;
                        $this->status = true;    // 更新一下状态，保持和 Axcelerate 同步
                        $this->save();
                    }else{
                        // 保存到Axcelerate失败, 那么把contact改会null, 表示获取失败
                        $contact = null;
                    }
                }
            }
        }else{
            $contact = $contactManager->find($this->axcelerate_contact_id);
        }
        return $contact;
    }

    /**
     * 获取用户所关联的学生profile数据
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function studentProfile(){
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * @param $uuid
     * @return User/null
     */
    public static function GetByUuid($uuid){
        return self::where('uuid',$uuid)->first();
    }

    /**
     * @param $email
     * @return User/null
     */
    public static function GetByEmail($email){
        return self::where('email',$email)->first();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups(){
        return $this->hasMany(UserGroup::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function addressText(){
        return $this->address.', '.$this->city.' '.$this->postcode.
        ', '.$this->state. ', '.$this->country;
    }

    /**
     * 把User对象实例转换为Axcelerate contact 需要的所需格式
     * @return array|bool
     */
    private function _convertToAttributesData(){
        if(!$this->studentProfile){
            return false;
        }
        return [
            'givenName'=>$this->studentProfile->given_name,
            'surname'=>$this->studentProfile->family_name,
            'address1'=>$this->address,
            'city'=>$this->city,
            'postcode'=>$this->postcode,
            'state'=>$this->state,
            'country'=>$this->country,
            'emailAddress'=>$this->email,
            'sex'=>$this->studentProfile->gender ? 'M' : 'F',
        ];
    }
}
