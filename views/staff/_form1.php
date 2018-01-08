<?php 
use kartik\select2\Select2;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;
use vova07\imperavi\Widget;
?>

<?= \yii\helpers\Html::img($model->behaviors['imageBehavior']->getImageUrl(),  ['style' => 'width:150px;']) ?>
<?php echo $form->field($model, 'image')->fileInput(); ?>
<?php echo $form->field($model, 'name'); ?>
<div class="form-group">
    <label class="control-label" for="staff-name">About</label>
    <?php  echo $form->field($model, 'description')->widget(Widget::className(), [
        'settings' => [

            'minHeight' => 200,
            'plugins' => [
                'clips',
                'fullscreen'
            ]
        ]
    ]);?>

</div>


    <br>
<?php echo $form->field($model, 'is_active')->checkBox(); ?>
<div class="form-group">
<?php  echo $form->field($model, 'category_list')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\CategoryHasMerchant::find()->where(['merchant_id'=> Yii::$app->user->id])->all(), 'id', 'title'),
                'options' => [
                    'multiple' => true,
                    'class'=>'grey-fields full-width'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
             ?>
    
    
</div>
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