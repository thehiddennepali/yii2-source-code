<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Add-ons') => array('index'),
    Yii::t('default', 'Update'),
);
?>

    <h1><?= Yii::t('default', 'Update') ?> <?= Yii::t('default', 'Add-on') ?> <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>