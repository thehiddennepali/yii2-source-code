<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use demogorgorn\ajax\AjaxSubmitButton;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">

    <?php $form = ActiveForm::begin([
        'id' => 'staff-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('basicfield', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $form->errorSummary($model); ?>
    </div>
    <div class="box-body">

    <?php 
   echo Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('basicfield', 'Main Info'),
                    'content' => $this->render('_form1',['model'=>$model, 'form' => $form]),
                    'active' => true
                ],
                [
                    'label' => Yii::t('basicfield', 'Week Schedule'),
                    'content' => $this->render('_form2',['model'=>$model, 'form' => $form]),
                    'headerOptions' => [''],
                    'options' => ['id' => 'addition-info'],
                ],
                [
                    'label' => Yii::t('basicfield', 'Extra Schedule'),
                    'content' => $this->render('_form3',['model'=>$model, 'form' => $form]),
                    'headerOptions' => [''],
                    'options' => ['id' => 'seo'],
                ],
                
                [
                    'label' => Yii::t('basicfield', 'Vacations'),
                    'content' => $this->render('_form4',['model'=>$model, 'form' => $form]),
                    'headerOptions' => [''],
                    'options' => ['id' => 'vacation'],
                ],
                ]
       ]);?>
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
        'url' => Yii::$app->urlManager->createUrl(['staff/update','id'=>$model->id]),
        /*'cache' => false,*/
        'data'=> new \yii\web\JsExpression('new FormData($("#staff-form")[0])'),
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
