<?php
$this->breadcrumbs = array(
    Yii::t('basicfield','Reviews') => array('index'),
    Yii::t('basicfield','Manage'),
);
$this->menu = false;
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?=Yii::t('basicfield','Reviews')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                'review',
                'rating',
                'status',
                /*
                'date_created',
                'ip_address',
                'order_id',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>