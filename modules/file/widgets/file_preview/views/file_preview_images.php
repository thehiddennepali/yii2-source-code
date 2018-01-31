<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/12/16
 * Time: 12:05 PM
 */

use yii\helpers\Html;
use file\models\FileImage;



if($images){
    ?>
    <div class="file-preview form-control" style="height:auto;">
        <div class="file-drop-disabled">
            <div class="file-preview-thumbnails" >
                <?php
                foreach ($images as $image) {
                    $deleteLink=Html::a('<i class="glyphicon glyphicon-trash text-danger"></i>', ['/file/file-image/delete', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default',
                        'data' =>[
                            'form'=>'anotherForm',
                            'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?')]]);
                    $mainLink=Html::a('<i class="glyphicon glyphicon-unchecked"></i>', ['/file/file-image/main', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default']);
                    if($image->type==FileImage::TYPE_IMAGE_MAIN)
                        $mainLink=Html::a('<i class="glyphicon glyphicon-log-out"></i>', ['/file/file-image/not-main', 'id'=>$image->id], ['class'=>'kv-file-remove btn btn-xs btn-default']);

                    ?>
                    <div class="file-preview-frame" style="display: block; height: auto">
                        <a href="<?=$image->imageUrl;?>" data-lightbox="file-preview">
                            <?=$image->getImg([]);?>
                        </a>
                        <div class="file-thumbnail-footer">
                            <div title="<?=$image->title;?>" class="file-footer-caption"><?=$image->title;?></div>
                            <div class="file-actions">
                                <div class="file-footer-buttons">
                                    <?=$mainLink;?>
                                    <?=$deleteLink;?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
}


