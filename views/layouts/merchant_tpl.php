<?php 
use yii\helpers\Html;
use merchant\assets\MerchantAppAsset;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
//use yii\helpers\Html;
$menu = true;
?>

    <?php 
    MerchantAppAsset::register($this);
    
    
    $this->beginPage() ;
    
    
    ?>



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
    <body class="hold-transition skin-blue sidebar-mini" id="merchant">
        <?php $this->beginBody() ;
        
        ?>
        
        <div class="wrapper">
         <header class="main-header">
                            <a href="<?php echo Yii::$app->urlManager->createUrl('dashboard') ?>" class="logo">
                                <!-- LOGO -->
                                <?= Yii::t('basicfield', 'Merchant Module') ?>
                            </a>
                            <!-- Header Navbar: style can be found in header.less -->
                            <nav class="navbar navbar-static-top" role="navigation">
                                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </a>
                                <!-- Navbar Right Menu -->
                                <div class="navbar-custom-menu">
                                    <ul class="nav navbar-nav">
                                        <!-- Messages: style can be found in dropdown.less-->
<!--                                        <li class="dropdown messages-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="label label-success">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header"><?= Yii::t('basicfield', 'You have {count} messages', ['{count}' => 0]) ?></li>
                                                <li>
                                                     inner menu: contains the actual data 
                                                    <ul class="menu">
                                                        <li> start message 
                                                            <a href="#">
                                                                <div class="pull-left">
                                                                    <?= Html::img(Yii::$app->user->identity->behaviors['imageBehavior']->getImageUrl(), ['class' => 'img-circle']) ?>
                                                                </div>
                                                                <h4>
                                                                    <?= Yii::t('basicfield', 'Sender Name') ?>
                                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                </h4>
                                                                <p>Message Excerpt</p>
                                                            </a>
                                                        </li>
                                                         end message 
                                                        ...
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#"><?= Yii::t('basicfield', 'See All Messages') ?></a></li>
                                            </ul>
                                        </li>-->
                                        <!-- Notifications: style can be found in dropdown.less -->
                                        <li class="dropdown notifications-menu"  id="notif-new-order-total">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bell-o"></i>
                                                <span class="label label-warning notif notif-new-order-total-counter">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header" ><?= Yii::t('basicfield', 'You have {count} notifications',
                                                        ['count' => '<span class="notif notif-new-order-total-counter">'.\merchant\components\DashboardHelper::getAllOrders().'</span>']) ?></li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li>
                                                            <a href="<?php echo Yii::$app->urlManager->createUrl('order') ?>">
                                                                <i class="ion ion-ios-people info"></i>
                                                                <span class="notif" id="notif-new-order-created">
                                                                    <?php echo \merchant\components\DashboardHelper::orderCreatedOnMerchant();?>
                                                                </span> 
                                                                    <?= Yii::t('basicfield', 'New Order Created On Merchant') ?>
                                                            </a>
                                                        </li>

<!--                                                        <li>
                                                            <a href="<?php echo Yii::$app->urlManager->createUrl('order') ?>">
                                                                <i class="ion ion-ios-people info"></i> 
                                                                <span class="notif" id="notif-new-order-changed">
                                                                    <?php echo \merchant\components\DashboardHelper::orderChangedOnMerchant();?>
                                                                </span> 
                                                                    <?= Yii::t('basicfield', 'New Order Changed On Merchant') ?>
                                                            </a>
                                                        </li>-->
                                                        <li>
                                                            <a href="<?php echo Yii::$app->urlManager->createUrl('order') ?>">
                                                                <i class="ion ion-ios-people info"></i> 
                                                                <span class="notif" id="notif-new-order-canceled">
                                                                    <?php echo \merchant\components\DashboardHelper::orderCancelledOnMerchant();?>
                                                                </span> 
                                                                    <?= Yii::t('basicfield', 'New Order Canceled On Merchant') ?>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="<?php echo Yii::$app->urlManager->createUrl('order') ?>">
                                                                <i class="ion ion-ios-people info"></i> 
                                                                <span class="notif" id="notif-new-order-created-frontend">
                                                                    <?php echo \merchant\components\DashboardHelper::orderCreatedOnFrontend();?>
                                                                </span> 
                                                                    <?= Yii::t('basicfield', 'New Order Created On Frontend') ?>
                                                            </a>
                                                        </li>
							
							
							
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#"><?= Yii::t('basicfield', 'View all') ?></a></li>
                                            </ul>
                                        </li>
                                        <!-- Tasks: style can be found in dropdown.less -->
<!--                                        <li class="dropdown tasks-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-flag-o"></i>
                                                <span class="label label-danger">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header">You have 0 tasks</li>
                                                <li>
                                                     inner menu: contains the actual data 
                                                    <ul class="menu">
                                                        <li> Task item 
                                                            <a href="#">
                                                                <h3>
                                                                    Design some buttons
                                                                    <small class="pull-right">20%</small>
                                                                </h3>
                                                                <div class="progress xs">
                                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                                         role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                                         aria-valuemax="100">
                                                                        <span class="sr-only">20% Complete</span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>
                                                         end task item 
                                                        ...
                                                    </ul>
                                                </li>
                                                <li class="footer">
                                                    <a href="#">View all tasks</a>
                                                </li>
                                            </ul>
                                        </li>
                                         User Account: style can be found in dropdown.less -->
                                        <li class="dropdown user user-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <?= Html::img(Yii::$app->user->identity->behaviors['imageBehavior']->getImageUrl(), ['class' => 'user-image']) ?>

                                                <span class="hidden-xs"><?= Yii::$app->user->identity->service_name ?></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- User image -->
                                                <li class="user-header">
                                                    <?= Html::img(Yii::$app->user->identity->behaviors['imageBehavior']->getImageUrl(), ['class' => 'user-image']) ?>

                                                    <p>
                                                        <?= Yii::$app->user->identity->service_name ?> - <?= Yii::t('basicfield', 'Merchant') ?>
                                                        <small><?= Yii::t('basicfield', 'Member since') ?>  <?= Yii::$app->user->identity->date_created ?></small>
                                                    </p>
                                                </li>
                                                <!-- Menu Body -->
<!--                                                <li class="user-body">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('basicfield', 'Messages') ?></a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('basicfield', 'Sales') ?></a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('basicfield', 'Warnings') ?></a>
                                                    </div>
                                                </li>-->

                                                
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <div class="pull-left">
                                                        <a href="<?php echo Yii::$app->urlManager->createUrl('merchant-edit') ?>" class="btn btn-default btn-flat"><?= Yii::t('basicfield', 'Profile') ?></a>
                                                    </div>
                                                    <?php if(Yii::$app->user->identity->is_activate == 0) { ?>
                                                        <div class="pull-left">
                                                            <a class = 'btn btn-default btn-flat' href="<?php echo Yii::$app->urlManager->createUrl('merchant-edit/activate')?>" >
                                                            <?php
                                                            
                                                                echo Yii::t('basicfield', 'Activate') ; 
                                                            
//                                                            else{
//                                                                echo Yii::t('basicfield', 'Deactivate') ;
//                                                            }?>
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="pull-right">
                                                        <a href="<?php echo Yii::$app->urlManager->createUrl('/login/logout') ?>"
                                                           class="btn btn-default btn-flat"><?= Yii::t('basicfield', 'Sign out') ?></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </header>
                        <!--END header_wrap-->


                        <div class="main-sidebar">
                            <!-- Inner sidebar -->
                            <div class="sidebar">
                                <!-- user panel (Optional) -->
                                <div class="user-panel">
                                    <div class="pull-left image">
                                        <?= Html::img(Yii::$app->user->identity->behaviors['imageBehavior']->getImageUrl(), ['class' => 'user-image']) ?>
                                    </div>
                                    <div class="pull-left info">
                                        <p><?= Yii::$app->user->identity->service_name ?></p>

                                        <a href="#"><i class="fa fa-circle text-success"></i> <?= Yii::t('basicfield', 'Online') ?></a>
                                    </div>
                                </div>
                                <!-- /.user-panel -->

                                <?php $menuItems = \merchant\components\MerchantHelper::merchantMenu();
                                
                                echo Menu::widget(
                                    $menuItems
                                );
                                ?>

                            </div>
                            <!-- /.sidebar -->
                        </div>

                        <div class="content-wrapper">
                            <section class="content-header">
                                <div class="breadcrumbs">
                                    <div class="inner">
                                        <?php 
                    
                                                    echo Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]);

                                //                    $this->widget('booster.widgets.TbBreadcrumbs', array(
                                //                        'links' => $this->breadcrumbs,
                                //                    )); ?>
                                    </div>
                                </div>
                                <!--breadcrumbs-->
                            </section>

                            <section class="content">
                                <?php
                                if (($this->context->menu)) {
                                    echo Html::a(Yii::t('basicfield', 'Create'), ['create'], ['class' => 'btn btn-default']);
                                    echo '&nbsp';
                                    echo Html::a(Yii::t('basicfield', 'List'), ['index'], ['class' => 'btn btn-default']);
                                }
                                ?>
<?php echo $content; ?>
                            </section>

                            <!--INNER-->
                        </div>
                        <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2015-<?= date('Y') ?> 
            <?php $siteName  = \common\models\Option::getValByName('website_title');?>
            <a href="http://strafun.com"><?php echo $siteName?></a>.</strong> 
        <?php echo Yii::t('basicfield', 'All rights reserved.')?>
    </footer>
</div>
        
        <?php $this->registerJs("
            var baseUrl = '".Yii::$app->urlManager->createUrl('')."';
                
            var socket = io.connect('https://aondego.com:8080/');
                    socket.on('connect', function () {
                        console.log('Connected!');
                        //var order = {user: 'order', text: 'name'};


                    });
                    socket.on('order-".Yii::$app->user->id."', function (order) {
                        
                        console.log(order);
                        if (order.data_id && order.type != 7){
							console.log('i am f');
                            $('.calendar-' + order.staff_id).fullCalendar('removeEvents', order.data_id);
						}
                        if (order.type != 7) {
							console.log('i am s');
                            $('.calendar-' + order.staff_id).fullCalendar('renderEvent', order, true);
						}
                        $('.notif-new-order-total-counter').html(parseInt($('.notif-new-order-total-counter').html()) + 1);

                        if (($('#group-order-grid').length > 0) && (order.type == 4 || order.type == 3 || order.type == 7)) {
                            $('#group-order-grid').yiiGridView('update');
                        }

                        switch (order.type) {
                            case 1:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 2:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                            case 3:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 4:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 5:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 7:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                        }
                        //$('.calendar-' + order.staff_id).fullCalendar('render');
                    });
                    var AdminLTEOptions = {
                        //Enable sidebar expand on hover effect for sidebar mini
                        //This option is forced to true if both the fixed layout and sidebar mini
                        //are used together
                        sidebarExpandOnHover: true,
                        //BoxRefresh Plugin
                        enableBoxRefresh: true,
                        //Bootstrap.js tooltip
                        enableBSToppltip: true
                    };", yii\web\View::POS_HEAD);
        
        $this->registerJsFile(Yii::$app->urlManager->baseUrl.'/js/merchant.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_END]);
        ?>

        
         <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ;

?>