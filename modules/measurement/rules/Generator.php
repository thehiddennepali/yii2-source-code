<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace measurement\rules;

use Yii;
use common\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createMeasurement = $auth->createPermission('createMeasurement');
        $auth->add($createMeasurement);
        $updateMeasurement = $auth->createPermission('updateMeasurement');
        $auth->add($updateMeasurement);
        $deleteMeasurement = $auth->createPermission('deleteMeasurement');
        $auth->add($deleteMeasurement);
        $viewMeasurement = $auth->createPermission('viewMeasurement');
        $auth->add($viewMeasurement);
        $indexMeasurement = $auth->createPermission('indexMeasurement');
        $indexMeasurement->description = "The list of Measurements to manage";
        $auth->add($indexMeasurement);

        $auth->addChild($administrator, $createMeasurement);
        $auth->addChild($administrator, $updateMeasurement);
        $auth->addChild($administrator, $deleteMeasurement);
        $auth->addChild($administrator, $viewMeasurement);
        $auth->addChild($administrator, $indexMeasurement);

    }

}