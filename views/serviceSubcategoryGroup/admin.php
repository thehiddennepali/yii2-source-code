<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Group Services') => array('index'),
    Yii::t('default', 'Manage'),
);

?>
<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default', 'Manage')?> <?=Yii::t('default', 'Group Services')?></h1>
    </div>
    <div class="box-body">
        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'service-subcategory-grid',
            'dataProvider' => $model->searchGroup(),
            'htmlOptions' => ['class' => 'dataTables_wrapper form-inline dt-bootstrap'],
            'filter' => $model,
            'columns' => array(
                array(
                    'name' => 'category_id',
                    'type' => 'raw',
                    'filter' => CHtml::listData(ServiceSubcategory::model()->findAll(), 'id', 'title'),
                    'value' => '$data->subcategory->title',
                ),
                'title',
                'group_people',
                array(
                    'name' => 'is_active',
                    'type' => 'raw',
                    'filter' => array('1' => 'Yes', '0' => 'No'),
                    'value' => '$data->is_active ? "Yes" : "No" ',
                ),
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