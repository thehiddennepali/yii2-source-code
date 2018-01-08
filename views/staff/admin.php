<?php
$this->breadcrumbs = array(
    Yii::t('basicfield', 'Staff') => array('index'),
    Yii::t('basicfield', 'Manage')
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield', 'Manage')?> <?=Yii::t('basicfield', 'Staff')?></h1>
        <?php if (Yii::app()->user->hasFlash('info'))
            $this->widget('booster.widgets.TbAlert', array(
                'fade' => true,
                'closeText' => '&times;', // false equals no close link
                'events' => array(),
                'htmlOptions' => array(),
                'userComponentId' => 'user',
                'alerts' => array( // configurations per alert typ
                    'info', // you don't need to specify full config
                ),
            )); ?>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'staff-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                array(
                    'name' => 'category_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(CategoryHasMerchant::model()->findAllByAttributes(['merchant_id' => Yii::app()->user->id]), 'id', 'title'),
                    'value' => '$data->allCatForEcho',
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>