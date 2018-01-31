<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
use recipe\models\Ingredient;
use yii\helpers\ArrayHelper;
use item\models\Item;
use recipe\models\Recipe;

/* @var $this yii\web\View */
/* @var $model item\models\Item */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
$form = new ActiveForm([
    'id'=>'recipeForm',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
]);
$model = new Recipe;
$data = new Ingredient;
$i = $index;
?>

<tr data-key="<?=$i?>">
    <td>
        <?=$form->field($data, "[$i]item_id", ['template'=>'{input}{error}',
            'options'=>['style'=>'display:inline-block; width:100%;',]])
            ->error(['style'=>'font-size:10px;white-space:normal;'])
            ->label(false)
            ->dropDownList(ArrayHelper::map(Item::find()->onlyRaw()->all(), 'id', 'item_name'),['prompt'=>'Select'])
        ?>
    </td>
    <td>
        <?=$form->field($data, "[$i]amount", ['template'=>'{input}{error}', 'errorOptions'=>[ 'class'=>'help-block', 'style'=>'font-size:10px;white-space:normal;',],
            'options'=>['style'=>'display:inline-block; width:100px; vertical-align:top; ']])->label(false)
        .' '.
        $form->field($data, "[$i]unit", ['template'=>'{input}{error}',
            'options'=>['style'=>'display:inline-block; width:100px;vertical-align:top;']])
            ->error(['style'=>'font-size:10px; white-space:normal;'])
            ->label(false)
            ->dropDownList($model->unitValues,['prompt'=>'Select'])
        ?>
    </td>
    <td></td>
    <td>
        <?php
        $buttons = Html::a('Remove', 'javascript:void(0)', ['class'=>'btn btn-danger btn-xs removePercent', 'data-i'=>$i]);
        $buttons.=Html::activeHiddenInput($data, "[$i]id");
        echo $buttons;
        ?>
    </td>
</tr>