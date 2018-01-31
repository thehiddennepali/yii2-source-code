<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model delivery\models\DeliveryForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use user\models\User;
use user\assets\AppAsset;


AppAsset::register($this);


$this->title = 'Send email messages to users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                'id' => 'delivery-form',
                'enableAjaxValidation'=>true,
                'enableClientValidation'=>true,
            ]);
            ?>
            <?php
            echo $form->field($model, 'role')
                ->radioList((new User())->rolesValues);
            ?>

            <?= $form->field($model, 'recipients')
                ->dropDownList(ArrayHelper::map(User::find()->all(), function($user){
                        return $user->email.'|'.$user->fullName;
                    }, 'fullName'),
                [
                    'multiple' => true,
                ]); ?>


            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

            <?= $form->field($model, 'type')->radioList($model->typeValues)->hint("
            Immediately method sends messages directly to emails.
            Later method sends messages accroding to cron tasks.
            "); ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<?php
