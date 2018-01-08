<?php

namespace merchant\controllers;

use Yii;
use common\models\MerchantAppointmentCancelSetup;
use common\models\MerchantAppointmentCancelSetupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use merchant\components\MerchantController;

/**
 * MerchantAppointmentCancelSetupController implements the CRUD actions for MerchantAppointmentCancelSetup model.
 */
class MerchantAppointmentCancelSetupController extends MerchantController
{
    

    /**
     * Lists all MerchantAppointmentCancelSetup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MerchantAppointmentCancelSetupSearch();
	$searchModel->merchant_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MerchantAppointmentCancelSetup model.
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
     * Creates a new MerchantAppointmentCancelSetup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MerchantAppointmentCancelSetup();
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
     * Updates an existing MerchantAppointmentCancelSetup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	$model->merchant_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		if(Yii::$app->request->isAjax){
			echo json_encode(['success' => true]);
			Yii::$app->end();
                
                }else{
			return $this->redirect(['index']);
		}
        } 
	
	if(Yii::$app->request->isAjax){
		return $this->renderAjax('update', [
                'model' => $model,
            ]);
		
	}else{
	
            return $this->render('update', [
                'model' => $model,
            ]);
	}
        
    }

    /**
     * Deletes an existing MerchantAppointmentCancelSetup model.
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
     * Finds the MerchantAppointmentCancelSetup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MerchantAppointmentCancelSetup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MerchantAppointmentCancelSetup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
