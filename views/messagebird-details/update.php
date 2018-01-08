<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MessagebirdDetails */

$this->title = Yii::t('basicfield', 'Update Messagebird Detail');
$this->params['breadcrumbs'][] = ['label' => 'Messagebird Details', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="messagebird-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
	'merchant' => $merchant
    ]) ?>

</div>
