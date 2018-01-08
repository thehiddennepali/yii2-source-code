<?php
namespace merchant\components;
use Yii;
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 19-May-16
 * Time: 15:22
 */
class DashboardHelper
{
    /**
     * @return string
     */
    
    public static function orderCreatedOnFrontend(){
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id. ' and source_type=1 and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
    }
    
    public static function orderCancelledOnMerchant(){
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id. ' and source_type=0 and status=2 and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
    }


    public static function orderChangedOnMerchant(){
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id. ' and source_type=0 and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
        
    }
    
    
    public static function orderCreatedOnMerchant(){
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id. ' and source_type=0 and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
        
    }
    
    
    public static function getOrdersToadySingle()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where order_time>="' . date('Y-m-d 00:00:00') . '" AND order_time<="'.date('Y-m-d 23:59:59').'" and merchant_id='.Yii::$app->user->id.' and status !=2 and is_group=0 and is_service_gift=0' ;
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        
        return $query['total'];
    }
    
    public static function getOrdersToadyGroup()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where order_time>="' . date('Y-m-d 00:00:00') . '" AND order_time<="'.date('Y-m-d 23:59:59').'" and merchant_id='.Yii::$app->user->id.' and status !=2 and is_group=1  and is_service_gift=0' ;
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        
        return $query['total'];
    }

    /**
     * @return string
     */
    public static function getAllOrders()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id.' and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
    }
    
    public static function getAllOrdersVoucher()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where  merchant_id='.Yii::$app->user->id.' and is_service_gift=1';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
    }

    /**
     * @return string
     */
    public static function getCountStaff()
    {
        return \common\models\Staff::find()->where(['merchant_id' => Yii::$app->user->id])->count();
    }

    /**
     * @return string
     */
    public static function getOrdersThisMonth()
    {
        $crit = new CDbCriteria();
        $crit->condition = 'merchant_id=' . Yii::app()->user->id;
        $crit->addCondition('create_time>="' . date('Y-m-01 00:00:00') . '"');

        return Order::model()->count($crit);
    }


    /**
     * @return string
     */
    public static function getOrdersLast24H()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where create_time>="' . date('Y-m-d H:i:s',strtotime('-1 day')) . '" and merchant_id='.Yii::$app->user->id.' and status !=2 and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }
    
    public static function getOrdersLast24HVoucher()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where (create_time>="' . date('Y-m-d 00:00:00') . '"  and create_time<="'.date('Y-m-d 23:59:59').'")and merchant_id='.Yii::$app->user->id.' and status !=2 and is_service_gift=1';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }

    /**
     * @return string
     */
    public static function getOrdersThisYear()
    {
        
        $sql = 'SELECT count(*) as total FROM `order` where create_time>="' . date('Y-01-01 00:00:00') . '" and merchant_id='.Yii::$app->user->id.' and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
    }
    
    public static function getOrdersCall(){
        $sql = 'SELECT count(*) as total FROM `order` where source_type=0 and merchant_id='.Yii::$app->user->id.' and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();

        return $query['total'];
        
    }
    
    public static function getOrdersInStore(){
        $sql = 'SELECT count(*) as total FROM `order` where source_type=1 and merchant_id='.Yii::$app->user->id.' and is_service_gift=0';
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        return $query['total'];
        
    }

    /**
     * @return string
     */
    public static function getCountServicesOfMerchant()
    {
        return \common\models\CategoryHasMerchant::find()->where(['merchant_id' => Yii::$app->user->id])->count();
    }

    /**
     * @return string
     */
    public static function getCountCategoriesOfMerchant()
    {
//        $crit = new CDbCriteria();
//        $crit->select = 'category_id';
//        $crit->distinct = true;
//        $crit->condition = 'merchant_id=' . Yii::app()->user->id;
        
        return \common\models\CategoryHasMerchant::find()
                ->select('category_id')
                ->where(['merchant_id' => Yii::$app->user->id])
                ->distinct(true)
                ->count();

       // return count(CategoryHasMerchant::model()->findAll($crit));
    }

    /**
     * @return int
     */
    public static function avgRating()
    {
        $sql = 'SELECT ceil(AVG(rating)) as total FROM `mt_review` where merchant_id='. Yii::$app->user->id;
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        return $query['total'];
        //return 0;
    }

    /**
     * @return int
     */
    public static function getCountReview()
    {
        return \common\models\Review::find()->where(['merchant_id' => Yii::$app->user->id])->count();
    }
    
    public static function getCountReviewLast(){
        $lastMonth = date('Y-m-01', strtotime('-1 months', strtotime(date('Y-m-d'))));
        
        $lastDay  = date("Y-m-t", strtotime($lastMonth));
        
        
        $sql = "SELECT COUNT(*) as total, DATE(date_created) as date_created FROM `mt_review` where (date_created between $lastMonth and $lastDay) and merchant_id=".Yii::$app->user->id;
        $query = Yii::$app->db->createCommand($sql)->queryOne();
        
        return $query['total'];
    }


    /**
     * @return string[]
     */
    public static function getDataForGraph($sales)
    {
        $merchnat = \common\models\Merchant::findOne(['merchant_id' => Yii::$app->user->id]);
        $dateCreated = $merchnat->date_created;
        
        if($sales == 0){
            $fromMonth = date('Y-m-01');
            $ToMonth = date('Y-m-t');
            
        }else if($sales == 1){
            $fromMonth = date('Y-m-d 00:00:00', strtotime('-3 month')); // third previous month
            $ToMonth = date('Y-m-t');
        }else if($sales == 2){
            $fromMonth = date('Y-m-d 00:00:00', strtotime('-12 month')); // 12 previous month
            $ToMonth = date('Y-m-t');
        }else if($sales == 3){
            $fromMonth = $dateCreated;
            $ToMonth = date('Y-m-t');
        }
        
        
        
        
        
        
//        $crit = new CDbCriteria();
//        $crit->select = 'COUNT(id) as count_by_date, DATE(order_time) as date_of_order, DATE(create_time) as create_time';
//        $crit->group = 'YEAR(create_time), MONTH(create_time)';
//        //$crit->group = 'date_of_order';
//        $crit->order = 'order_time';
//        $crit->condition = 'merchant_id=' . Yii::app()->user->id. ' and ( create_time between "'.$fromMonth.'" and "'.$ToMonth.'")';
//        
        
       
        $models = \common\models\Order::find()
                ->select('COUNT(id) as count_by_date, DATE(order_time) as date_of_order, DATE(create_time) as create_time')
                ->where('merchant_id=' . Yii::$app->user->id. ' and ( create_time between "'.$fromMonth.'" and "'.$ToMonth.'") and is_service_gift=0')
                ->groupBy('YEAR(create_time), MONTH(create_time)')
                ->orderBy('order_time')
                ->all();
        $res = [];
        if(count($models) != 0){
            $i=0;foreach($models as $key => $val){
                
                $firstDay = date('Y-m-01', strtotime($val->create_time));
                
                $lastDay = date('Y-m-t', strtotime($val->create_time));
                
                $sql = 'SELECT count(id) as total,  DATE(create_time) as create_time from `order` where merchant_id='.Yii::$app->user->id. ' and   ( create_time between "'.$firstDay.'" and "'.$lastDay.'") and source_type=0 and is_service_gift=0';
                $query = Yii::$app->db->createCommand($sql)->queryOne();
                
                $sql2 = 'SELECT count(id) as total,  DATE(create_time) as create_time from `order` where merchant_id='.Yii::$app->user->id. ' and ( create_time between "'.$firstDay.'" and "'.$lastDay.'") and source_type=1 and is_service_gift=0';
                $query2 = Yii::$app->db->createCommand($sql2)->queryOne();
                
                $res[$i] = ['m' => date('Y-m', strtotime($val->create_time)),
                    'item1'=>$query['total'],
                    'item2'=>0,
                    'item3'=>$query2['total']];
                
            $i++;
            
            }
        }else{
            
            $res[] = ['m' => date('Y-m', strtotime($ToMonth)),'item1'=>0, 'item2'=>0, 'item3'=>0];
        }
        
        return json_encode($res);

    }


    /**
     * @return Order[]
     */
    public static function getLatestOrders()
    {
//        $crit = new CDbCriteria();
//        $crit->order = 'id DESC';
//        $crit->limit = '7';
//        $crit->condition = 'merchant_id=' . Yii::app()->user->id;
        
        $orders = \common\models\Order::find()
                ->where(['merchant_id' => Yii::$app->user->id, 'is_service_gift'=> 0])
                ->orderBy('id desc')
                ->limit(7)
                ->all();
        
        return $orders;
    }

    /**
     * @return CategoryHasMerchant[]
     */
    public static function getLastServices()
    {
        
        
        $categoryHasmerchant = \common\models\CategoryHasMerchant::find()
                ->where(['merchant_id' => Yii::$app->user->id])
                ->orderBy('id DESC')
                ->limit(4)
                ->all();

        return $categoryHasmerchant;
    }
} 