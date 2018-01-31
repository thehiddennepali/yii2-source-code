<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
use inventory\models\Location;
use inventory\models\Category;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use item\models\Item;
use inventory\models\InventoryLocationManualCount;
use yii\bootstrap\Modal;
use inventory\models\ItemLocation;
use user\models\User;
use measurement\models\MeasurementItem;

\inventory\assets\InventoryAsset::register($this, ['is_new_record'=>$model->isNewRecord, 'date'=>Yii::$app->formatter->asDate(time())]);

/* @var $this yii\web\View */
/* @var $model inventory\models\InventorySheet */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin([
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    //'options' => ['class' => 'form-horizontal', /*'enctype' => 'multipart/form-data'*/],
    'fieldConfig' => [
        //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
        //'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],
]);


?>
<div class="row">


    <div class="col-lg-4" style="display: inline-block"><h1><?= Html::encode($this->title) ?></h1></div>
    <?php
    if(!Yii::$app->request->isPost)
        $model->name = Yii::$app->formatter->asDate(time());
    ?>
    <div class="col-lg-4" style="display: inline-block"><?= $form->field($model, 'name') ?></div>
    <?php //echo $form->field($model, 'status')->dropDownList($model->statusValues, ['prompt'=>Yii::t('app', 'Select'),]) ?>

    <div class="clear"></div>
    <div class="col-lg-12"><?=$form->errorSummary($model);?></div>

    <br/>

    <div class="col-lg-2"><?= $form->field($model, 'location_id')->dropDownList(ArrayHelper::map(Yii::$app->user->identity->locations, 'id', 'nickname'), ['prompt'=>'Select']) ?></div>
    <div class="col-lg-2"><?= $form->field($model, 'sub_location_id')->dropDownList([], ['prompt'=>'Select']) ?></div>
    <div class="col-lg-2"><?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'category_name'), ['prompt'=>'Select']) ?></div>

    <div class="clear"></div>


    <div class="col-lg-12">
        <?php
        echo GridView::widget(
            [
                'dataProvider' => $dataProvider,
                'columns'=>[
                    'item_name',
                    'item_description',
                    'case',
                    [
                        'attribute'=>'size',
                        'format'=>'raw',
                        'value'=>function($data){
                            return $data->sizeText;
                        },
                    ],
                    [
                        'attribute'=>'low_par',
                        'label'=>'low amt / par',
                        'format'=>'raw',
                        'value'=>function(Item $data){
                            if($itemLocation = $data->itemLocation){
                                $parText = (int) $itemLocation->low_amount.'/'. (int) $itemLocation->par;
                                return Html::a($parText, 'javascript:void', [
                                    'class'=>'parLink',
                                    'data-item_id'=>$data->id,
                                    'data-par'=>$itemLocation->par,
                                    'data-low_amount'=>$itemLocation->low_amount,
                                    'data-alert_user_id'=>$itemLocation->alert_user_id,
                                    'data-alert_email'=>$itemLocation->alert_email,
                                ]);
                            }

                            $parText = '+';
                            return Html::a($parText, 'javascript:void', [
                                'class'=>'parLink',
                                'data-item_id'=>$data->id,
                            ]);
                        },
                    ],
                    [
                        'attribute'=>(new InventoryLocationManualCount)->getAttributeLabel('on_hand_quantity'),
                        'format'=>'raw',
                        'contentOptions'=>function($data){
                            return ['class'=>'inventory-count', 'data-item_id'=>$data->id];
                        },
                        'value'=>function(Item $data) use ($form, $inventory_location_manual_counts){
                            $inventory_location_manual_count = $inventory_location_manual_counts[$data->id];
                            $quantityField = $form->field($inventory_location_manual_count, "[$data->id]on_hand_quantity", [
                                'options'=>['style'=>'display:inline-block; width:50px;vertical-align:top;'],
                                'inputOptions'=>['class'=>'form-control','style'=>'display:inline-block; width:50px;']])
                                ->error(['style'=>'font-size:10px;white-space:normal;'])
                                ->label(false);
                            $unitField = $form->field($inventory_location_manual_count, "[$data->id]unit",
                                [
                                    'options'=>['style'=>'display:inline-block;  width:100px; vertical-align:top;'],
                                    'inputOptions'=>['class'=>'form-control','style'=>'display:inline-block; width:100px;']])
                                ->dropDownList($data->unitValues, ['prompt'=>'Select'])
                                ->error(['style'=>'font-size:10px;white-space:normal;'])
                                ->label(false);
                            $link = Html::a('+ add alt unit', 'javascript:void', [
                                'class'=>'addAltUnit',
                                'data-item_id'=>$data->id,
                            ]);
                            return $quantityField.' '.$unitField.' '.$link;
                        },
                    ],
                    [
                        'attribute'=>'Cost',
                        'value'=>function(Item $data) use ($form, $inventory_location_manual_counts){
                            $inventory_location_manual_count = $inventory_location_manual_counts[$data->id];
                            return $inventory_location_manual_count->countCost;
                        },
                    ],
                ]
            ]
        );
        ?>
    </div>


    <div class="form-group">
        <div class="col-lg-12" style="text-align: right">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>


</div>

<?php ActiveForm::end(); ?>




<?php
Modal::begin([
    'id'=>'parModal',
    'header' => 'Low amount / par',
    'clientOptions' => ['show' => false]
]);
?>

<?php
$model = new ItemLocation;
    $form = ActiveForm::begin([
        'action'=>['/inventory/inventory-sheet/par'],
        'id' => 'parForm',
        'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],
        ],
    ]);
    ?>
    <?=$form->errorSummary($model);?>

    <?=Html::activeHiddenInput($model, 'item_id');?>
    <?=Html::activeHiddenInput($model, 'location_id');?>

    <?=$form->field($model, 'low_amount', [
        'options'=>['class'=>'form-group',],
        'parts'=>[
            '{input}'=> Html::tag("div",
                Html::activeTextInput($model, "low_amount", ['class'=>'form-control']).
                Html::tag("span", Html::tag("button", 'CS', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                ['class'=>'input-group', 'style'=>'width:150px;'])
        ]
    ]) ?>
    <?=$form->field($model, 'par', [
        'options'=>['class'=>'form-group',],
        'parts'=>[
            '{input}'=> Html::tag("div",
                Html::activeTextInput($model, "par", ['class'=>'form-control']).
                Html::tag("span", Html::tag("button", 'CS', ['class'=>'btn btn-default']),['class'=>'input-group-btn']),
                ['class'=>'input-group', 'style'=>'width:150px;'])
        ]
    ]) ?>
    <?=$form->field($model, 'alert_user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'fullName'), ['prompt'=>'Select'])?>
    <?=$form->field($model, 'alert_email')->radioList(Yii::$app->formatter->booleanFormat)?>

    <div class="form-group">
        <div class="col-lg-8 col-lg-offset-4">
            <?= Html::submitButton('Save', ['class' => 'btn btn-warning']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

<?php
Modal::end();
?>













<?php
Modal::begin([
    'id'=>'altModal',
    'header' => 'Alternative unit',
    'clientOptions' => ['show' => false]
]);
?>

<?php
$model = new MeasurementItem;
$form = ActiveForm::begin([
    'action'=>['/measurement/measurement-item/add'],
    'id' => 'altForm',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-lg-8\">{input}{hint}</div>\n<div class=\"col-lg-8 col-lg-offset-4\">{error}</div>",
        'labelOptions' => ['class' => 'col-lg-4 control-label'],
    ],
]);
?>
<?=$form->errorSummary($model);?>

<?=$form->field($model, 'master_unit')->dropDownList(['CS'=>'Case', 'EA'=>'Each'])?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'factor')->hint("How many of these in the master unit.")?>

<div class="form-group">
    <div class="col-lg-8 col-lg-offset-4">
        <?= Html::submitButton('Add', ['class' => 'btn btn-warning']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
Modal::end();
?>











