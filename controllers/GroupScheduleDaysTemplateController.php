<?php

namespace merchant\controllers;

use Yii;
use common\models\GroupScheduleDaysTemplate;
use common\models\GroupScheduleDaysTemplateeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * GroupScheduleDaysTemplateController implements the CRUD actions for GroupScheduleDaysTemplate model.
 */
class GroupScheduleDaysTemplateController extends \merchant\components\MerchantController
{
    
    public function actions()
    {
        return array(
            'addOneMany'=>  \common\extensions\AddOneManyAction::className(),
        );
    }
   

    /**
     * Lists all GroupScheduleDaysTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupScheduleDaysTemplateeSearch();
        
        $searchModel->merchant_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GroupScheduleDaysTemplate model.
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
     * Creates a new GroupScheduleDaysTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupScheduleDaysTemplate();
        $model->merchant_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GroupScheduleDaysTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
                
               
                
                Yii::$app->session->setFlash('success', 'Updated Successfully.');
                 if ($model->save()){
                    if(Yii::$app->request->isAjax){
                        echo json_encode(['success' => true]);
                        Yii::$app->end();

                    }else{
                        return $this->redirect(['update', 'id' => $model->id]);
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
     * Deletes an existing GroupScheduleDaysTemplate model.
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
     * Finds the GroupScheduleDaysTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupScheduleDaysTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupScheduleDaysTemplate::findOne($id)) !== null) {
            $model->oneMany = $model->groupTimeRanges;
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function getNewModel(){
        return new GroupScheduleDaysTemplate;
    }
}
