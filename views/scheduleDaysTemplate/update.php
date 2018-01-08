<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Schedule Days Templates') => array('index'),
    Yii::t('default', 'Update'),
);
?>

    <h1><?= Yii::t('default', 'Update')?> <?=Yii::t('default', 'Schedule Days Template')?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>