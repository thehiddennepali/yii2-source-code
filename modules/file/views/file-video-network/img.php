<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/6/16
 * Time: 11:31 AM
 */

use yii\helpers\Html;

?>
<div class="file-preview form-control" style="height:auto;">
    <div class="close fileinput-remove">×</div>
    <div class="file-drop-disabled">
        <div class="file-preview-thumbnails">
            <?php
            if($video = $model){
                ?>
                <?php
                $deleteLink=Html::a('<i class="glyphicon glyphicon-trash text-danger"></i>', 'javascript:void(0)', ['class'=>'kv-file-remove btn btn-xs btn-default localDelete']);
                ?>
                <div class="file-preview-frame">
                    <?=$video->img;?>
                    <div class="file-thumbnail-footer">
                        <div title="<?=$video->title;?>" class="file-footer-caption"><?=$video->title;?></div>
                        <div class="file-actions">
                            <div class="file-footer-buttons">
                                <?php echo $deleteLink;?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
