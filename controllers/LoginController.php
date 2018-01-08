<?php
namespace merchant\controllers;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use Yii;

class LoginController extends Controller
{
	public function actionIndex()
	{
        $this->layout='login_tpl';

        if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
            throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

        $model=new \merchant\models\LoginForm;
        $model->role = 1;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form' && $model->load(Yii::$app->request->post()))
        {
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            $model->role = 1;
            
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                $session = Yii::$app->session;
                $session['role'] = 1;
                
                $this->redirect(Yii::$app->user->returnUrl);
            }
        }
        // display the login form
        return $this->render('login',array('model'=>$model));
	}

    public function actionManager()
    {
        $this->layout='login_tpl';

        if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
            throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

        $model=new \merchant\models\LoginForm;;
        $model->role = 0;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'&& $model->load(Yii::$app->request->post()))
        {
            echo json_encode(ActiveForm::validate($model));
            Yii::$app->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            $model->role = 0;

            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login()){
                $session = Yii::$app->session;
                $session['role'] = 0;
                $this->redirect(Yii::$app->user->returnUrl);
            }
        }
        // display the login form
        return $this->render('login',array('model'=>$model));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(['index']);
    }
    
    
    public function actionRequestPasswordReset()
    {
        
        $this->layout='login_tpl';
        $model = new \merchant\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                $model = new \merchant\models\PasswordResetRequestForm();
                //return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    
    
    public function actionResetPassword($token)
    {
        $this->layout='login_tpl';
        try {
            $model = new \merchant\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}