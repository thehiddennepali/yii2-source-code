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
use file\models\FileVideoNetwork;
use yii\db\Expression;

class FileVideoNetworkQuery  extends FileQuery
{
    public function queryNetwork()
    {
        $this->andOnCondition(['type'=>[FileVideoNetwork::TYPE_VIDEO_VK, FileVideoNetwork::TYPE_VIDEO_YOUTUBE]]);
        return $this;
    }
} 