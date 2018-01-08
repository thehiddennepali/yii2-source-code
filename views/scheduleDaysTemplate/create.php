<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Schedule Days Templates') => array('index'),
    Yii::t('default', 'Create')
);
?>

    <h1><?=Yii::t('default', 'Create')?> <?=Yii::t('default', 'Schedule Days Template')?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>