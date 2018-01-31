<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace file\widgets\file_video_network\assets;

use yii\web\AssetBundle;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FileVideoNetworkAsset extends AssetBundle
{
    public $sourcePath = '@file/widgets/file_video_network/asset_source';
    public $css = [
        'css/video.css'
    ];
    public $js = [
        'js/video.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
