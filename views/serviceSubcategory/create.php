<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Single Services') => array('index'),
    Yii::t('default', 'Create'),
);?>

    <h1><?=Yii::t('default', 'Create')?> <?=Yii::t('default', 'Single Service')?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>