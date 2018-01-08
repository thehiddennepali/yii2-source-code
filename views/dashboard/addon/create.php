<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Add-ons') => array('index'),
    Yii::t('default', 'Create'),
);
?>

    <h1><?= Yii::t('default', 'Create') ?> <?= Yii::t('default', 'Add-on') ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>