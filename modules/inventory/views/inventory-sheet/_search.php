<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\DatePicker;
use kartik\datetime\DateTimePicker;
        
/* @var $this yii\web\View */
/* @var $model inventory\models\search\InventorySheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-sheet-search advancedSearch"  style="<?=isset($_GET['searchForm']) ? '':'display: none;';?>" >

    <?php $form = ActiveForm::begin([
        'action' => '/'.Yii::$app->controller->route,
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'created_at')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'created_at',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'updated_at')->widget(DateTimePicker::className(), [
        'model' => $model,
        'attribute' => 'updated_at',
        'options' => ['placeholder' => 'Select time'],
        'convertFormat' => true,
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd H:i',
            'todayHighlight' => true
        ]
    ]) ?>

    <?php echo $form->field($model, 'status')->dropDownList($model->statusValues, ['prompt'=>Yii::t('app', 'Select'),]) ?>

    <?php echo $form->field($model, 'location_id') ?>

    <?php echo $form->field($model, 'sub_location_id') ?>

    <?php echo $form->field($model, 'category_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default', 'onclick'=>"javascript:window.location.href='".Url::to(['/'.Yii::$app->controller->route])."'"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<p><?= Html::button(Yii::t('app', 'Advanced search'), ['class' => 'btn btn-success advancedSearchButton']) ?></p>