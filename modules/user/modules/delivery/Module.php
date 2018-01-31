<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 2/11/16
 * Time: 2:29 PM
 */

namespace delivery;

use Yii;


class Module extends \yii\base\Module
{
    public $defaultRoute = 'delivery';
    public function init()
    {
        parent::init();
        Yii::configure(Yii::$app, require(__DIR__ . '/config/main.php'));
    }
}