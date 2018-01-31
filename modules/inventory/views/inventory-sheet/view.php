<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use item\models\Item;
use inventory\models\InventoryLocationManualCount;

/* @var $this yii\web\View */
/* @var $model inventory\models\InventorySheet */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inventory Sheets'), 'url' => [Yii::$app->controller->defaultAction]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-sheet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
		if(Yii::$app->user->can('updateInventorySheet', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
        ?>
        <?php
        if(Yii::$app->user->can('deleteInventorySheet', ['model' => $model]))
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute'=>'user_id',
                'format'=>'raw',
                'value'=>$model->user ? $model->user->fullName:null,
            ],
            [
                'attribute'=>'created_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'updated_at',
                'format'=>'datetime',
            ],
            [
                'attribute'=>'status',
                'value'=>$model->statusText,
            ],
            [
                'attribute'=>'location_id',
                'format'=>'raw',
                'value'=>$model->location ? $model->location->nickname:null,
            ],
            'sub_location_id',
            [
                'attribute'=>'category_id',
                'format'=>'raw',
                'value'=>$model->category ? $model->category->category_name:null,
            ],
        ],
    ]) ?>

    <?php

    echo GridView::widget(
        [
            'dataProvider' => new ArrayDataProvider(['allModels'=>$inventory_location_manual_counts, 'pagination'=>false]),
            'columns'=>[
                [
                    'attribute'=>(new Item)->getAttributeLabel('item_name'),
                    'format'=>'raw',
                    'value'=>function(InventoryLocationManualCount $data){
                        return $data->item->item_name;
                    },
                ],
                [
                    'attribute'=>(new Item)->getAttributeLabel('item_description'),
                    'format'=>'raw',
                    'value'=>function(InventoryLocationManualCount $data){
                        return $data->item->item_description;
                    },
                ],
                [
                    'attribute'=>(new Item)->getAttributeLabel('case'),
                    'format'=>'raw',
                    'value'=>function(InventoryLocationManualCount $data){
                        return $data->item->case;
                    },
                ],
                [
                    'attribute'=>(new Item)->getAttributeLabel('size'),
                    'format'=>'raw',
                    'value'=>function(InventoryLocationManualCount $data){
                        return $data->item->sizeText;
                    },
                ],
                'countCost',
            ]
        ]
    );
    ?>

</div>
