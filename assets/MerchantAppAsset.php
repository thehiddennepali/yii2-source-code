<?php

namespace merchant\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MerchantAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
        'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'css/fullcalendar.min.css',
        'dist/css/AdminLTE.min.css',
        'dist/css/skins/skin-blue.css',
        ['css/fullcalendar.print.css','media' => 'print'],
        'favicon.ico',
        'dist/css/custom.css',
        ['images/favicon.ico', 'type'=>'image/png', 'rel'=>"shortcut icon"],
        
        
    ];
    public $js = [
        
        'https://cdn.socket.io/socket.io-1.4.5.js',
        'dist/js/app.js',
        'js/moment.min.js',
        //'js/jquery.min.js',
        'js/fullcalendar.min.js',
        
        'js/locale-all.js',
        //'js/locale/nl.js'
        
        
        
        
    ];
    
    public $cssOptions = [
        
    ];
    
    public $jsOptions = array(
        //'position' => View::POS_HEAD // too high
        //'position' => View::POS_READY // in the html disappear the jquery.jrac.js declaration
        //'position' => View::POS_LOAD // disappear the jquery.jrac.js
         'position' => \yii\web\View::POS_HEAD // appear in the bottom of my page, but jquery is more down again
    );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
