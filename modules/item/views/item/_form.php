<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model item\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size_unit')->dropDownList($model->unitValues,['prompt'=>'Select']) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'gtin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'unit_measure')->dropDownList([ 'ea' => 'Ea', 'lb' => 'Lb', 'oz' => 'Oz', 'ft' => 'Ft', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'purchasable')->textInput() ?>

    <?= $form->field($model, 'item_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categories_json')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ingredients_json')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'diet_labels')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'alergens')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'has_ingredients')->textInput() ?>

    <?= $form->field($model, 'inner_pack')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'outer_pack')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'depth')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cube_unit')->textInput() ?>

    <?= $form->field($model, 'orig_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight_interval')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bricks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'yield')->textInput() ?>

    <?= $form->field($model, 'unit_weight')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'item_type')->dropDownList([ 'product' => 'Product', 'packing_material' => 'Packing material', 'processed_material' => 'Processed material', 'raw_material' => 'Raw material', 'spec' => 'Spec', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'prod_pounds_per_man_hour')->textInput() ?>

    <?= $form->field($model, 'assembly_people_count')->textInput() ?>

    <?= $form->field($model, 'assembly_units_hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'labor_process')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'container_type_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
