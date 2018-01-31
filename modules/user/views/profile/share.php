<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model user\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'Link to register');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="user-form">

    <?php $form = ActiveForm::begin(
        [
            'enableAjaxValidation'=>false,
            'enableClientValidation'=>true,
            //'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                //'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
                //'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]
    ); ?>

    <?=$form->errorSummary($model);?>

    <?php $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/user/guest/signup', 'from' => Yii::$app->user->identity->email]); ?>
    <?= $form->field($model, 'token', ['parts'=>['{input}'=>"<code style='display: block'>{$url}</code>"],])->label(Yii::t('user', 'Static link to register')); ?>

    <?php
    $url = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['user/token/run', 'token' => $model->token])
    ?>
    <?=$form->field($model, 'token', ['parts'=>['{input}'=>$model->token ? "<code style='display: block'>{$url}</code>":false],])
        ->label(Yii::t('user', 'Token link to register'));
    ?>




    <div class="form-group">
        <div class="">
            <?= Html::submitButton(Yii::t('user', 'Generate token link to register'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
