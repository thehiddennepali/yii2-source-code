<?php

namespace user\models\query;
use file\models\File;
use yii\db\Expression;
use user\models\Token;

/**
 * This is the ActiveQuery class for [[\user\models\Token]].
 *
 * @see \user\models\Token
 */
class TokenQuery extends \yii\db\ActiveQuery
{

    public function last()
    {
        return $this->orderBy("created_at DESC");
    }
    public function mine()
    {
        return $this->andWhere(['user_id'=>\Yii::$app->user->id,]);
    }
    public function share()
    {
        return $this->andWhere(['action'=>Token::ACTION_SHARE_LINK_TO_REGISTER,]);
    }

    public function notRun()
    {
        return $this->andWhere(['run'=>0,]);
    }

    public function date($date)
    {
        return $this->andWhere([ '>=' ,'created_at', date('Y-m-d H:i:s', time() - 3600*24*$date)]);
    }

    public function activate()
    {
        return $this->andWhere(['OR',
            ['action'=>Token::ACTION_ACTIVATE_ACCOUNT],
            ['action'=>Token::ACTION_ACTIVATE_ACCOUNT_FROM_ADMINISTRATOR]
        ]);
    }
}