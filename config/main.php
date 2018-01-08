<?php
$params = array_merge(
    //require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'merchant\controllers',
    
    'defaultRoute' => 'dashboard/index',
    
    'modules' => [
        'gridview' =>  [
             'class' => '\kartik\grid\Module'
         ]
     ],
    
    
    'components' => [
        
        'image' => array(
                'class' => 'yii\image\ImageDriver',
                'driver' => 'GD',  //GD or Imagick
                ),
            
        
        'format'=>array(
            'class'=>'common\components\Formatter',
        ),
         'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceLanguage' => 'en-US', // Developer language
                    'sourceMessageTable' => '{{%source_message}}',
                    'messageTable' => '{{%message}}',
                    //'cachingDuration' => 86400,
                    //'enableCaching' => true,
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-merchant',
        ],
        'user' => [
            'identityClass' => 'common\models\Merchant',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login/index'],
            'identityCookie' => [
                'name' => '_merchantUser', // unique for frontend
                //'path'=>'/merchant/web'  // correct path for the frontend app.
            ]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '_merchantSessionId',
            'savePath' => __DIR__ . '/../runtime', // a temporary folder on frontend
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
        
        'cache' => [
            /* 'class' => 'yii\caching\FileCache', */
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                ],
            ],
            'useMemcached' => false,
            'serializer' => false,
            
        ],
        
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
    ],
    'params' => $params,
];
