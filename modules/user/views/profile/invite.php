<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model user\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('user', 'Invite to register');
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

    <?= $form->field($model, 'email'); ?>

    <div class="form-group">
        <div class="">
            <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
