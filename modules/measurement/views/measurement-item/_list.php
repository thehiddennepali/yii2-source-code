<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['measurementitem/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('item_id');?>: <?=$model->item_id;?></b><br/>
    <b><?=$model->getAttributeLabel('master_unit');?>: <?=$model->master_unit;?></b><br/>
    <b><?=$model->getAttributeLabel('name');?>: <?=$model->name;?></b><br/>
    <b><?=$model->getAttributeLabel('factor');?>: <?=$model->factor;?></b><br/>
</div>