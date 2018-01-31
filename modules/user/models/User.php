<?php

namespace user\models;

use file\models\File;
use file\models\FileBehavior;
use file\models\FileImage;
use file\models\FileImageBehavior;
use i18n\models\I18nSourceMessage;
use Yii;
use yii\base\Event;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use inventory\models\Location;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $fullName
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password write-only password
 * @property integer $status
 * @property string $statusText
 * @property array $roles
 * @property string $rolesText
 * @property array $rolesValues
 * @property array $possibleRolesValues
 * @property integer $created_at
 * @property integer $updated_at
 * @property \file\models\FileImage $image
 * @property array $images
 * @property integer $referrer_id
 * @property User $referrer
 * @property string $description
 * @property string $language
 * @property string $time_zone
 */
class User extends ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     * @return \user\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \user\models\query\UserQuery(get_called_class());
    }

    public $password_new;
    public $password_new_repeat;

    public $password_set;
    public $password_set_repeat;

    public $password;//current password

    public $email_new;


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 20;
    const STATUS_DELETED = 21;

    public $statusValues = [
        self::STATUS_ACTIVE=>'Active',
        self::STATUS_INACTIVE=>'Inactive',
        self::STATUS_DELETED=>'Deleted',
        self::STATUS_BLOCKED=>'Blocked',
    ];



    public function getStatusText()
    {
        return isset($this->statusValues[$this->status]) ? $this->statusValues[$this->status]:null;
    }
    public function getLanguageText()
    {
        $languageValues = (new I18nSourceMessage)->languageValues;
        return isset($languageValues[$this->language]) ? $languageValues[$this->language]:null;
    }

    public function getName()
    {
        return $this->fullName;
    }
    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /*    public function setRoleValue($value)
        {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //$this->role = $value;
                //$this->save();
                $this->saveRoles($value);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }*/
    public $rolesAttribute=[];

    const ROLE_GUEST = 1;
    const ROLE_BUYER = 10;
    const ROLE_INVENTORY_TAKER = 20;
    const ROLE_ADMINISTRATOR = 30;

    public function getUserOrganizations()
    {
        return $this->hasMany(UserOrganization::className(), ['user_id'=>'id']);
    }

    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['id'=>'organization_id'])->via('userOrganizations');
    }


    public function hasRole($role)
    {
        return in_array($role, $this->roles);
    }
    public function getRoles()
    {
        return ArrayHelper::map(Yii::$app->authManager->getAssignments($this->id), 'roleName', 'roleName');
    }
    public function getPossibleRolesValues()
    {
        $roleValues = [];
        foreach ($this->rolesValues as $name=>$description)
            if(Yii::$app->user->can($name))
                $roleValues[$name] = $description;
        unset($roleValues[User::ROLE_GUEST]);
        return $roleValues;
    }
    public function getRolesValues()
    {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }
    public function getRolesText()
    {
        $roles = $this->roles;
        $rolesValues = $this->rolesValues;
        /*$roles = array_map( function($value) use ($rolesValues){
            if(isset($rolesValues[$value]))
                return $rolesValues[$value];
        }, $roles);*/
        array_walk($roles, function(&$value, $key) use ($rolesValues)
        {
            if(isset($rolesValues[$key]))
                $value = $rolesValues[$key];
        });
        return implode(', ', $roles);
    }
    public function attributes()
    {
        $attributes = parent::attributes();
        $attributes[] = 'rolesAttribute';
        return $attributes;
    }
    public function saveRoles()
    {
        Yii::$app->authManager->revokeAll($this->id);
        if($this->rolesAttribute){
            if(is_array($this->rolesAttribute))
                foreach ($this->rolesAttribute as $role)
                    Yii::$app->authManager->assign(Yii::$app->authManager->getRole($role) , $this->id);
            else
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole($this->rolesAttribute) , $this->id);
        }
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_AFTER_INSERT, function(AfterSaveEvent $event){
            $event->sender->saveRoles();
        });
        $this->on(self::EVENT_AFTER_UPDATE, function(AfterSaveEvent $event){
            /* @var $model self */
            $model = $event->sender;
            if($model->rolesAttribute  || $model->rolesAttribute===''){//Если дали какое то значение
                $model->setOldAttribute('rolesAttribute', $model->roles);
                $model->setAttribute('rolesAttribute', $model->rolesAttribute);
                //if(isset($event->changedAttributes['rolesAttribute']))
                if(isset($model->getDirtyAttributes()['rolesAttribute']))
                    $model->saveRoles();
            }
        });

    }





    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
            [
                'class' => FileImageBehavior::className(),
                'className'=>'user\models\User',
                'attributes'=>['imageAttribute', 'imagesAttribute'],
            ],
        ];
    }
    public $imageAttribute;
    public $imagesAttribute=[];
    /**
     * @return \file\models\query\FileQuery
     */
    public function getImage()
    {
        return $this->hasOne(FileImage::className(), ['model_id' => 'id'])
            ->queryModel('user\models\User')->queryImage();
    }
    /**
     * @return \file\models\query\FileQuery
     */
    public function getImages()
    {
        return $this->hasMany(FileImage::className(), ['model_id' => 'id'])
            ->queryModel('user\models\User')->queryImages();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['imageAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxSize'=>1024*1024*4,//4 mb
            ],
            ['imagesAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
                'maxFiles'=>10,
                'maxSize'=>1024*1024*4,//4 mb
            ],

            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => array_keys($this->statusValues)],
            ['status', 'required'],
            ['status', 'filter', 'filter' => 'intval'],

            [['first_name', 'last_name'], 'default', 'value' => ''],
            [['first_name', 'last_name'], 'required'],

            //[['username'], 'required'],
            [['username'], 'default', 'value'=>'',],

            [['email'], 'required'],
            [['email', 'username'], 'unique'],
            [['email'], 'email'],

            [['password', 'password_new', 'password_new_repeat'], 'required', 'on'=>'changePassword'],
            ['password', 'validateCurrentPassword', 'on'=>'changePassword'],
            [['password_new', 'password_set'], 'string', 'min' => 6],
            ['password_new_repeat', 'compare', 'compareAttribute'=>'password_new', 'on'=>'changePassword'],

            [['password_set', 'password_set_repeat'], 'required', 'on'=>'setPassword'],
            ['password_set_repeat', 'compare', 'compareAttribute'=>'password_set', 'on'=>'setPassword'],

            [['email_new', 'password'], 'required', 'on'=>'changeEmail'],
            ['password', 'validateCurrentPassword', 'on'=>'changeEmail'],
            ['email_new', 'email'],//'on'=>'changeEmail' можно и так
            ['email_new', 'unique', 'targetClass' => '\user\models\User', 'targetAttribute'=>'email'],
            ['email_new', 'uniqueValidate',],

            [['password_new', 'password_new_repeat'], 'required', 'on'=>'resetByAdministrator'],
            ['password_new_repeat', 'compare', 'compareAttribute'=>'password_new','on'=>'resetByAdministrator'],

            ['rolesAttribute', 'each', 'rule' =>
                ['in', 'range' => array_keys($this->rolesValues)]],
            
            [['language'], 'in', 'range' => array_keys((new I18nSourceMessage())->languageValues)],

            [['time_zone'], 'in', 'range' => array_keys($this->getTimeZoneValues())],
            ['description', 'safe'],
            [['description', 'from'], 'default', 'value'=>'',],
        ];
    }
    public function uniqueValidate($attribute, $params)
    {
        if(self::find()->where(['email'=>$this->$attribute,])->exists())
            $this->addError($attribute,  Yii::t('yii', '{attribute} "{value}" has already been taken.', ['attribute'=>$this->getAttributeLabel($attribute), 'value'=>$this->email_new,]));
    }
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->validatePassword($this->password)){
            $this->addError($attribute, Yii::t('app', '{attribute} is incorrect.', ['attribute'=>$this->getAttributeLabel($attribute),]));
            $this->$attribute = null;
        }
    }

    public $_fields=[];
    public function fields()
    {
        return array_merge([
            'id',
            'username',
            'first_name',
            'last_name',
            'email',
            'status',
            'language',
            'time_zone',
            'description',
            'roles',
            'image'=>function($model){
                    return $model->image;
                },
        ], $this->_fields);
    }
    public function extraFields()
    {
        return [
            'images'=>function($model){
                    return $model->images;
                },
        ];
    }

    public function attributeLabels()
    {
        return [
            'password'=>Yii::t('user', 'Current password'),
            'password_new'=>Yii::t('user', 'New password'),
            'password_new_repeat'=>Yii::t('user', 'Repeat new password'),
            'password_set'=>Yii::t('user', 'Password'),
            'password_set_repeat'=>Yii::t('user', 'Repeat Password'),
            'email_new'=>Yii::t('user', 'New email'),
            'imageAttribute'=>Yii::t('user', 'Avatar'),
            'imagesAttribute'=>Yii::t('app', 'Images'),
            'referrer_id'=>Yii::t('user', 'Referrer'),
            'username'=>Yii::t('user', 'User name'),
            'email'=>Yii::t('app', 'Email'),
            'rolesAttribute'=>Yii::t('app', 'Roles'),
            'status'=>Yii::t('app', 'Status'),
            'description'=>Yii::t('app', 'Description'),
            'language'=>Yii::t('app', 'Language'),
            'time_zone'=>Yii::t('user', 'Time zone'),
            'created_at'=>Yii::t('app', 'Create date'),
            'updated_at'=>Yii::t('app', 'Update date'),
        ];
    }




    /**
     * @inheritdoc
     * @return User
     */
    public static function findOne($condition)
    {
        return parent::findOne($condition);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $loginToken = Token::find()->where(['token'=>$token])->one();
        if($loginToken)
            return static::findOne(['id' => $loginToken->user_id]);
        else
            throw new Exception("Token is incorrect", 401);
    }

    public static function findByEmail($email)
    {
        return self::findByUsernameOrEmail($email);
    }
    /**
     * Finds user by username
     *
     * @param string $username|$email
     * @return User|null
     */
    public static function findByUsernameOrEmail($username)
    {
        return static::find()->where( ['OR', ['username' => $username], ['email' => $username]])->one();
        /*return static::find()->where(
            [
                'AND',
                ['OR', ['username' => $username], ['email' => $username]],
                ['status' => self::STATUS_ACTIVE]
            ]
        )->one();*/
        //return static::findOne([  'username' => $username, 'status' => self::STATUS_ACTIVE]);
    }



    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return true;
        if(!$this->password_hash)
            return false;
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrer()
    {
        return $this->hasOne(User::className(), ['id' => 'referrer_id'])->from(['referrer'=>$this->tableName(),]);
    }

    const TIME_ZONE_LIST_JSON = '{"Pacific\/Midway":"(GMT-11:00) Midway Island","US\/Samoa":"(GMT-11:00) Samoa","US\/Hawaii":"(GMT-10:00) Hawaii","US\/Alaska":"(GMT-09:00) Alaska","US\/Pacific":"(GMT-08:00) Pacific Time (US & Canada)","America\/Tijuana":"(GMT-08:00) Tijuana","US\/Arizona":"(GMT-07:00) Arizona","US\/Mountain":"(GMT-07:00) Mountain Time (US & Canada)","America\/Chihuahua":"(GMT-07:00) Chihuahua","America\/Mazatlan":"(GMT-07:00) Mazatlan","America\/Mexico_City":"(GMT-06:00) Mexico City","America\/Monterrey":"(GMT-06:00) Monterrey","Canada\/Saskatchewan":"(GMT-06:00) Saskatchewan","US\/Central":"(GMT-06:00) Central Time (US & Canada)","US\/Eastern":"(GMT-05:00) Eastern Time (US & Canada)","US\/East-Indiana":"(GMT-05:00) Indiana (East)","America\/Bogota":"(GMT-05:00) Bogota","America\/Lima":"(GMT-05:00) Lima","America\/Caracas":"(GMT-04:30) Caracas","Canada\/Atlantic":"(GMT-04:00) Atlantic Time (Canada)","America\/La_Paz":"(GMT-04:00) La Paz","America\/Santiago":"(GMT-04:00) Santiago","Canada\/Newfoundland":"(GMT-03:30) Newfoundland","America\/Buenos_Aires":"(GMT-03:00) Buenos Aires","Greenland":"(GMT-03:00) Greenland","Atlantic\/Stanley":"(GMT-02:00) Stanley","Atlantic\/Azores":"(GMT-01:00) Azores","Atlantic\/Cape_Verde":"(GMT-01:00) Cape Verde Is.","Africa\/Casablanca":"(GMT) Casablanca","Europe\/Dublin":"(GMT) Dublin","Europe\/Lisbon":"(GMT) Lisbon","Europe\/London":"(GMT) London","Africa\/Monrovia":"(GMT) Monrovia","Europe\/Amsterdam":"(GMT+01:00) Amsterdam","Europe\/Belgrade":"(GMT+01:00) Belgrade","Europe\/Berlin":"(GMT+01:00) Berlin","Europe\/Bratislava":"(GMT+01:00) Bratislava","Europe\/Brussels":"(GMT+01:00) Brussels","Europe\/Budapest":"(GMT+01:00) Budapest","Europe\/Copenhagen":"(GMT+01:00) Copenhagen","Europe\/Ljubljana":"(GMT+01:00) Ljubljana","Europe\/Madrid":"(GMT+01:00) Madrid","Europe\/Paris":"(GMT+01:00) Paris","Europe\/Prague":"(GMT+01:00) Prague","Europe\/Rome":"(GMT+01:00) Rome","Europe\/Sarajevo":"(GMT+01:00) Sarajevo","Europe\/Skopje":"(GMT+01:00) Skopje","Europe\/Stockholm":"(GMT+01:00) Stockholm","Europe\/Vienna":"(GMT+01:00) Vienna","Europe\/Warsaw":"(GMT+01:00) Warsaw","Europe\/Zagreb":"(GMT+01:00) Zagreb","Europe\/Athens":"(GMT+02:00) Athens","Europe\/Bucharest":"(GMT+02:00) Bucharest","Africa\/Cairo":"(GMT+02:00) Cairo","Africa\/Harare":"(GMT+02:00) Harare","Europe\/Helsinki":"(GMT+02:00) Helsinki","Europe\/Istanbul":"(GMT+02:00) Istanbul","Asia\/Jerusalem":"(GMT+02:00) Jerusalem","Europe\/Kiev":"(GMT+02:00) Kyiv","Europe\/Minsk":"(GMT+02:00) Minsk","Europe\/Riga":"(GMT+02:00) Riga","Europe\/Sofia":"(GMT+02:00) Sofia","Europe\/Tallinn":"(GMT+02:00) Tallinn","Europe\/Vilnius":"(GMT+02:00) Vilnius","Asia\/Baghdad":"(GMT+03:00) Baghdad","Asia\/Kuwait":"(GMT+03:00) Kuwait","Africa\/Nairobi":"(GMT+03:00) Nairobi","Asia\/Riyadh":"(GMT+03:00) Riyadh","Europe\/Moscow":"(GMT+03:00) Moscow","Asia\/Tehran":"(GMT+03:30) Tehran","Asia\/Baku":"(GMT+04:00) Baku","Europe\/Volgograd":"(GMT+04:00) Volgograd","Asia\/Muscat":"(GMT+04:00) Muscat","Asia\/Tbilisi":"(GMT+04:00) Tbilisi","Asia\/Yerevan":"(GMT+04:00) Yerevan","Asia\/Kabul":"(GMT+04:30) Kabul","Asia\/Karachi":"(GMT+05:00) Karachi","Asia\/Tashkent":"(GMT+05:00) Tashkent","Asia\/Kolkata":"(GMT+05:30) Kolkata","Asia\/Kathmandu":"(GMT+05:45) Kathmandu","Asia\/Yekaterinburg":"(GMT+06:00) Ekaterinburg","Asia\/Almaty":"(GMT+06:00) Almaty","Asia\/Dhaka":"(GMT+06:00) Dhaka","Asia\/Novosibirsk":"(GMT+07:00) Novosibirsk","Asia\/Bangkok":"(GMT+07:00) Bangkok","Asia\/Jakarta":"(GMT+07:00) Jakarta","Asia\/Krasnoyarsk":"(GMT+08:00) Krasnoyarsk","Asia\/Chongqing":"(GMT+08:00) Chongqing","Asia\/Hong_Kong":"(GMT+08:00) Hong Kong","Asia\/Kuala_Lumpur":"(GMT+08:00) Kuala Lumpur","Australia\/Perth":"(GMT+08:00) Perth","Asia\/Singapore":"(GMT+08:00) Singapore","Asia\/Taipei":"(GMT+08:00) Taipei","Asia\/Ulaanbaatar":"(GMT+08:00) Ulaan Bataar","Asia\/Urumqi":"(GMT+08:00) Urumqi","Asia\/Irkutsk":"(GMT+09:00) Irkutsk","Asia\/Seoul":"(GMT+09:00) Seoul","Asia\/Tokyo":"(GMT+09:00) Tokyo","Australia\/Adelaide":"(GMT+09:30) Adelaide","Australia\/Darwin":"(GMT+09:30) Darwin","Asia\/Yakutsk":"(GMT+10:00) Yakutsk","Australia\/Brisbane":"(GMT+10:00) Brisbane","Australia\/Canberra":"(GMT+10:00) Canberra","Pacific\/Guam":"(GMT+10:00) Guam","Australia\/Hobart":"(GMT+10:00) Hobart","Australia\/Melbourne":"(GMT+10:00) Melbourne","Pacific\/Port_Moresby":"(GMT+10:00) Port Moresby","Australia\/Sydney":"(GMT+10:00) Sydney","Asia\/Vladivostok":"(GMT+11:00) Vladivostok","Asia\/Magadan":"(GMT+12:00) Magadan","Pacific\/Auckland":"(GMT+12:00) Auckland","Pacific\/Fiji":"(GMT+12:00) Fiji"}';
    public function getTimeZoneText()
    {
        if($this->time_zone)
            return json_decode(self::TIME_ZONE_LIST_JSON, JSON_FORCE_OBJECT)[$this->time_zone];
    }
    public function getTimeZoneValues()
    {
        return json_decode(self::TIME_ZONE_LIST_JSON, JSON_FORCE_OBJECT);
    }

}
