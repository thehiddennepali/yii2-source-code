<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 5/8/16
 * Time: 1:22 PM
 */

namespace user\controllers;



use cebe\gravatar\Gravatar;
use extended\controller\Controller;
use file\models\File;
use user\models\LoginForm;
use user\models\PasswordResetRequestForm;
use user\models\ResetPasswordForm;
use user\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\Request;
use yii\helpers\Url;
use user\models\SignupForm;
use user\models\Token;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class GuestController extends Controller
{
    public function actions()
    {
        //$route=Yii::$app->requestedRoute;
        //$route=explode('/',$route);
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        if(!$_GET['authclient'])
            throw new Exception("authclient is missing");
        $attributes=\frontend\models\User::customizeAttributes($client->getUserAttributes(), $_GET['authclient']);

        if(!isset($attributes['email']) || !$attributes['email'])
            throw new Exception("Email is missing");
        if(!(   $user=\frontend\models\User::findOne(['email'=>$attributes['email']])   ))
        {
            $user = new \frontend\models\User;
            $user->email=$attributes['email'];
            $user->rolesAttribute=[User::ROLE_ADMINISTRATOR];
        }
        //$user->scenario='network';
        $user->fillFields($attributes);
        $user->status=User::STATUS_ACTIVE;
        $user->save();


        if($attributes['photo'])
        {
            if($user->image)
                $user->image->delete();
            $user->imageAttribute = new UploadedFile();
            $user->imageAttribute->name = "from network.jpg";
            $user->imageAttribute->tempName =  (new File())->copy("http://sakura/1.jpg") ;
            //$user->imageAttribute->tempName =  (new File())->copy($attributes['photo']) ;
            $user->save();
        }
        if(!$user->id)
            throw new Exception(strip_tags(Html::errorSummary($user, ['header'=>false,])));

        Yii::$app->user->login($user, 3600 * 24 * 30);

        return $this->goBackWithLanguage();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'auth'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['signup', 'signup2'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['request-password-reset', 'reset-password', 'resend-activate-link'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function actionSignup()
    {
        $gravatar = new Gravatar([
            'email' => 'nurbek.nurjanov123123@mail.ru',
            'defaultImage'=>404,
        ]);

        if(isset($_GET['from'])){
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'from',
                'value' => $_GET['from'],
                'expire' => time() + 3600*24,
            ]));
        }
        $model = new SignupForm();
        if(isset($_SESSION['SignupForm']))
            $model->attributes = $_SESSION['SignupForm'];
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            foreach ($_POST['SignupForm'] as $attribute=>$value)
                $_SESSION['SignupForm'][$attribute]=$value;
            return $this->redirect(['signup2']);
        }
        return $this->render('signup/step1', [
            'model' => $model,
        ]);
    }

    public function actionSignup2()
    {
        $model = new SignupForm();
        $model->scenario='step2';
        if(isset($_SESSION['SignupForm']))
            $model->attributes = $_SESSION['SignupForm'];
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $user = $model->signup();

            $gravatar = new Gravatar([
                'email' => $user->email,
                'defaultImage'=>404,
            ]);
            if (!preg_match("/404 Not Found/i", get_headers($gravatar->imageUrl)[0])){
                $user->imageAttribute = new UploadedFile();
                $user->imageAttribute->name = "from gravatar.jpg";
                $user->imageAttribute->tempName = (new File())->copy($gravatar->imageUrl);
                $user->save(false);
            }

            unset($_SESSION['SignupForm']);
            Yii::$app->session->setFlash('success', Yii::t('user', 'Thank you for signing up. We have sent to your email a link to activate your account.'));
            return $this->goAlert();
        }
        return $this->render('signup/step2', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function goBackWithLanguage()
    {
        //return url and language
        $request = new Request();
        $request->baseUrl = Yii::$app->request->baseUrl;
        $request->scriptUrl = Yii::$app->request->scriptUrl;
        //$request->url = "/ru/elektronika/kompyutery/noutbuki?qwe=qwe";
        //$request->url = "/ru/product/product/view?id=5";
        $request->url = Yii::$app->getUser()->getReturnUrl(null);

        $parse = parse_url($request->url);
        if(isset($parse['query']))
            parse_str($parse['query'], $getParams);
        else
            $getParams=[];

        $pathInfo = $request->resolve()[0];
        $pathInfo = trim($pathInfo, "/");
        $pathInfo = str_replace(Yii::$app->language, '', $pathInfo);
        $pathInfo = trim($pathInfo, "/");
        $request->pathInfo = $pathInfo;

        $params = array_merge(Yii::$app->urlManager->parseRequest($request)[1], $request->resolve()[1], $getParams);

        $route = Yii::$app->urlManager->parseRequest($request)[0];
        $route = trim($route, "/");
        $route = str_replace(Yii::$app->language, '', $route);//$route = preg_replace('/^('.Yii::$app->language.'|mouse)|inend$/', '', $route);
        $route = trim($route, "/");
        $params['language'] = Yii::$app->user->identity->language;
        unset($params['code']);
        unset($params['state']);
        if(isset($params['authclient']))
            return $this->action->redirect( Url::to([0=>'/'.$route] + $params) );
        return Yii::$app->response->redirect(Url::to([0=>'/'.$route] + $params));
    }


    public function actionLogin()
    {
        //$this->layout = '@backend/views/layouts/authenticate';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            if(isset(Yii::$app->user->identity->language) && Yii::$app->user->identity->language){
                return $this->goBackWithLanguage();
            }
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionResendActivateLink($username)
    {
        $user = User::findByUsernameOrEmail($username);
        if(!$user)
            throw new InvalidParamException('The username is invalid.');
        $token = Token::create(Token::ACTION_ACTIVATE_ACCOUNT, $user);
        Yii::$app->mailer->compose('activateAccount-html', ['user' => $user, 'token'=>$token,])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo([$user->email=>$user->fullName])
            ->setSubject(Yii::t('app', 'You requested to activate your account.'))
            ->send();
        Yii::$app->session->setFlash('success', Yii::t('user', 'We have sent to your email a link to activate your account.'));
        return $this->goAlert();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()){
                Yii::$app->session->setFlash('success', Yii::t('user', 'Check your email for further instructions.'));
                return $this->refresh();
            }
            else
                Yii::$app->session->setFlash('error', Yii::t('user', 'Sorry, we are unable to reset password for email provided.'));
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
            Yii::$app->session->setFlash('success', Yii::t('user', 'You successfully set new password.'));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
} 