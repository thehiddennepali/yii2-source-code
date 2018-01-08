<?php
$this->breadcrumbs = array(
    Yii::t('default','Reviews') => array('index'),
    Yii::t('default','Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default','Manage')?> <?= Yii::t('default','Reviews')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'review-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                'id',
                /*'merchant_id',
                'client_id',*/
                'review',
                'rating',
                array(
                    'name' => 'merchant_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(Merchant::model()->findAll(), 'id', 'service_name'),
                    'value' => '$data->merchant?$data->merchant->service_name:""',
                ),
                array(
                    'name' => 'status',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->status ? "Yes" : "No" ',
                ),
                'date_created',
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
