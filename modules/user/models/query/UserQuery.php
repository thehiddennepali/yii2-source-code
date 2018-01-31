<?php

namespace user\models\query;
use file\models\File;
use user\models\User;
use yii\db\Expression;
use user\models\Token;

/**
 * This is the ActiveQuery class for [[\user\models\User]].
 *
 * @see \user\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \user\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \user\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function defaultFrom()
    {
        return $this->from(['u'=>User::tableName()]);
    }

    public function rolesQuery($roles)
    {
        return $this->leftJoin('{{%auth_assignment}} a', 'u.id=a.user_id')
            ->groupBy('u.id')
            ->andWhere(['a.item_name'=>$roles]);
    }
}