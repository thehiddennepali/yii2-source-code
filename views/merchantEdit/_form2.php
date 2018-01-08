<?php /*echo $form->dropDownListGroup($model,'package_id'
    ,array(
        'wrapperHtmlOptions' => array(
            'class' => 'col-sm-5',
        ),
        'widgetOptions' => array(
            'data' => CHtml::listData(Packages::model()->findAll(),'package_id','title'),
            'htmlOptions' => array('prompt'=>'select package'),
        )
    ));*/
?>
    <h2><?=Yii::t('default','Additional Info')?></h2>
    <p><?=Yii::t('default','Package')?>: <?= $model->package ? $model->package->title : '' ?></p>
<?php //echo $form->textFieldGroup($model,'payment_steps',array('class'=>'span5')); ?>


<?php echo $form->datepickerGroup($model, 'sponsored_expiration', array('options' => array('format' => 'Y-m-d'), 'htmlOptions' => array('class' => 'span5')), array('prepend' => '<i class="icon-calendar"></i>')); ?>

<?php echo $form->textFieldGroup($model, 'sort_featured', array('class' => 'span5')); ?>