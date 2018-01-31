<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/6/16
 * Time: 11:57 AM
 */

namespace file\widgets\file_preview;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class FilePreview extends Widget
{
    public $image;
    public $images;
    public $video;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        \kartik\file\FileInputAsset::register(Yii::$app->view);
        \common\assets\LightboxAsset::register(Yii::$app->view);
        \file\widgets\file_video_network\assets\FileVideoNetworkAsset::register(Yii::$app->view);
        if($this->images)
            return $this->render("file_preview_images", ['images'=>$this->images]);
        if($this->image)
            return $this->render("file_preview_image", ['image'=>$this->image]);
        if($this->video)
            return $this->render("file_preview_video", ['video'=>$this->video]);
    }
}