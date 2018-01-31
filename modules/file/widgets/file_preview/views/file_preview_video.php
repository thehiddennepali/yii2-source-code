<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/12/16
 * Time: 12:05 PM
 */

use yii\helpers\Html;

echo \file\widgets\file_video_network\FileVideoNetworkWidget::widget();

if($video){
    $deleteLink=Html::a('<i class="glyphicon glyphicon-trash text-danger"></i>', ['/file/file-video-network/delete', 'id'=>$video->id], ['class'=>'kv-file-remove btn btn-xs btn-default','data' =>[ 'form'=>'anotherForm','confirm'=>Yii::t('app', 'Are you sure you want to delete this item?')]]);
    ?>
    <div class="file-preview form-control" style="height:auto;">
        <div class="file-drop-disabled">
            <div class="file-preview-thumbnails" >
                <div class="file-preview-frame" style="display: block; height: auto">
                    <?=$video->getImg([]);?>
                    <div class="file-thumbnail-footer">
                        <div title="<?=$video->title;?>" class="file-footer-caption"><?=$video->title;?></div>
                        <div class="file-actions">
                            <div class="file-footer-buttons">
                                <?=$deleteLink;?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}


