<?php

namespace file\models\query;
use file\models\File;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\file\models\File]].
 *
 * @see \file\models\File
 */
class FileQuery extends \yii\db\ActiveQuery
{

    public function queryModel($model)
    {
        return $this->andOnCondition(['model_name'=>$model]);
    }
    public function queryModelId($model_id)
    {
        return $this->andOnCondition(['model_id'=>$model_id]);
    }
    public function queryType($type)
    {
        return $this->andOnCondition(['type'=>$type]);
    }
}