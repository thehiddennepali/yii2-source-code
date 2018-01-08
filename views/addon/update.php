<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Addon */

$this->title = Yii::t('basicfield', 'Update {modelClass}: ', [
    'modelClass' => 'Addon',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Addons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('basicfield', 'Update');
?>
<div class="addon-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
