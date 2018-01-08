<?php
$this->breadcrumbs = array(
    Yii::t('basicfield','Voucher') => array('index'),
    Yii::t('basicfield','Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('basicfield','Manage')?> <?=Yii::t('basicfield','Voucher')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'voucher-new-grid',
            'dataProvider' => $model->searchMerchant(),
            'filter' => $model,
            'columns' => array(
                'voucher_id',
                //'voucher_owner',
                //'merchant_id',
                //'joining_merchant',
                'voucher_name',
                //'voucher_type',
                array(
                    'name' => 'voucher_type',
                    'type' => 'raw',
                    'filter' => Voucher::getTypes(),
                    'value' => '$data->voucherTypeName',
                ),
                'amount',
                /*
                'amount',
                'expiration',
                'status',
                'date_created',
                'date_modified',
                'ip_address',
                'used_once',
                */
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
