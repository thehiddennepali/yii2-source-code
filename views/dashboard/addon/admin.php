<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Add-ons') => array('index'),
    Yii::t('default', 'Manage'),
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?= Yii::t('default', 'Manage') ?> <?= Yii::t('default', 'Add-ons') ?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'addon-grid',
            'dataProvider' => $model->searchForMerchant(),
            'filter' => $model,
            'columns' => array(
                'id',
                'name',
                'price',
                'time_in_minutes',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
