<?php
namespace merchant\controllers;
use merchant\components\MerchantController;
use Yii;
use common\models\Staff;
use common\models\SingleOrder;
use common\models\CategoryHasMerchant;
use yii\helpers\Html;


class TableBookingController extends MerchantController
{
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function init()
    {
        $this->menu = false;
    }
    
    public function actionClientInfo(){
	    $id = $_POST['id'];
	    
	    if(isset($id)){
		    $model = \common\models\Client::findOne(['client_id' => $id]);
		    echo json_encode(['success' => true, 'response' => $model->attributes]);
		    Yii::$app->end();
		    
	    }
    }


    public function getMore($id)
    {
        $timestamp = Yii::$app->request->getPost('date', null);
        if ($timestamp) {

            $ordersCrit = new CDbCriteria();
            $ordersCrit->addCondition('order_time>=:date_from');
            $ordersCrit->addCondition('order_time<:date_to');
            $ordersCrit->addCondition('staff_id =:staff_id');
            $ordersCrit->params = [':date_from' => date('Y-m-d') . ' 00:00:00', ':date_to' => date('Y-m-d', strtotime('next monday', time())) . ' 00:00:00', ':staff_id' => $id];

            $orders = SingleOrder::model()->findAll($ordersCrit);

            $staffsInfo = [];
            foreach ($orders as $order) {
                $staffInfo[date('Y-m-d', strtotime($order->order_time))][date('H:i', strtotime($order->order_time))] = $order->id;
            }
            $staff = Staff::model()->findByPk($id);

            $staffs_min_range = [];

            $staff_cats = CHtml::listData($staff->staff_has_category, 'category_id', 'category_id');
            $criteria = new CDbCriteria();
            $criteria->condition = 'merchant_id=' . Yii::$app->user->id;
            $criteria->addInCondition('category_id', $staff_cats);
            $criteria->select = 'MIN(service_time_slot),service_time_slot';
            $criteria->group = 'merchant_id';
            $date_min_range = CategoryHasMerchant::model()->find($criteria);
            $staff_min_range = $date_min_range->service_time_slot;

            $timestamp = time();

            return $this->render('_table', array(
                'model' => $staff,
                'timestamp' => $timestamp,
                'staff_min_range' => $staff_min_range,
                'staffInfo' => $staffInfo,
            ));
        }


    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $staffs = Staff::find()->where(['merchant_id' => Yii::$app->user->id, 'is_active' => 1])->all();
        $staffIds = \yii\helpers\ArrayHelper::map($staffs, 'id', 'id');

//        $ordersCrit = new CDbCriteria();
//        $ordersCrit->addCondition('order_time>=:date_from');
//        //$ordersCrit->addCondition('order_time<:date_to');
//        $ordersCrit->params = [':date_from' => date('Y-m-d H:i:') . '00',/*':date_to'=>date('Y-m-d', strtotime('next monday', time())).' 00:00:00'*/];
//        $ordersCrit->addInCondition('staff_id', $staffIds);
        
        
        $orders = SingleOrder::find()
                ->where('order_time>="'.date('Y-m-d H:i:') . '00 "')
                ->andWhere(['in', 'staff_id', $staffIds])
                ->all();

        $staffsInfo = [];
        foreach ($orders as $order) {
            $staffsInfo[$order->staff_id][date('Y-m-d', strtotime($order->order_time))][date('H:i', strtotime($order->order_time))] = $order->id;
        }

        $staffs_min_range = [];
        foreach ($staffs as $staff) {
            $staff_cats = \yii\helpers\ArrayHelper::map($staff->staff_has_category, 'category_id', 'category_id');
            
            $date_min_range = CategoryHasMerchant::find()
                    ->select('MIN(service_time_slot),service_time_slot')
                    ->where(['in', 'id', $staff_cats])->one();

            $staffs_min_range[$staff->id] = $date_min_range ? $date_min_range->service_time_slot : '';
        }

        $timestamp = time();

        
        $freeOrders = SingleOrder::find()
                ->where('merchant_id = ' . Yii::$app->user->id . ' AND staff_id is NULL and is_group=0')
                ->andWhere('order_time>="' . date('Y-m-d H:i:') . '00"')
                ->all();

        return $this->render('admin', array(
            'freeOrders' => $freeOrders,
            'staffs' => $staffs,
            'timestamp' => $timestamp,
            'staffs_min_range' => $staffs_min_range,
            'staffsInfo' => $staffsInfo,
        ));
    }

    public function actionIndexGroup()
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'is_active = 1 AND is_group = 1 and merchant_id=' . Yii::$app->user->id;
        $models = CategoryHasMerchant::model()->findAll($criteria);

        $merchant = Yii::$app->user->model;

        $timestamp = time();

        $tabs = [];
        foreach ($models as $model) {
            $tabs[$model->title . ' ID:' . $model->id] = $this->render('_tableGroup', ['model' => $model,
                'timestamp' => $timestamp,
                'merchant' => $merchant], true);

        }

        return $this->render('adminGroup', array(
            'tabs' => $tabs,
        ));
    }

    public function actionMoregroup()
    {
        $this->layout = false;
        $timestamp = Yii::$app->request->getPost('timestamp');
        $group_id = Yii::$app->request->getPost('group_id');

        $model = CategoryHasMerchant::findOne($group_id);

        header('Content-type: application/json');

        if ($model->merchant_id == Yii::$app->user->id) {
            $data['html'] = $this->render('tr_table_Group', array(
                'timestamp' => $timestamp,
                'model' => $model,
            ), true);
            $data['stamp'] = strtotime("next monday", $timestamp);
            echo CJSON::encode($data);
        } else {
            echo 'error';
        }
        Yii::$app->end();

    }




    public function actionGetPrice()
    {
        if(isset($_POST['cat_id'])) {
            $modelCat = CategoryHasMerchant::findOne($_POST['cat_id']);
            $dd = \yii\helpers\Html::tag('option',\yii\helpers\Html::encode('select'),
                array('value' => ''));
            foreach (Staff::find()
                    ->joinWith('staff_has_category')
                    ->where(['is_active' => 1,
                        'merchant_id' =>  Yii::$app->user->id,
                        'staff_has_category.category_id'=>$_POST['cat_id']])
                    ->all() as $val) {
                $dd .= \yii\helpers\Html::tag('option',$val->name,
                    array('value' => $val->id));
            }


            $res = ['min' => CategoryHasMerchant::findOne($_POST['cat_id'])->getTimeOfService(),
                'dd' => $dd,
                'price' => $modelCat->price,
            ];

            echo json_encode($res);
        }

        Yii::$app->end();
    }


    public function actionGetStaffFreeTime()
    {
        
        if (isset($_POST['staff_id']) && $_POST['staff_id']) {
            $d = date('Y-m-d', strtotime($_POST['date_val']));
            $m = $_POST['min_val'];
            $u = $_POST['update'];
            $staff = Staff::findOne($_POST['staff_id']);
            $dd =  Html::tag('option',Html::encode('select'),
                array('value' => ''));
            
            
            foreach ($staff->getFreeTime($d, $m, $u) as $name) {
                
                $dd.= Html::tag('option',Html::encode($name),
                    array('value' => $name),  true);
            }

            $addOns = $this->renderAjax('_addons_single', ['addons' => $staff->addons], true);
            $res = [
                'dd' => $dd,
                'add_ons' => $addOns

            ];

            echo json_encode($res);

        }
        Yii::$app->end();
    }

    public function actionAddSingleMemcachedOrder()
    {
        
        if($_POST['update']) {
            $cache = Yii::$app->cache->get($_POST['staff_id']);
            
            $uid = $_POST['u_id']?$_POST['u_id']:uniqid();
            if ($cache) {
                if(isset($cache[$_POST['date_val']])){
                    $cache[$_POST['date_val']][$uid] = ['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']];

                }else{
                    $cache[$_POST['date_val']] = [$uid=>['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']]];
                }
            } else {
                $cache = [$_POST['date_val']=>[$uid=>['order_time'=>$_POST['date_val'].' '.$_POST['free_time_list'].':00','orderTimeLength'=>$_POST['min_val']]]];
            }
            Yii::$app->cache->set($_POST['staff_id'],$cache,300);
            echo $uid;
        }
        Yii::$app->end();
    }
}
