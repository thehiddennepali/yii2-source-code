<h2><?=Yii::t('basicfield','Gallery')?></h2>
<div class="alert alert-info">
<!--    <strong><?=Yii::t('basicfield','')?>!</strong>-->
<?=Yii::t('basicfield','Important! First photo in list will be main gallery photo.')?>
</div>
<?php
//if ($model->behaviors['galleryBehavior']->getGallery() === null) {
//    echo '<p>'.Yii::t('basicfield','Before add photos to product gallery, you need to save product').'</p>';
//} else {
    
    echo \common\extensions\gallerymanager\GalleryManager::widget([
        'gallery' => $model->behaviors['galleryBehavior']->getGallery(),
        'controllerRoute' => '/gallery',
    ]);
    
    
    
//}
?>