<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['measurement/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('name');?>: <?=$model->name;?></b><br/>
    <b><?=$model->getAttributeLabel('short_name');?>: <?=$model->short_name;?></b><br/>
    <b><?=$model->getAttributeLabel('coefficient');?>: <?=$model->coefficient;?></b><br/>
    <b><?=$model->getAttributeLabel('type');?>: <?=$model->type;?></b><br/>
</div>