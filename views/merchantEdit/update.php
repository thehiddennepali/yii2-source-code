<?php


$this->title = 'Merchant Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('default','Merchant'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<h1><?=Yii::t('default', 'Update')?> <?=Yii::t('default', 'Merchant')?> <?php echo $model->service_name; ?></h1>
<div class="box box-primary">
    <?php  
    
    $formS = ActiveForm::begin([
        'id' => 'service-category-form',
        'enableAjaxValidation' => false,
        'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
    <div class="box-header with-border">
        <p class="help-block"><?=Yii::t('default', 'Fields with {span} are required.',['span'=>'<span class="required">*</span>'])?></p>

        <?php echo $formS->errorSummary($model); ?>
    </div>

    <div class="box-body">
        <?php echo $this->render($form, ['model' => $model, 'form' => $formS]); ?>
    </div>
    <?php if ($form != '_form4') { ?>
        <div class="box-footer">
             <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>