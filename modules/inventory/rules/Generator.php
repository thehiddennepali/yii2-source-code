<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace inventory\rules;

use Yii;
use common\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $inventoryTaker = $auth->getRole(User::ROLE_INVENTORY_TAKER);


        $createInventorySheet = $auth->createPermission('createInventorySheet');
        $auth->add($createInventorySheet);
        $updateInventorySheet = $auth->createPermission('updateInventorySheet');
        $auth->add($updateInventorySheet);
        $deleteInventorySheet = $auth->createPermission('deleteInventorySheet');
        $auth->add($deleteInventorySheet);
        $viewInventorySheet = $auth->createPermission('viewInventorySheet');
        $auth->add($viewInventorySheet);
        $indexInventorySheet = $auth->createPermission('indexInventorySheet');
        $indexInventorySheet->description = "The list of InventorySheets to manage";
        $auth->add($indexInventorySheet);

        $auth->addChild($inventoryTaker, $createInventorySheet);
        $auth->addChild($inventoryTaker, $updateInventorySheet);
        $auth->addChild($inventoryTaker, $deleteInventorySheet);
        $auth->addChild($inventoryTaker, $viewInventorySheet);
        $auth->addChild($inventoryTaker, $indexInventorySheet);

    }

}