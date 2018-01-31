<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 5/19/16
 * Time: 3:37 PM
 */

namespace file\models\query;
use file\models\File;
use file\models\FileImage;
use yii\db\Expression;

class FileImageQuery  extends FileQuery
{
    public function queryImage()
    {
        $this->andOnCondition(['type'=>FileImage::TYPE_SINGLE_IMAGE,]);
        return $this;
    }
    public function queryMainImage()
    {
        $this->andOnCondition(['type'=>FileImage::TYPE_IMAGE_MAIN,]);
        return $this;
    }
    public function queryImages()
    {
        $this->andOnCondition(['type'=>[FileImage::TYPE_IMAGE_MAIN, FileImage::TYPE_IMAGE],])->orderBy(new Expression("FIELD({{%file}}.type,".FileImage::TYPE_IMAGE_MAIN.",".FileImage::TYPE_IMAGE.")"));
        return $this;
    }
} 