<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace recipe\rules;

use Yii;
use common\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createRecipe = $auth->createPermission('createRecipe');
        $auth->add($createRecipe);
        $updateRecipe = $auth->createPermission('updateRecipe');
        $auth->add($updateRecipe);
        $deleteRecipe = $auth->createPermission('deleteRecipe');
        $auth->add($deleteRecipe);
        $viewRecipe = $auth->createPermission('viewRecipe');
        $auth->add($viewRecipe);
        $indexRecipe = $auth->createPermission('indexRecipe');
        $indexRecipe->description = "The list of Recipes to manage";
        $auth->add($indexRecipe);

        $auth->addChild($administrator, $createRecipe);
        $auth->addChild($administrator, $updateRecipe);
        $auth->addChild($administrator, $deleteRecipe);
        $auth->addChild($administrator, $viewRecipe);
        $auth->addChild($administrator, $indexRecipe);

    }

}