<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace inventory\assets;

use user\models\User;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\AssetBundle;
use Yii;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\ActiveFormAsset;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InventoryAsset extends AssetBundle
{
    public $sourcePath = '@inventory/assets_source';
    public $js = [
        'js/inventory.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public static function register($view, $variables=[])
    {
        foreach ($variables as $name=>$value)
            Yii::$app->view->registerJs("
                var $name = '".$value."';
            ", View::POS_HEAD);
        return parent::register($view);
    }
}
