<?php

namespace user\models;

use user\models\query\TokenQuery;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\web\Cookie;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $action
 * @property integer $run
 * @property string $token
 * @property string $ip_address
 * @property string $expire_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $data
 * @property User $user
 */

class Token extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function ($event) {
                        return date('Y-m-d H:i:s');
                    },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'expire_date',
                ],
                'value' => function ($event) {
                        return date('Y-m-d H:i:s', time()+3600*24*7);
                    },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'ip_address',
                ],
                'value' => function ($event) {
                        return Yii::$app->request->userIP;
                    },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'token',
                ],
                'value' => function ($event) {
                        return Yii::$app->security->generateRandomString();
                    },
            ],

        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'action'], 'required'],
            [['user_id'], 'integer'],
            [['run'], 'boolean'],
            [['data'], 'safe'],
            [['run'], 'default', 'value' => 0],
            [['expire_date', 'created_at', 'updated_at'], 'safe'],
            [['token', 'ip_address'], 'default', 'value'=>''],
            [['user_id'], 'default', 'value'=>0],
            [['expire_date', 'created_at', 'updated_at'], 'default', 'value'=>'0000-00-00 00:00:00'],
            [['token', 'ip_address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }



    const ACTION_ACTIVATE_ACCOUNT = 10;
    const ACTION_ACTIVATE_ACCOUNT_FROM_ADMINISTRATOR = 11;
    const ACTION_RESET_PASSWORD = 20;
    const ACTION_CHANGE_EMAIL = 30;
    const ACTION_SHARE_LINK_TO_REGISTER = 40;
    const ACTION_LOGIN = 50;

    public static function getTokenForWeb()
    {
        $model = Token::findOne(['user_id'=>Yii::$app->user->id, 'action'=>Token::ACTION_LOGIN, 'data'=>'web']);
        if(!$model)
            $model = self::generateTokenForWeb();
        return $model;
    }
    public static function generateTokenForWeb()
    {
        Token::deleteAll(['user_id'=>Yii::$app->user->id, 'action'=>Token::ACTION_LOGIN, 'data'=>'web']);
        $token = new Token();
        $token->action = Token::ACTION_LOGIN;
        $token->user_id = Yii::$app->user->id;
        $token->data = 'web';
        $token->save();
        return $token;
    }


    public static function create($action, $user)
    {
        return static::_create($action, $user);
    }
    public static function createForPasswordReset($action, $user)
    {
        $token = static::_create($action, $user);
        $token->updateAttributes(['expire_date'=>date('Y-m-d H:i:s', time() + Yii::$app->params['user.passwordResetTokenExpire']),]);
        return $token;
    }
    public static function createForEmailChange($action, $user, $email)
    {
        $token = static::_create($action, $user);
        $token->updateAttributes(['data'=>$email,]);
        return $token;
    }
    protected static function _create($action, $user)
    {
        $token = new Token();
        $token->action = $action;
        $token->user_id = $user->id;
        $token->save();
        return $token;
    }

    public function run()
    {
        if($this->action!=self::ACTION_SHARE_LINK_TO_REGISTER){
            if($this->expire_date<date('Y-m-d H:i:s'))
                throw new Exception('The token is expired.');
        }

        if($this->run==1)
            throw new Exception('The token can not be run twice.');

        $user = $this->user;
        switch($this->action)
        {
            case self::ACTION_ACTIVATE_ACCOUNT: {
                $user->status = User::STATUS_ACTIVE;
                $user->save(false);
                break;
            }
            case self::ACTION_CHANGE_EMAIL:{
                Yii::info("{$user->id}-{$user->fullName} changed email from '$user->email' to '$this->data'", 'userChanges');
                if($this->data)
                    $user->email=$this->data;
                $user->save(false);
                break;
            }
            case self::ACTION_SHARE_LINK_TO_REGISTER: {
                /*Yii::$app->response->cookies->add(new Cookie([
                    'name' => 'referrer',
                    'value' => $user->id,
                ]));*/
                Yii::$app->session->set('referrer_id', $user->id);
                break;
            }
        }
        if($this->action!=self::ACTION_SHARE_LINK_TO_REGISTER)
            $this->run = 1;
        $this->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public static function find()
    {
        return new TokenQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'token' => Yii::t('app', 'Token'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'expire_date' => Yii::t('app', 'Expire Date'),
            'created_at' => Yii::t('app', 'Created Date'),
            'updated_at' => Yii::t('app', 'Updated Date'),
        ];
    }


    /**
     * @inheritdoc
     * @return Token|null self instance matching the condition, or `null` if nothing matches.
     */
    public static function findOne($condition)
    {
        return static::findByCondition($condition)->one();
    }


}