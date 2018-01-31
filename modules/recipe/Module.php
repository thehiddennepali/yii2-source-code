<?php

/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 10/25/16
 * Time: 2:05 PM
 */

namespace recipe;


use file\widgets\file_video_network\FileVideoNetworkWidget;
use recipe\assets\RecipeAsset;
use Yii;


class Module extends \yii\base\Module
{
    public function init()
    {
        RecipeAsset::register(Yii::$app->view);
        parent::init();
    }
}