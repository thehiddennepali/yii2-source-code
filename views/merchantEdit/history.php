<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Merchant') => array('index'),
    Yii::t('default','Merchant History'),
);
$this->menu = false;
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Merchant History')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'work_date',
                array(
                    'name' => 'schedule_days_template_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ScheduleDaysTemplate::model()->findAllByAttributes(['merchant_id'=>Yii::app()->user->id]),'id','title'),
                    'value' => '$data->scheduleDaysTemplate->title',
                ),
                'reason',
            ),
        )); ?>
    </div>
</div>