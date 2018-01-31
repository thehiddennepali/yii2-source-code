<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 5/11/16
 * Time: 12:10 PM
 */

namespace user\controllers;

use file\models\File;
use user\models\InviteForm;
use user\models\Token;
use user\models\User;
use Yii;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\filters\AccessControl;
use yii\helpers\Html;
use extended\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;


class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile', 'edit-profile', 'set-password', 'change-password', 'change-email',
                            'activate-email-change', 'share', 'invite', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }


    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => Yii::$app->user->identity,
        ]);
    }

    public function actionEditProfile()
    {
        $model = Yii::$app->user->identity;

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())){
            if($model->validate())
            {
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::t('user', 'Changes successfully was saved.'));
                if(!Yii::$app->request->isPjax){
                    if($model->language)
                        return $this->redirect(Url::to(['/user/profile/edit-profile', 'language'=>$model->language]));
                    return $this->refresh();
                }
            }else{
                Yii::$app->session->setFlash('error', Html::errorSummary($model, ['header'=>false,]));
            }
        }
        return $this->render('editProfile', [
            'model' => $model,
        ]);
    }

    public function actionShare()
    {
        $model = Token::find()->share()->last()->mine()->one();
        if(!$model)
            $model = new Token();

        if (Yii::$app->request->isPost)
        {
            Token::create(Token::ACTION_SHARE_LINK_TO_REGISTER, Yii::$app->user->identity);
            Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully generated new link to register.'));
            return $this->refresh();
        }
        return $this->render('share', [
            'model' => $model,
        ]);
    }

    public function actionInvite()
    {
        $model = new InviteForm();
        $this->performAjaxValidation($model);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate())
        {
            $token = Token::find()->share()->last()->mine()->one();
            if(!$token)
                $token = Token::create(Token::ACTION_SHARE_LINK_TO_REGISTER, Yii::$app->user->identity);

            Yii::$app->mailer->compose('invite-html', ['user' => Yii::$app->user->identity, 'token'=>$token,])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($model->email)
                ->setSubject(Yii::t('user', 'You invited user to register.'))
                ->send();

            Yii::$app->session->setFlash('success', Yii::t('user', 'You invited user to register.'));
            return $this->refresh();
        }
        return $this->render('invite', [
            'model' => $model,
        ]);
    }


    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;
        if(!$model->password_hash)
            $this->redirect(['set-password']);
        $model->scenario = 'changePassword';
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->setPassword($model->password_new);
            $model->save(false);
            Yii::$app->session->setFlash('successMessage', Yii::t('user', 'You successfully changed your password.'));
	    return $this->refresh();
        }else{
            $model->password_new = null;
            $model->password_new_repeat = null;
        }
        return $this->render('changePassword', [
            'model' => $model,
        ]);
    }
    public function actionSetPassword()
    {
        $model = Yii::$app->user->identity;
        if($model->password_hash)
            $this->redirect(['change-password']);
        $model->scenario='setPassword';
        $this->performAjaxValidation($model);

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->setPassword($model->password_set);
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully set your password.'));
            return $this->goAlert();
        }
        return $this->render('setPassword', [
            'model' => $model,
        ]);
    }

    public function actionChangeEmail()
    {
        $user = Yii::$app->user->identity;
        $user->scenario = 'changeEmail';
        $this->performAjaxValidation($user);
        if ($user->load(Yii::$app->request->post()) && $user->validate()){
            $token = Token::createForEmailChange(Token::ACTION_CHANGE_EMAIL, $user, $user->email_new);
            Yii::$app->mailer->compose('approveNewEmail-html', ['user' => $user, 'token'=>$token,])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                ->setTo([$user->email_new=>$user->fullName])
                ->setSubject(Yii::t('user', 'Approve to change your email.'))
                ->send();
            Yii::$app->session->setFlash('success', Yii::t('user', 'We sent to your new email a link to approve to change your email.'));
            return $this->refresh();
        }
        return $this->render('changeEmail', [
            'model' => $user,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

} 