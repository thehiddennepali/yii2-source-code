<?php
namespace merchant\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $contact_email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['contact_email', 'trim'],
            ['contact_email', 'required'],
            ['contact_email', 'email'],
            ['contact_email', 'exist',
                'targetClass' => '\common\models\Merchant',
                'filter' => ['status' => \common\models\Merchant::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = \common\models\Merchant
                ::findOne([
            'status' => \common\models\Merchant::STATUS_ACTIVE,
            'contact_email' => $this->contact_email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!\common\models\Merchant::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        
        $email = \merchant\components\EmailManager::passwordResetRequest($user);
        
        if($email){
            return true;
            
        }

//        return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
//                ['user' => $user]
//            )
//            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($this->email)
//            ->setSubject('Password reset for ' . Yii::$app->name)
//            ->send();
    }
}
