<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace item\rules;

use Yii;
use common\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createItem = $auth->createPermission('createItem');
        $auth->add($createItem);
        $updateItem = $auth->createPermission('updateItem');
        $auth->add($updateItem);
        $deleteItem = $auth->createPermission('deleteItem');
        $auth->add($deleteItem);
        $viewItem = $auth->createPermission('viewItem');
        $auth->add($viewItem);
        $indexItem = $auth->createPermission('indexItem');
        $indexItem->description = "The list of Items to manage";
        $auth->add($indexItem);

        $auth->addChild($administrator, $createItem);
        $auth->addChild($administrator, $updateItem);
        $auth->addChild($administrator, $deleteItem);
        $auth->addChild($administrator, $viewItem);
        $auth->addChild($administrator, $indexItem);

    }

}