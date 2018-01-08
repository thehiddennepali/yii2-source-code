<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Single Services') => array('index'),
    Yii::t('default', 'Manage'),
);

?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default', 'Manage')?> <?=Yii::t('default', 'Single Services')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'service-subcategory-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'htmlOptions' => ['class' => 'dataTables_wrapper form-inline dt-bootstrap'],
            'columns' => array(
                array(
                    'name' => 'category_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ServiceSubcategory::model()->findAll(), 'id', 'title'),
                    'value' => '$data->subcategory->title',
                ),
                'title',
                array(
                    'name' => 'is_active',
                    'type' => 'raw',
                    'filter' => array('1' => Yii::t('default','yes'), '0' => Yii::t('default','no')),
                    'value' => '$data->is_active ? Yii::t("default","yes") : Yii::t("default","no") ',
                ),
                'price',
                'time_in_minutes',
                'additional_time',
                'service_time_slot',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
