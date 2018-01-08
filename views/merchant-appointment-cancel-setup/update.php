<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MerchantAppointmentCancelSetup */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Merchant Appointment Cancel Setup',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Merchant Appointment Cancel Setups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="merchant-appointment-cancel-setup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
