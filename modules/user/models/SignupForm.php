<?php
namespace user\models;

use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;
    public $password_repeat;

    public $reCaptcha;
    public $accept_terms;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            //['username', 'required'],
            ['username', 'unique', 'targetClass' => '\user\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['first_name', 'required'],
            ['last_name', 'required'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\user\models\User', 'message'=>Yii::t('yii', '{attribute} "{value}" has already been taken.').' '.Html::a(Yii::t('app', 'Login'), ['/user/guest/login'])],

            [['password', 'password_repeat'], 'required'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'when'=>function($model){
                    return YII_ENV=='prod';
                },
                'whenClient'=>new JsExpression("function (attribute, value) {
                                        return ".(YII_ENV=='prod'?1:0).";
                                    }"),
            ],

            ['accept_terms', 'boolean'],
            [
                'accept_terms', 'required', 'requiredValue' => 1,
                'message' => Yii::t('app', 'You must agree to the terms and conditions'),
                'on'=>'step2',
            ]
        ];
    }

    /**
     * Signs user up.
     *
     * @return \user\models\User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        $user->name = $this->name;

        $user->setPassword($this->password);
        $user->generateAuthKey();

        //$user->roles = [User::ROLE_USER]; // defualt user role

        if(Yii::$app->session->get('referrer_id'))
            $user->referrer_id = Yii::$app->session->get('referrer_id');
        if(Yii::$app->request->cookies->get('from')){
            $user->from = Yii::$app->request->cookies->get('from');
            if($referrer = User::findOne(['email'=>$user->from,]))
                $user->referrer_id = $referrer->id;
            Yii::$app->response->cookies->remove('from');
        }

        if ($user->save())
        {
            $token = Token::create(Token::ACTION_ACTIVATE_ACCOUNT, $user);
            Yii::$app->mailer->compose('activateAccount-html', ['user' => $user, 'token'=>$token,])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo([$user->email=>$user->fullName])
                ->setSubject(Yii::t('app', 'You requested to activate your account.'))
                ->send();
            return $user;
        }else
            throw new Exception(strip_tags(Html::errorSummary($user, ['header'=>false,])));
    }

    public function attributeLabels()
    {
        return [
            'email'=>Yii::t('app', 'Email'),
            'password'=>Yii::t('user', 'Password'),
            'password_repeat'=>Yii::t('user', 'Repeat password'),
            'accept_terms'=>Yii::t('user', 'Accept terms'),
        ];
    }

}
