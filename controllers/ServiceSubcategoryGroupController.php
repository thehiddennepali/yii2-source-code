<?php
namespace merchant\controllers;
use merchant\components\MerchantController;
use Yii;
use common\models\ServiceSubcategory;
use common\models\CategoryHasMerchant;
use common\models\GroupScheduleHistory;

class ServiceSubcategoryGroupController extends MerchantController
{
    public function actions()
    {
        return array(
            'addOneMany'=>  \common\extensions\AddOneManyAction::className(),
        );
    }

    public function actionGetCats(){
        $data=ServiceSubcategory::model()->findAll('category_id=:category_id',
            array(':category_id'=>(int) $_POST['cat_id']));

        $data=CHtml::listData($data,'id','title');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CategoryHasMerchant;

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CategoryHasMerchant'])) {

            $ss = new GroupScheduleHistory();

            $model->attributes = $_POST['CategoryHasMerchant'];
            $model->merchant_id = Yii::$app->user->id;
            $model->editableAddons = $model->addon_list;
            $model->is_group = 1;
            if ($model->save()){
                $ss->attributes = $_POST['GroupScheduleHistory'];
                $ss->group_id = $model->id;
                $ss->save();
                return $this->redirect(array('index'));
            }

        }

       return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if($model->merchant_id!=Yii::$app->user->id)
            return $this->redirect(array('index'));

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CategoryHasMerchant'])) {

            //$om = GroupScheduleHistory::find(['order'=>'id DESC'])->one();
            
            $om = $model->lastSchedule;
            $ss = new GroupScheduleHistory();
            $ss->attributes = $_POST['GroupScheduleHistory'];
            
//            
//            echo '<pre>';
//            print_r($model->groupSchedules);
            

            $change = false;
            if(empty($om))
                $change = true;
            else
                foreach(array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $key){
//                echo '<pre>';
//                print_r($ss->attributes);
//                print_r($om->attributes);
                    if(($ss->attributes[$key]||$om->attributes[$key])&&($ss->attributes[$key] != $om->attributes[$key])){
                        //echo 'i ma here';
                        $change = true; break;
                    }
                }
                
                //exit;

            if($change){
                $ss->id = '';
                $ss->group_id = $model->id;
                $ss->save();
            }

            $model->attributes = $_POST['CategoryHasMerchant'];
            $model->merchant_id = Yii::$app->user->id;
            $model->editableAddons = $model->addon_list;
            $model->is_group = 1;
            if ($model->save()){
                
                if(Yii::$app->request->isAjax){
                    echo json_encode(['success' => true]);
                    Yii::$app->end();
                
                }else{
                    $this->redirect(array('index'));
                }
            }
        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', array(
            'model' => $model,
            ));
            
        }else{

            return $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                return $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $searchModel = new \common\models\CategoryHasMerchantSearch();
        $searchModel->merchant_id = Yii::$app->user->id;
        $searchModel->is_group = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = CategoryHasMerchant::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->addon_list = \yii\helpers\ArrayHelper::map($model->m_c_has_addon,'addon_id','addon_id');
        $model->oneMany = $model->groupSchedules;
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-subcategory-form') {
            echo CActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function getNewModel(){
        return new CategoryHasMerchant;
    }
}
