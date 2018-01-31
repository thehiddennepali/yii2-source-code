<?php

namespace po\rules;

use Yii;
use common\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createPo = $auth->createPermission('createPo');
        $auth->add($createPo);
        $updatePo = $auth->createPermission('updatePo');
        $auth->add($updatePo);
        $deletePo = $auth->createPermission('deletePo');
        $auth->add($deletePo);
        $viewPo = $auth->createPermission('viewPo');
        $auth->add($viewPo);
        $indexPo = $auth->createPermission('indexPo');
        $indexPo->description = "The list of Purchase Orders to manage";
        $auth->add($indexPo);

        $auth->addChild($administrator, $createPo);
        $auth->addChild($administrator, $updatePo);
        $auth->addChild($administrator, $deletePo);
        $auth->addChild($administrator, $viewPo);
        $auth->addChild($administrator, $indexPo);

    }

}