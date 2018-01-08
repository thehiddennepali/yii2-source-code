<?php
$this->breadcrumbs = array(
    Yii::t('default', 'Schedule Days Templates') => array('index'),
    Yii::t('default', 'Manage')
);
?>

<div class="box">
    <div class="box-header">
        <h1 class="box-title"><?=Yii::t('default', 'Manage')?> <?= Yii::t('default', 'Schedule Days Templates')?></h1>
    </div>
    <div class="box-body">

        <?php $this->widget('booster.widgets.TbGridView', array(
            'id' => 'schedule-days-template-grid',
            'dataProvider' => $model->search(),
            'htmlOptions' => ['class' => 'dataTables_wrapper form-inline dt-bootstrap'],
            'filter' => $model,
            'columns' => array(
                'id',
                'title',
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => "{update} {delete}"
                ),
            ),
        )); ?>
    </div>
</div>
