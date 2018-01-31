<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 9/23/16
 * Time: 11:31 AM
 */

namespace user\rules;

use Yii;
use user\models\User;


class Generator
{
    public static function run()
    {

        $auth = Yii::$app->authManager;
        $guest = $auth->getRole(User::ROLE_GUEST);
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $userRule = new UserRule();
        $auth->add($userRule);
        $createUser = $auth->createPermission('createUser');
        $auth->add($createUser);
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->ruleName=$userRule->name;
        $auth->add($updateUser);
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->ruleName=$userRule->name;
        $auth->add($deleteUser);
        $viewUser = $auth->createPermission('viewUser');
        $auth->add($viewUser);
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = "The list of users to manage";
        $auth->add($indexUser);

        $auth->addChild($administrator, $createUser);
        $auth->addChild($administrator, $updateUser);
        $auth->addChild($administrator, $deleteUser);
        $auth->addChild($administrator, $viewUser);
        $auth->addChild($administrator, $indexUser);
    }
}