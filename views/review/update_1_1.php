<?php
$this->breadcrumbs=array(
    Yii::t('default','Reviews')=>array('index'),
	Yii::t('default','Update'),
);
	?>

	<h1><?=Yii::t('default','Update')?> <?= Yii::t('default','Review')?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>