<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use file\models\FileImage;
use yii\bootstrap\Tabs;
use file\widgets\file_preview\FilePreview;


/* @var $this yii\web\View */
/* @var $model user\models\User */

$this->title = Yii::t('user', 'My profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= $this->title ?></h1>

    <?php $detailView =  DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'first_name',
            'last_name',
            [
                'attribute'=>'email',
                'format'=>'raw',
                'value'=>$model->email.' '.Html::a(Yii::t('app', 'Change'), ['/user/profile/change-email'], ['class'=>'btn btn-success btn-xs',]),
            ],
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
        ],
    ]);


    echo Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('user', 'Personal details'),
                'content' => $detailView,
                'options' => ['tag' => 'div'],
                'headerOptions' => ['class' => 'my-class'],
            ],
            [
                'label' => Yii::t('app', 'Description'),
                'content' => '<br>'.$model->description,
                'options' => ['id' => 'my-tab'],
            ],
            [
                'label' => Yii::t('app', 'Photos'),
                'content' => '<br>'. FilePreview::widget(['images'=>$model->images]),
                'options' => ['id' => 'my-tab3'],
            ],
            /*[
                'label' => 'Ajax tab',
                'url' => ['ajax/content'],
            ],*/
        ],
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'headerOptions' => ['class' => 'my-class'],
        'clientOptions' => ['collapsible' => false],
    ]);
    ?>

</div>
