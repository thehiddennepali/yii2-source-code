

<?php 
use yii\helpers\Html;
use backend\assets\AppAsset
?>

    <style type="text/css">
        .col-centered{
            float: none;
            margin: 0 auto;
            width: 256px;
        }
    </style>
</head>
    
    <?php 
    AppAsset::register($this);
    
    
    $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php 
        
        $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ;
        
        ?>
        
        <div class="content">
  <?php echo $content;?>
</div> <!--END CONTENT-->
        
         <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
