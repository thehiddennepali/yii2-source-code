<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace recipe\assets;

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
class RecipeAsset extends AssetBundle
{
    public $sourcePath = '@recipe/assets_source';
    public $js = [
        'js/recipe.js',
    ];
    public $depends = [
        'yii\widgets\ActiveFormAsset'
    ];


}
