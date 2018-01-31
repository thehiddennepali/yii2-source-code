<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 5/19/16
 * Time: 7:24 PM
 */

namespace file\models;


use file\models\search\FileSearch;
use yii\helpers\ArrayHelper;

trait FileTrait
{
    public function getAllTypeValues()
    {
        return ArrayHelper::merge((new File)->typeValues, (new FileImage)->typeValues, (new FileVideoNetwork)->typeValues);
    }
    public function getIcon($options=[])
    {
        /**
         * @var File $this
         */
        switch(true){
            case $this->type==File::TYPE_AUDIO:{
                break;
            }
            case $this->type==File::TYPE_DOC:{
                break;
            }
            case in_array( $this->type, [FileImage::TYPE_SINGLE_IMAGE, FileImage::TYPE_IMAGE_MAIN, FileImage::TYPE_IMAGE]):{
                $fileImage = new FileImage();
                $fileImage->attributes = $this->attributes;
                return $fileImage->getImg($options);
                break;
            }
        }
    }
} 