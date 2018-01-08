<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <!-- <link href="<?php /* echo Yii::app()->request->baseUrl; */ ?>/css/admin.css" rel="stylesheet"/>-->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
                <link href='<?php echo Yii::app()->request->baseUrl; ?>/css/fullcalendar.min.css' rel='stylesheet'/>
                <link href='<?php echo Yii::app()->request->baseUrl; ?>/dist/css/AdminLTE.min.css' rel='stylesheet'/>
                <link href='<?php echo Yii::app()->request->baseUrl; ?>/dist/css/skins/skin-blue.css' rel='stylesheet'/>
                <link href='<?php echo Yii::app()->request->baseUrl; ?>/css/fullcalendar.print.css' rel='stylesheet' media='print'/>
                <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/moment.min.js'></script>
                <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar.min.js'></script>
                <script src="http://cdn.socket.io/socket.io-1.4.5.js"></script>


                <script src='<?php echo Yii::app()->request->baseUrl; ?>/js/fullcalendar.min.js'></script>
                <script type="text/javascript">
                    var socket = io.connect('http://139.59.128.5:3000/');
                    socket.on("connect", function () {
                        console.log("Connected!");
                        var order = {user: "order", text: "name"};


                    });
                    socket.on("order-<?= Yii::app()->user->id ?>", function (order) {
                        console.log(order);
                        if (order.data_id)
                            $('.calendar-' + order.staff_id).fullCalendar('removeEvents', order.data_id);
                        if (order.type != 5)
                            $('.calendar-' + order.staff_id).fullCalendar('renderEvent', order, true);
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
                    };
                </script>
                <script src="<?php echo Yii::app()->request->baseUrl; ?>/dist/js/app.js" type="text/javascript"></script>

                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->

                <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico"/>

                </head>
                <body class="hold-transition skin-blue sidebar-mini" id="merchant">
                    <div class="wrapper">
                        <header class="main-header">
                            <a href="<?php echo Yii::app()->createUrl('dashboard') ?>" class="logo">
                                <!-- LOGO -->
                                <?= Yii::t('default', 'Merchant Module') ?>
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
                                        <li class="dropdown messages-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="label label-success">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header"><?= Yii::t('default', 'You have {count} messages', ['{count}' => 0]) ?></li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li><!-- start message -->
                                                            <a href="#">
                                                                <div class="pull-left">
                                                                    <?= CHtml::image(Yii::app()->user->model->imageBehavior->getImageUrl(), 'Merchant Image', ['class' => 'img-circle']) ?>
                                                                </div>
                                                                <h4>
                                                                    <?= Yii::t('default', 'Sender Name') ?>
                                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                                </h4>
                                                                <p>Message Excerpt</p>
                                                            </a>
                                                        </li>
                                                        <!-- end message -->
                                                        ...
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#"><?= Yii::t('default', 'See All Messages') ?></a></li>
                                            </ul>
                                        </li>
                                        <!-- Notifications: style can be found in dropdown.less -->
                                        <li class="dropdown notifications-menu"  id="notif-new-order-total">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-bell-o"></i>
                                                <span class="label label-warning notif notif-new-order-total-counter">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header" ><?= Yii::t('default', 'You have {count} notifications', ['{count}' => '<span class="notif notif-new-order-total-counter">0</span>']) ?></li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li>
                                                            <a href="<?php echo Yii::app()->createUrl('orders') ?>">
                                                                <i class="ion ion-ios-people info"></i> <span class="notif" id="notif-new-order-created">0</span> <?= Yii::t('default', 'New Order Created On Merchant') ?>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="<?php echo Yii::app()->createUrl('orders') ?>">
                                                                <i class="ion ion-ios-people info"></i> <span class="notif" id="notif-new-order-changed">0</span> <?= Yii::t('default', 'New Order Changed On Merchant') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo Yii::app()->createUrl('orders') ?>">
                                                                <i class="ion ion-ios-people info"></i> <span class="notif" id="notif-new-order-canceled">0</span> <?= Yii::t('default', 'New Order Canceled On Merchant') ?>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="<?php echo Yii::app()->createUrl('orders') ?>">
                                                                <i class="ion ion-ios-people info"></i> <span class="notif" id="notif-new-order-created-frontend">0</span> <?= Yii::t('default', 'New Order Created On Frontend') ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="footer"><a href="#"><?= Yii::t('default', 'View all') ?></a></li>
                                            </ul>
                                        </li>
                                        <!-- Tasks: style can be found in dropdown.less -->
                                        <li class="dropdown tasks-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-flag-o"></i>
                                                <span class="label label-danger">0</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li class="header">You have 0 tasks</li>
                                                <li>
                                                    <!-- inner menu: contains the actual data -->
                                                    <ul class="menu">
                                                        <li><!-- Task item -->
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
                                                        <!-- end task item -->
                                                        ...
                                                    </ul>
                                                </li>
                                                <li class="footer">
                                                    <a href="#">View all tasks</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- User Account: style can be found in dropdown.less -->
                                        <li class="dropdown user user-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <?= CHtml::image(Yii::app()->user->model->imageBehavior->getImageUrl(), 'Merchant Image', ['class' => 'user-image']) ?>

                                                <span class="hidden-xs"><?= Yii::app()->user->model->service_name ?></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <!-- User image -->
                                                <li class="user-header">
                                                    <?= CHtml::image(Yii::app()->user->model->imageBehavior->getImageUrl(), 'Merchant Image', ['class' => 'user-image']) ?>

                                                    <p>
                                                        <?= Yii::app()->user->model->service_name ?> - <?= Yii::t('default', 'Merchant') ?>
                                                        <small><?= Yii::t('default', 'Member since') ?>  <?= Yii::app()->user->model->date_created ?></small>
                                                    </p>
                                                </li>
                                                <!-- Menu Body -->
                                                <li class="user-body">
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('default', 'Messages') ?></a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('default', 'Sales') ?></a>
                                                    </div>
                                                    <div class="col-xs-4 text-center">
                                                        <a href="#"><?= Yii::t('default', 'Warnings') ?></a>
                                                    </div>
                                                </li>

                                                
                                                <!-- Menu Footer-->
                                                <li class="user-footer">
                                                    <div class="pull-left">
                                                        <a href="<?php echo Yii::app()->createUrl('merchantEdit') ?>" class="btn btn-default btn-flat"><?= Yii::t('default', 'Profile') ?></a>
                                                    </div>
                                                    <?php if (!Yii::app()->user->model->is_purchase) { ?>
                                                        <div class="pull-left">
                                                            <a class = 'push-for-check btn btn-default btn-flat' href="#" ><?= Yii::t('default', 'Purchase') ?></a>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="pull-right">
                                                        <a href="<?php echo Yii::app()->createUrl('/login/logout') ?>"
                                                           class="btn btn-default btn-flat"><?= Yii::t('default', 'Sign out') ?></a>
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
                                        <?= CHtml::image(Yii::app()->user->model->imageBehavior->getImageUrl(), 'Merchant Image', ['class' => 'user-image']) ?>
                                    </div>
                                    <div class="pull-left info">
                                        <p><?= Yii::app()->user->model->service_name ?></p>

                                        <a href="#"><i class="fa fa-circle text-success"></i> <?= Yii::t('default', 'Online') ?></a>
                                    </div>
                                </div>
                                <!-- /.user-panel -->

                                <?php $menuItems = MerchantHelper::merchantMenu();
                                $this->widget('zii.widgets.CMenu', $menuItems);
                                ?>

                            </div>
                            <!-- /.sidebar -->
                        </div>

                        <div class="content-wrapper">
                            <section class="content-header">
                                <div class="breadcrumbs">
                                    <div class="inner">
                                        <?php
                                        $this->widget('booster.widgets.TbBreadcrumbs', array(
                                            'links' => $this->breadcrumbs,
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <!--breadcrumbs-->
                            </section>

                            <section class="content">
                                <?php
                                if ($this->menu) {
                                    echo CHtml::link(Yii::t('default', 'Create'), ['create'], ['class' => 'btn btn-default']);
                                    echo '&nbsp';
                                    echo CHtml::link(Yii::t('default', 'List'), ['index'], ['class' => 'btn btn-default']);
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
                            <strong>Copyright &copy; 2015-<?= date('Y') ?> <a href="http://strafun.com">Strafun</a>.</strong> All rights
                            reserved.
                        </footer>

                        <!--END main_wrapper-->

<?php echo CHtml::hiddenField("currentController", "merchant") ?>

<?php //$this->renderPartial('/layouts/_modal');
?>
                    </div>
                    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/merchant.js"></script>
                </body>

                </html>