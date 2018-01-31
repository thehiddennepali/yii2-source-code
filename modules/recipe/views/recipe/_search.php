<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model item\models\search\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'item_name') ?>

    <?= $form->field($model, 'create_time') ?>

    <?= $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'gtin') ?>

    <?php // echo $form->field($model, 'published') ?>

    <?php // echo $form->field($model, 'unit_measure') ?>

    <?php // echo $form->field($model, 'purchasable') ?>

    <?php // echo $form->field($model, 'item_description') ?>

    <?php // echo $form->field($model, 'categories_json') ?>

    <?php // echo $form->field($model, 'ingredients_json') ?>

    <?php // echo $form->field($model, 'diet_labels') ?>

    <?php // echo $form->field($model, 'alergens') ?>

    <?php // echo $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'image_url') ?>

    <?php // echo $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'has_ingredients') ?>

    <?php // echo $form->field($model, 'inner_pack') ?>

    <?php // echo $form->field($model, 'outer_pack') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'depth') ?>

    <?php // echo $form->field($model, 'cube_unit') ?>

    <?php // echo $form->field($model, 'orig_id') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'weight_interval') ?>

    <?php // echo $form->field($model, 'prep') ?>

    <?php // echo $form->field($model, 'bricks') ?>

    <?php // echo $form->field($model, 'yield') ?>

    <?php // echo $form->field($model, 'unit_weight') ?>

    <?php // echo $form->field($model, 'item_type') ?>

    <?php // echo $form->field($model, 'prod_pounds_per_man_hour') ?>

    <?php // echo $form->field($model, 'assembly_people_count') ?>

    <?php // echo $form->field($model, 'assembly_units_hour') ?>

    <?php // echo $form->field($model, 'labor_process') ?>

    <?php // echo $form->field($model, 'container_type_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
