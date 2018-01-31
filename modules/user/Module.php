<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 2/11/16
 * Time: 2:29 PM
 */

namespace user;

use Yii;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'user';
    public function init()
    {
        Yii::$app->mailer->viewPath = '@user/mail';
        parent::init();
    }
}