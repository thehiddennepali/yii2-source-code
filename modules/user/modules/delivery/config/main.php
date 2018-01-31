<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 8/27/16
 * Time: 5:11 PM
 */


return [
    'components'=>[
        'cronMailer' => [
            'class' => 'delivery\CronMailer',
        ],
    ],
    'params'=>array_merge(Yii::$app->params , [
    ]),
];

