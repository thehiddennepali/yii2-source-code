<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use recipe\models\Ingredient;
use yii\helpers\ArrayHelper;
use item\models\Item;

/* @var $this yii\web\View */
/* @var $model item\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php
    $form = ActiveForm::begin([
        'id'=>'recipeForm',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
    ]);
    ?>

    <?=$form->errorSummary($model)?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'item_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'selling_price', [
                'parts'=>[
                    '{input}'=> Html::tag("div",
                        Html::activeTextInput($model, "selling_price", ['class'=>'form-control']).
                        Html::tag("span", Html::tag("button", '$', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                        ['class'=>'input-group', 'style'=>'width:150px;'])
                ],
            ]); ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'cost_percent', [
                'parts'=>[
                    '{input}'=> Html::tag("div",
                        Html::activeTextInput($model, "cost_percent", ['class'=>'form-control', 'readonly' => true]).
                        Html::tag("span", Html::tag("button", '%', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                        ['class'=>'input-group', 'style'=>'width:150px;'])
                ],
            ]) ?>
        </div>
    </div>

    <?php
    $i=0;
    ob_start();

    ?>
    <div class="row" >
        <div class="col-lg-3 col-lg-offset-6">
            <?= $form->field($model, 'total_recipe_cost', [
                'parts'=>[
                    '{input}'=> Html::tag("div",
                        Html::activeTextInput($model, "total_recipe_cost", ['class'=>'form-control', 'readonly' => true]).
                        Html::tag("span", Html::tag("button", '$', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                        ['class'=>'input-group', 'style'=>'width:150px;'])
                ],
            ]) ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'profit', [
                'parts'=>[
                    '{input}'=> Html::tag("div",
                        Html::activeTextInput($model, "profit", ['class'=>'form-control', 'readonly' => true]).
                        Html::tag("span", Html::tag("button", '$', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                        ['class'=>'input-group', 'style'=>'width:150px;'])
                ],
            ]) ?>
        </div>
    </div>
    <?php
    echo GridView::widget(
        [
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $ingredients,
                'pagination'=>false,
            ]),
            'columns'=>[
                [
                    'attribute'=>'item_id',
                    'format'=>'raw',
                    'value'=>function(Ingredient $data) use ($form, &$i){
                        return $form->field($data, "[$i]item_id", ['template'=>'{input}{error}',
                            'options'=>['style'=>'display:inline-block; width:100%;',]])
                            ->error(['style'=>'font-size:10px;white-space:normal;'])
                            ->label(false)
                            ->dropDownList(ArrayHelper::map(Item::find()->onlyRaw()->all(), 'id', 'item_name'),['prompt'=>'Select'])
                            ;
                    },
                ],
                [
                    'attribute'=>'amount',
                    'format'=>'raw',
                    'value'=>function(Ingredient $data) use ($form, &$i, $model){
                        return $form->field($data, "[$i]amount", ['template'=>'{input}{error}', 'errorOptions'=>[ 'class'=>'help-block', 'style'=>'font-size:10px;white-space:normal;',],
                            'options'=>['style'=>'display:inline-block; width:100px; vertical-align:top; ']])->label(false)
                        .' '.
                        $form->field($data, "[$i]unit", ['template'=>'{input}{error}',
                            'options'=>['style'=>'display:inline-block; width:100px;vertical-align:top;']])
                            ->error(['style'=>'font-size:10px; white-space:normal;'])
                            ->label(false)
                            ->dropDownList($data->item ? $data->item->unitValues:$model->unitValues,['prompt'=>'Select'])
                            ;
                    },
                ],
                [
                    'attribute'=>'cost',
                    'format'=>'currency',
                    'value'=>function(Ingredient $data) use (&$model) {
                        if($data->item)
                            return $data->item->poundPrice * $data->amount;
                    },
                    'contentOptions'=>function(Ingredient $data) use (&$model) {
                        $cost = 0;
                        if($data->item)
                            $cost = $data->item->poundPrice * $data->amount;
                        return ['data-cost'=>$cost, 'class'=>'ingredient-cost',];
                    },
                ],
                [
                    'header'=>'Actions '.Html::a('Add', 'javascript:void(0)', ['class'=>'btn btn-success btn-xs addPercent']),
                    'format'=>'raw',
                    'value'=>function(Ingredient $data) use (&$i){
                        $buttons = Html::a('Remove', 'javascript:void(0)', ['class'=>'btn btn-danger btn-xs removePercent', 'data-i'=>$i]);
                        $buttons.=Html::activeHiddenInput($data, "[$i]id");
                        $i++;
                        return $buttons;
                    },
                ],
            ]
        ]
    );
    $content = ob_get_contents();
    ob_end_clean();
    ?>
    <br/>
    <?= $form->field($model, 'ingredientAttribute', ['parts'=>['{input}'=>$content]])->label("ITEM INGREDIENTS"); ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
