<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryHasMerchant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'service-subcategory-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('basicfield', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    
    <div class="box-body">
        
    <?= Html::img($model->behaviors['imageBehavior']->getImageUrl(), ['style' => 'width:150px;']) ?>
    <?php echo $form->field($model, 'image')->fileInput(); ?>
        
        
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'is_active')->checkBox() ?>
        
        
        <?= $form->field($model, 'cat_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(common\models\ServiceCategory::find()->where(['is_active' => 1])->all(), 'id', 'title'), 
             ['prompt'=>'select category',
              'onchange'=>'
                    $.ajax({
                        type : "post",
                        url  : "'.Yii::$app->urlManager->createUrl('service-subcategory/get-cats').'",
                        data : {cat_id:$(this).val()},
                        success : function(response){
                        
                            $("select#categoryhasmerchant-category_id").html(response)
                        
                        }
                  
                    })
                
            ']) ;?>
        
        <?php 
        
        $subcategory = \yii\helpers\ArrayHelper::map(\common\models\ServiceSubcategory::find()
                ->where([
                    'category_id' => ($model->subcategory) ? $model->subcategory->category_id : "",
                ])->all(), 'id', 'title');
        ?>

    <?= $form->field($model, 'category_id')->dropDownList($subcategory, ['prompt' => 'select subcategory']) ?>

    <?php  echo $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]);?>

    <?= $form->field($model, 'price')->textInput() ?>

    

    <?= $form->field($model, 'time_in_minutes')->textInput() ?>

    <?= $form->field($model, 'additional_time')->textInput() ?>

    <?= $form->field($model, 'service_time_slot')->textInput() ?>

     <?php  echo $form->field($model, 'addon_list')->widget(
	     Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Addon::find()->where(['merchant_id'=> Yii::$app->user->id])->all(), 'id', 'name'),
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?> 
    </div>
    <div class="box-footer">
        <?php
       
        if( Yii::$app->controller->action->id =='create'){?>
         <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        
        <?php }else { ?>
            <?php
            
                AjaxSubmitButton::begin([
                    
    'label' => Yii::t('basicfield','Update'),
    'ajaxOptions' => [
        'type' => 'POST',
        'url' => Yii::$app->urlManager->createUrl(['service-subcategory/update','id'=>$model->id]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#service-subcategory-form")[0])'),
        'cache'=> 'false',
                'contentType'=> false,
                'processData'=> false,
        'success' => new \yii\web\JsExpression('function(html){
            $("#w0").yiiGridView("applyFilter");
            
        }'),
    ],
    'options' => [
        'class' => 'btn btn-primary',
        'type' => 'button',
        'id' => 'addButtonFotThis'.'update' 
    ]
]);

AjaxSubmitButton::end();
            }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
