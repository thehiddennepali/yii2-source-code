<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use user\models\User;
use file\widgets\file_preview\FilePreview;

/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute'=>'rolesAttribute',
                'value'=>$model->rolesText,
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
            'description:raw',
            [
                'attribute'=>'language',
                'format'=>'raw',
                'value'=>$model->languageText,
            ],
            [
                'attribute'=>'time_zone',
                'format'=>'raw',
                'value'=>$model->timeZoneText,
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute'=>'imageAttribute',
                'format'=>'raw',
                'value'=>$model->image ? $model->image->img : null,
            ],
            [
                'attribute'=>'imagesAttribute',
                'format'=>'raw',
                'value'=>$model->images ?  FilePreview::widget(['images'=>$model->images]) : null,
            ],
        ],
    ]) ?>

</div>
