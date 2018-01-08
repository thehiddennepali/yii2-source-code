<?php
$site=dirname(dirname(dirname(__FILE__))); // this will give you the / directory
Yii::setPathOfAlias('site', $site);

return array(
	'name'=>'Admin module',
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'defaultController'=>'dashboard',
    //'language'=>'de',
    'preload' => array(
        'debug',
        'booster'
    ),
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.widgets.*',
         'site.common.extensions.*',
        'site.common.extensions.gallerymanager.models.*',
        'site.common.extensions.gallerymanager.*',
        'site.common.extensions.yii-image.*',
        'site.common.models.*',
        'site.common.components.*',
        'site.common.widgets.*'
	),
	
	//'language'=>'default',
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
            'generatorPaths' => array(
                'booster.gii',
            ),
        ),
    ),

			
	'components'=>array(
        'format'=>array(
            'class'=>'site.common.components.Formatter',
        ),
        'booster' => array(
            'class' => 'site.protected.vendor.clevertech.yii-booster.src.components.Booster',
        ),
        'user'=>array(
            // this is actually the default value
            'class' => 'WebUser',
            'loginUrl'=>array('login'),
            'allowAutoLogin'=>true,
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
               /* array (
                    'class' => 'CWebLogRoute'
                )*/
            ),
        ),
        'debug' => array(
            'class' => 'site.protected.vendor.zhuravljov.yii2-debug.Yii2Debug', // composer installation
            //'class' => 'ext.yii2-debug.Yii2Debug', // manual installation
        ),
	    'urlManager'=>array(
		    'urlFormat'=>'path',
		    'rules'=>array(
		        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
		        '<controller:\w+>'=>'<controller>/index',
		        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',		        
		    ),
		    'showScriptName'=>false,
		),
				
		'db'=>array(	        
		    'class'            => 'CDbConnection' ,
			'connectionString' => 'mysql:host=localhost;dbname=appointment-portal',
			'emulatePrepare'   => true,
			'username'         => 'root',
			'password'         => '',
			'charset'          => 'utf8',
			'tablePrefix'      => 'mt_',
           'enableProfiling' => true,
            'enableParamLogging' => true,
	    ),
	    
	    'functions'=> array(
	       'class'=>'Functions'	       
	    ),
	    'validator'=>array(
	       'class'=>'Validator'
	    ),
	    'widgets'=> array(
	       'class'=>'Widgets'
	    ),
	    	    
	    'Smtpmail'=>array(
	        'class'=>'application.extension.smtpmail.PHPMailer',
	        'Host'=>"YOUR HOST",
            'Username'=>'YOUR USERNAME',
            'Password'=>'YOUR PASSWORD',
            'Mailer'=>'smtp',
            'Port'=>587, // change this port according to your mail server
            'SMTPAuth'=>true,   
	    ), 
	    
	    'GoogleApis' => array(
	         'class' => 'application.extension.GoogleApis.GoogleApis',
	         'clientId' => '', 
	         'clientSecret' => '',
	         'redirectUri' => '',
	         'developerKey' => '',
	    ),
	),
    
    'params' => array(
        'project'      => 'appointment-portal',
    )
);