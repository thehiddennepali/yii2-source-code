<?php
use yii\helpers\Html;
?>
<div class="col-lg-6 well">
    <b><?=Html::a($model->title, ['item/view', 'id'=>$model->id,]);?></b><br/>
    <b><?=$model->getAttributeLabel('id');?>: <?=$model->id;?></b><br/>
    <b><?=$model->getAttributeLabel('item_name');?>: <?=$model->item_name;?></b><br/>
    <b><?=$model->getAttributeLabel('create_time');?>: <?=$model->create_time;?></b><br/>
    <b><?=$model->getAttributeLabel('update_time');?>: <?=$model->update_time;?></b><br/>
    <b><?=$model->getAttributeLabel('gtin');?>: <?=$model->gtin;?></b><br/>
    <b><?=$model->getAttributeLabel('published');?>: <?=$model->published;?></b><br/>
    <b><?=$model->getAttributeLabel('unit_measure');?>: <?=$model->unit_measure;?></b><br/>
    <b><?=$model->getAttributeLabel('purchasable');?>: <?=$model->purchasable;?></b><br/>
    <b><?=$model->getAttributeLabel('item_description');?>: <?=$model->item_description;?></b><br/>
    <b><?=$model->getAttributeLabel('categories_json');?>: <?=$model->categories_json;?></b><br/>
    <b><?=$model->getAttributeLabel('ingredients_json');?>: <?=$model->ingredients_json;?></b><br/>
    <b><?=$model->getAttributeLabel('diet_labels');?>: <?=$model->diet_labels;?></b><br/>
    <b><?=$model->getAttributeLabel('alergens');?>: <?=$model->alergens;?></b><br/>
    <b><?=$model->getAttributeLabel('short_name');?>: <?=$model->short_name;?></b><br/>
    <b><?=$model->getAttributeLabel('image_url');?>: <?=$model->image_url;?></b><br/>
    <b><?=$model->getAttributeLabel('sku');?>: <?=$model->sku;?></b><br/>
    <b><?=$model->getAttributeLabel('has_ingredients');?>: <?=$model->has_ingredients;?></b><br/>
    <b><?=$model->getAttributeLabel('inner_pack');?>: <?=$model->inner_pack;?></b><br/>
    <b><?=$model->getAttributeLabel('outer_pack');?>: <?=$model->outer_pack;?></b><br/>
    <b><?=$model->getAttributeLabel('height');?>: <?=$model->height;?></b><br/>
    <b><?=$model->getAttributeLabel('width');?>: <?=$model->width;?></b><br/>
    <b><?=$model->getAttributeLabel('depth');?>: <?=$model->depth;?></b><br/>
    <b><?=$model->getAttributeLabel('cube_unit');?>: <?=$model->cube_unit;?></b><br/>
    <b><?=$model->getAttributeLabel('orig_id');?>: <?=$model->orig_id;?></b><br/>
    <b><?=$model->getAttributeLabel('weight');?>: <?=$model->weight;?></b><br/>
    <b><?=$model->getAttributeLabel('weight_interval');?>: <?=$model->weight_interval;?></b><br/>
    <b><?=$model->getAttributeLabel('prep');?>: <?=$model->prep;?></b><br/>
    <b><?=$model->getAttributeLabel('bricks');?>: <?=$model->bricks;?></b><br/>
    <b><?=$model->getAttributeLabel('yield');?>: <?=$model->yield;?></b><br/>
    <b><?=$model->getAttributeLabel('unit_weight');?>: <?=$model->unit_weight;?></b><br/>
    <b><?=$model->getAttributeLabel('item_type');?>: <?=$model->item_type;?></b><br/>
    <b><?=$model->getAttributeLabel('prod_pounds_per_man_hour');?>: <?=$model->prod_pounds_per_man_hour;?></b><br/>
    <b><?=$model->getAttributeLabel('assembly_people_count');?>: <?=$model->assembly_people_count;?></b><br/>
    <b><?=$model->getAttributeLabel('assembly_units_hour');?>: <?=$model->assembly_units_hour;?></b><br/>
    <b><?=$model->getAttributeLabel('labor_process');?>: <?=$model->labor_process;?></b><br/>
    <b><?=$model->getAttributeLabel('container_type_id');?>: <?=$model->container_type_id;?></b><br/>
</div>