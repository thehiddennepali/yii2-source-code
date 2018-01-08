<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StaffVacation */

$this->title = Yii::t('basicfield', 'Create Staff Vacation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Staff Vacations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-vacation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
