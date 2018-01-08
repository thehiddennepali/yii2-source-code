<?php
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:32
 */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = ['label' => Yii::t('basicfield','Dashboard')];
?>
<h1><?=Yii::t('basicfield','Dashboard')?></h1>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=  \merchant\components\DashboardHelper::getOrdersToadySingle()?></h3>
                <p><?=Yii::t('basicfield','Single Appointments for today')?></p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo Yii::$app->urlManager->createUrl('table-booking')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=  \merchant\components\DashboardHelper::getOrdersToadyGroup()?></h3>
                <p><?=Yii::t('basicfield','Group Appointments for today')?></p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo Yii::$app->urlManager->createUrl('table-booking')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=  \merchant\components\DashboardHelper::getOrdersLast24H()?></h3>
                <p><?=Yii::t('basicfield','Appointment made in the last 24 hours')?></p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo Yii::$app->urlManager->createUrl('order')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=  \merchant\components\DashboardHelper::getAllOrders()?></h3>
                <p><?=Yii::t('basicfield','Appointments made since you joined')?></p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo Yii::$app->urlManager->createUrl('order')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-red">
			<div class="inner">
				<h3><?=  \merchant\components\DashboardHelper::getCountStaff()?></h3>
				<p><?=Yii::t('basicfield','Staff Members')?></p>
			</div>
			<div class="icon">
				<i class="ion ion-pie-graph"></i>
			</div>
			<a href="<?php echo Yii::$app->urlManager->createUrl('staff')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div><!-- ./col -->
	
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-red">
			<div class="inner">
				<h3><?=  \merchant\components\DashboardHelper::getAllOrdersVoucher()?></h3>
				<p><?=Yii::t('basicfield','Number of sold vouchers')?></p>
			</div>
			<div class="icon">
				<i class="ion ion-pie-graph"></i>
			</div>
			<a href="<?php echo Yii::$app->urlManager->createUrl('gift-voucher/sales')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div><!-- ./col -->
	
	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-green">
		    <div class="inner">
			<h3><?=  \merchant\components\DashboardHelper::getOrdersLast24HVoucher()?></h3>
			<p><?=Yii::t('basicfield','Number of sold vouchers in the last 24 hours')?></p>
		    </div>
		    <div class="icon">
			<i class="ion ion-stats-bars"></i>
		    </div>
		    <a href="<?php echo Yii::$app->urlManager->createUrl('gift-voucher/sales')?>" class="small-box-footer"><?=Yii::t('basicfield','More info')?> <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div><!-- ./col -->
	
	
</div><!-- /.row -->
<div class="row">
    <div class="col-md-4">
        <!-- Info Boxes Style 2 -->
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
            <div class="info-box-content">

                <span class="info-box-number"><?=  \merchant\components\DashboardHelper::getCountServicesOfMerchant()?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 50%"></div>
                </div>
                  <span class="progress-description">
                      <?php //echo \merchant\components\DashboardHelper::getCountCategoriesOfMerchant();?>
                      
                   <?=Yii::t('basicfield','Services in {count} categories',['count'=>  \merchant\components\DashboardHelper::getCountCategoriesOfMerchant()])?>
                  </span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Likes on Facebook</span>
                <span class="info-box-number">0</span>
                <div class="progress">
                    <div class="progress-bar" style="width: 20%"></div>
                </div>
                  <span class="progress-description">
                    0 <?=Yii::t('basicfield','for last month')?>
                  </span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?=Yii::t('basicfield','Rating')?></span>
                <span class="info-box-number"><?=  \merchant\components\DashboardHelper::avgRating()?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                  <span class="progress-description">
                 <?=Yii::t('basicfield','Out of')?> 5
                  </span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><?=Yii::t('basicfield','Reviews')?></span>
                <span class="info-box-number"><?=  \merchant\components\DashboardHelper::getCountReview()?></span>
                <div class="progress">
                    <div class="progress-bar" style="width: 40%"></div>
                </div>
                  <span class="progress-description">
                    <?= \merchant\components\DashboardHelper::getCountReviewLast() ?> <?=Yii::t('basicfield','for last month')?>
                  </span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    <div class="col-md-8">
        <!-- solid sales graph -->
        <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
                <i class="fa fa-th"></i>
                <h3 class="box-title"><?=Yii::t('basicfield','Sales Graph')?></h3>
                
                <?php 
                
                echo Html::dropDownList('sales', $sales,array(
                    '0' => 'Current Month',
                    '1' => 'Last 3 Month', 
                    '2' => 'Last 12 Months',
                    '3' => 'Since he joined'
                ), array('id' => 'sales'))?>
                <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body border-radius-none">
                <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div><!-- /.box-body -->
            <div class="box-footer no-border">
                <div class="row">
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                        <input type="text" class="knob" data-readonly="true" value="<?=  \merchant\components\DashboardHelper::getOrdersCall()?>" data-width="60" data-height="60" data-fgColor="#39CCCC">
                        <div class="knob-label"><?=Yii::t('basicfield','Call/Direct')?></div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                        <input type="text" class="knob" data-readonly="true" value="0" data-width="60" data-height="60" data-fgColor="#39CCCC">
                        <div class="knob-label"><?=Yii::t('basicfield','Online')?></div>
                    </div><!-- ./col -->
                    <div class="col-xs-4 text-center">
                        
                        <?php //  \merchant\components\DashboardHelper::getOrdersInStore();exit;?>
                        <input type="text" class="knob" data-readonly="true" value="<?=  \merchant\components\DashboardHelper::getOrdersInStore()?>" data-width="60" data-height="60" data-fgColor="#39CCCC">
                        <div class="knob-label"><?=Yii::t('basicfield','In-Store')?></div>
                    </div><!-- ./col -->
                </div><!-- /.row -->
            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div>

</div>
<div class="row">
    <div class="col-md-8">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('basicfield','Latest Orders')?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            
            <?php $order = new common\models\Order;
            
            ?>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th><?=  $order->getAttributeLabel('client_id')?></th>
                            <th><?=$order->getAttributeLabel('category_id')?></th>
                            <th><?=$order->getAttributeLabel('status')?></th>
                            <th><?=$order->getAttributeLabel('staff_id')?></th>
                            <th><?=$order->getAttributeLabel('order_time')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach(\merchant\components\DashboardHelper::getLatestOrders() as $val){ 
                                
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Yii::$app->urlManager->createUrl(['/order/update','id'=>$val->id])?>">
                                                <?=$val->id?>
                                        </a>
                                    </td>
                                    
                                    <td><?=$val->client_name?></td>
                                        
                                    
                                    <td>
                                                <?php ?>
                                                <?=$val->category ? $val->category->title:''?></td>
                                    <td>
                                        <span class="label label-success">
                                                <?=  common\models\Order::getOrderStatuses()[$val->status]?>
                                        </span>
                                    </td>
                                    <td><?=$val->staff_id?$val->staff->name:''?></td>
                                    <td><?php 
				    $dateFormat = \common\components\Helper::showDateFormat();
					$timeFormat = \common\components\Helper::showTimeFormat();
				    echo date("$dateFormat $timeFormat", strtotime($val->order_time));?></td>
                                </tr>
                            <?php }
                        ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="<?php echo Yii::$app->urlManager->createUrl('table-booking')?>" class="btn btn-sm btn-info btn-flat pull-left"><?=Yii::t('basicfield','Place New Order')?></a>
                <a href="<?php echo Yii::$app->urlManager->createUrl('/order')?>" class="btn btn-sm btn-default btn-flat pull-right"><?=Yii::t('basicfield','View All Orders')?></a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div>
    <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=Yii::t('basicfield','Recently Added Services')?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <ul class="products-list product-list-in-box">
                    <?php foreach(\merchant\components\DashboardHelper::getLastServices() as $val){ ?>
                        <li class="item">
                            <div class="product-img">
                                <img src="<?=$val->behaviors['imageBehavior']->getImageUrl()?>" alt="Service Image">
                            </div>
                            <div class="product-info">
                                <a href="<?php echo Yii::$app->urlManager->createUrl('service-subcategory')?>" class="product-title"><?=$val->title?> <span class="label label-warning pull-right"><?=$val->price?></span></a>
                            </div>
                        </li><!-- /.item -->
                   <?php } ?>
                </ul>
            </div><!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="<?php echo Yii::$app->urlManager->createUrl('service-subcategory')?>" class="uppercase"><?=Yii::t('basicfield','View All Services')?></a>
            </div><!-- /.box-footer -->
        </div><!-- /.box -->
    </div>
</div>

<?php 
//echo '<pre>';
//print_r(\merchant\components\DashboardHelper::getDataForGraph($sales));?>
<?php $this->registerCssFile(Yii::$app->urlManager->baseUrl.'/plugins/morris/morris.css')?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl.'/plugins/knob/jquery.knob.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl.'/plugins/datepicker/bootstrap-datepicker.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<?php $this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js') ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl.'/plugins/morris/morris.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<?php $this->registerJsFile(Yii::$app->urlManager->baseUrl.'/dist/js/pages/dashboard.js', ['depends' => [\yii\web\JqueryAsset::className()]]) ?>
<?php $this->registerJs("
    $(function(){
        /* Morris.js Charts */
        // Sales chart
        var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data:".  \merchant\components\DashboardHelper::getDataForGraph($sales).",
            xkey: 'm',
            ykeys: ['item1', 'item2', 'item3'],
            labels: ['Call/Direct', 'Online', 'In-Store'],
            lineColors: ['#efefef'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: '#fff',
            gridStrokeWidth: 0.4,
            pointSize: 4,
            pointStrokeColors: ['#efefef'],
            gridLineColor: '#efefef',
            gridTextFamily: 'Open Sans',
            gridTextSize: 10,
            lineColors : ['red', 'green', 'blue'],
        });
        
        $('#sales').on('change', function(){
            var value = $(this).val();
            window.location.href = '".Yii::$app->urlManager->createUrl('dashboard/index')."?sales='+value;
            
            console.log('i am here');
        })
    })"
        );?>
