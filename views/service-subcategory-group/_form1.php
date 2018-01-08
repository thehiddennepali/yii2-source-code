<?php 
use vova07\imperavi\Widget;
use kartik\select2\Select2;

?>

<?= \yii\helpers\Html::img($model->behaviors['imageBehavior']->getImageUrl(),  ['style' => 'width:150px;']) ?>
<?php echo $form->field($model, 'image')->fileInput(); ?>

<?php echo $form->field($model, 'title'); ?>
<?php echo $form->field($model, 'is_active')->checkBox(); ?>

<?php  echo $form->field($model, 'description')->widget(Widget::className(), [
                'settings' => [
                   
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ]);?>

<?= $form->field($model, 'cat_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(common\models\ServiceCategory::find()->where(['is_active' => 1])->all(), 'id', 'title'), 
             ['prompt'=>Yii::t('basicfield', 'select category'),
              'onchange'=>'
                    $.ajax({
                        type : "post",
                        url  : "'.Yii::$app->urlManager->createUrl('service-subcategory/get-cats').'",
                        data : {cat_id:$(this).val()},
                        success : function(response){
                        
                            $("select#categoryhasmerchant-category_id").html(response)
                        
                        }
                  
                    })
                
            ']) ;?>

<?php 
        
        $subcategory = \yii\helpers\ArrayHelper::map(\common\models\ServiceSubcategory::find()
                ->where([
                    'category_id' => ($model->subcategory) ? $model->subcategory->category_id : "",
                ])->all(), 'id', 'title');
        ?>

<?= $form->field($model, 'category_id')->dropDownList($subcategory, 
    ['prompt' => Yii::t('basicfield','select subcategory')]) ?>

<?php 
echo $form->field($model, 'staff_id')
        ->dropDownList(
                \yii\helpers\ArrayHelper::map(common\models\Staff::find()->where([
                    'merchant_id' => Yii::$app->user->id
                ])->all(), 'id', 'name'), [
                    'prompt' => Yii::t('basicfield','Select Staffs')
                ]
                );
?>



<?php echo $form->field($model, 'group_people'); ?>

<?php echo $form->field($model, 'price'); ?>
<?php echo $form->field($model, 'time_in_minutes'); ?>

<div class="form-group">
     <?php  echo $form->field($model, 'addon_list')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Addon::find()->where(['merchant_id'=> Yii::$app->user->id])->all(), 'id', 'name'),
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?>
</div>