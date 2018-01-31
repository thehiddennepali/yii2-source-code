<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['inventorysheet/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('name');?>: <?=$model->name;?></b><br/>
    <b><?=$model->getAttributeLabel('user_id');?>: <?=$model->user_id;?></b><br/>
    <b><?=$model->getAttributeLabel('created_at');?>: <?=$model->created_at;?></b><br/>
    <b><?=$model->getAttributeLabel('updated_at');?>: <?=$model->updated_at;?></b><br/>
    <b><?=$model->getAttributeLabel('status');?>: <?=$model->status;?></b><br/>
    <b><?=$model->getAttributeLabel('location_id');?>: <?=$model->location_id;?></b><br/>
    <b><?=$model->getAttributeLabel('sub_location_id');?>: <?=$model->sub_location_id;?></b><br/>
    <b><?=$model->getAttributeLabel('category_id');?>: <?=$model->category_id;?></b><br/>
</div>