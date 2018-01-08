<?php

namespace merchant\controllers;

use Yii;
use common\models\Staff;
use common\models\StaffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends \merchant\components\MerchantController
{
    public function actions()
    {
        return array(
            'addOneMany' => \common\extensions\AddOneManyAction::className(),
            'addOneMany2' => \common\extensions\AddOneManyAction::className(),
        );
    }

    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $searchModel->merchant_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();
        $model->merchant_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) ){
            
//            print_r($model->categories);
//            exit;
            $model->editableCategories = $model->category_list;
            $model->editableAddons = $model->addon_list;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        

        if ($model->load(Yii::$app->request->post()) ) {
            
            
            $model->staffShedAttr = $_POST['StaffScheduleHistory'];
            
            $model->editableCategories = $model->category_list;
            $model->editableAddons = $model->addon_list;
            
            
            if($model->save()){
                //echo 'i ma here';exit;
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
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            
            $model->category_list = \yii\helpers\ArrayHelper::map($model->staff_has_category, 'category_id', 'category_id');
            $model->addon_list = \yii\helpers\ArrayHelper::map($model->addon_has_staff, 'addon_id', 'addon_id');
            $model->oneMany = $model->futureStaffSchedules;

            $model->oneMany2 = $model->futureStaffVacations;
            
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function getNewModel()
    {
        return new Staff;
    }
    
    
    public function actionScheduleHistory()
    {
        $searchModelS = new \common\models\StaffScheduleSearch();
        $dataProviderS = $searchModelS->search(Yii::$app->request->queryParams);
        $dataProviderS->pagination->pageSize = 10;
        
        $searchModelV = new \common\models\StaffVacationSearch();
        $dataProviderV = $searchModelV->search(Yii::$app->request->queryParams);
        $dataProviderV->pagination->pageSize = 10;

        return $this->render('history', array(
            'searchModelS' => $searchModelS,
            'dataProviderS' => $dataProviderS,
            
            'searchModelV' => $searchModelV,
            'dataProviderV' => $dataProviderV,
        ));
    }
}
