<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MerchantAppointmentCancelSetup */

$this->title = Yii::t('basicfield', 'Create Merchant Appointment Cancel Setup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Merchant Appointment Cancel Setups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-appointment-cancel-setup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
