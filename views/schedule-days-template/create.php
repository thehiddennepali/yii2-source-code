<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ScheduleDaysTemplate */

$this->title = Yii::t('basicfield', 'Create Schedule Days Template');
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield', 'Schedule Days Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-days-template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
