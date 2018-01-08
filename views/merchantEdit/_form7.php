<h2><?=Yii::t('default','Gallery')?></h2>
<div class="alert alert-info">
    <strong><?=Yii::t('default','Important')?>!</strong>
<?=Yii::t('default','First photo in list will be main gallery photo.')?>
</div>
<?php
if ($model->galleryBehavior->getGallery() === null) {
    echo '<p>'.Yii::t('default','Before add photos to product gallery, you need to save product').'</p>';
} else {
    $this->widget('GalleryManager', array(
        'gallery' => $model->galleryBehavior->getGallery(),
        'controllerRoute' => '/gallery',
    ));
}
?>