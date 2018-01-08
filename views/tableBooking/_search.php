<?php
Yii::app()->getClientScript()
    ->scriptMap = array(
    'jquery.js' => false,
    'jquery-ui.min.js' => false
);
?>
<h2><?php echo CategoryHasMerchant::model()->findByPk($model->category_id)->title . ' ' . $model->order_time ?></h2>
<?php $this->widget('booster.widgets.TbGridView', array(
    'id' => 'group-order-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,

    'columns' => array(
        'id',
        'client_name',
        'client_phone',
        'client_email',
        'price',
       // 'is_payd',
        /*
        'servise_date',
        'more_info',
        'price',
        'is_payd',
        */
        array(
            'header' => 'update',
            'urlExpression' => 'array("order/getGroupOrder","id"=>$data->id)',
            'linkHtmlOptions' => ['class' => 'groupEditLink'],
            'class' => 'CLinkColumn'
        ),
        array(
            'header' => 'remove',
            'urlExpression' => 'array("groupOrder/remove","id"=>$data->id)',
            'linkHtmlOptions' => ['class' => 'groupDeleteLink'],
            'class' => 'CLinkColumn'
        ),

    ),
)); ?>
