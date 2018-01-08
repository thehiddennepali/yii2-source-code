<?php


$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lmvMIa5lH_o-q_Jd2uWA0rqcXkIpp_5E',
        ],
        
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => $smtpHost,
//                'username' => $smtpUsername,
//                'password' => $smtpPassword,
//                'port' => $smtpPort,
//                'encryption' => 'tls',
//            ],
//        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs'=>['192.168.0.*']
    ];
}

return $config;
