<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MessagebirdDetails */

$this->title = Yii::t('basicfield', 'Create Messagebird Details');
$this->params['breadcrumbs'][] = ['label' => 'Messagebird Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="messagebird-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
