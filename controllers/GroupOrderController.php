<?php
namespace merchant\controllers;
use merchant\components\MerchantController;
use common\models\GroupOrder;
use common\models\CategoryHasMerchant;
use Yii;

class GroupOrderController extends MerchantController
{
    public function actionRemove($id)
    {
        if (Yii::$app->request->isAjax) {
            $model =  $this->loadModel($id);
            $model->remove();
			
			$left = \common\models\GroupOrder::countByDate($model->order_time, $model->category_id);
                                
			if(empty($left)){
				$left = 0;
			}

			$left = $model->category->group_people - $left;
            $response = [
                'id' => 'g-' . strtotime($model->order_time). $model->category_id,
                'title' => $model->category->title . ' (' . date('H:i',strtotime($model->order_time)) . ') left:' . ($model->category->group_people - GroupOrder::countByDate($model->order_time, $model->category_id)),
                'start' => date('Y-m-d\TH:i:s', strtotime($model->order_time)),
                'end' => date('Y-m-d\TH:i:s', strtotime("+{$model->category->time_in_minutes} minutes", strtotime($model->order_time))),
                'url' => Yii::$app->urlManager->createUrl(['group-order/get-group-orders', 'id'=>$model->category_id , 'date_id' =>strtotime($model->order_time)]),
                'backgroundColor' => $model->category->color,
                'staff_id' => $model->staff_id,
                'merchant_id' => Yii::$app->user->id,
				'description' => $left.' seats left'

            ];
            echo json_encode($response);
            //echo CategoryHasMerchant::model()->findByPk($model->category_id)->group_people - GroupOrder::countByDate($model->order_time,$model->category_id);
            Yii::$app->end();
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return GroupOrder
     */
    public function loadModel($id)
    {
        $model = GroupOrder::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionGetGroupOrders($id, $date_id)
    {
        $time = date('Y-m-d H:i:s', $date_id);
		

        $modelCat = CategoryHasMerchant::findOne($id);
//        echo $id;
//        print_r($modelCat->attributes);
//        exit;

        if ($modelCat->merchant_id == Yii::$app->user->id) {
//            $model = new GroupOrder('search');
//            $model->unsetAttributes();
//            $model->category_id = $id;
//            $model->order_time = $time;
            
            
            $searchModel = new \common\models\OrderSearch();
            $searchModel->merchant_id = Yii::$app->user->id;
            //$searchModel->status != 2;
            $searchModel->is_group = 1;
            $searchModel->category_id = $id;
            $searchModel->order_time = $time;
			
			
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			
			
            
            
            if (isset($_GET['ajax'])) {
                if (isset($_GET['GroupOrder']))
                    $model->attributes = $_GET['GroupOrder'];
                return $this->renderAjax('_search', ['model' => $model]);
            } else {
                $html = $this->renderAjax('_search', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
                    ]);

                $addOns = $this->renderAjax('_addons', ['addons' => $modelCat->addons], true);

                $cache_id = uniqid();
                if($c = Yii::$app->cache->get('g'.$id.$date_id)){
                   $c[$cache_id] = 1;
                }else
                {
                    $c = [$cache_id=>1];
                }

                Yii::$app->cache->set('g'.$id.$date_id,$c,300);

                echo json_encode(['html' => $html,
                    'cat_id' => $id,
                    'order_time' => $time,
                    'cache_id' => $cache_id,
                    'timest' => strtotime($time),
                    'price' => $modelCat->price,
                    'add_ons' => $addOns]);
            }

            Yii::$app->end();
        }
    }
}
