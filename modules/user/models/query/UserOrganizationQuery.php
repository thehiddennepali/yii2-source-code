<?php

namespace user\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\user\models\UserOrganization]].
 *
 * @see \user\models\UserOrganization
 */
class UserOrganizationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \user\models\UserOrganization[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \user\models\UserOrganization|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}