<?php

namespace merchant\controllers;

use Yii;
use common\models\MessagebirdDetails;
use common\models\MessagebirdDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use merchant\components\MerchantController;
use common\models\Merchant;

/**
 * MessagebirdController implements the CRUD actions for MessagebirdDetails model.
 */
class MessagebirdDetailsController extends MerchantController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function init(){
        $this->menu = false;
    }
    /**
     * Lists all MessagebirdDetails models.
     * @return mixed
     */
//    public function actionIndex()
//    {
//        $searchModel = new MessagebirdDetailsSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single MessagebirdDetails model.
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
     * Creates a new MessagebirdDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionIndex()
    {
//        echo '<pre>';
//         print_r(Yii::$app->user->identity->merchant_id);
        $id= Yii::$app->user->identity->merchant_id;
        if(empty($id)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model= MessagebirdDetails::find()->where(['merchant_id'=>$id])->one();
        if(count($model)==0)
        $model = new MessagebirdDetails();
	
	$merchant = Merchant::find()->where(['merchant_id'=>Yii::$app->user->id])->one();
        
        if ($model->load(Yii::$app->request->post())){
		
		$enable= $_POST['Merchant']['enable_sms'];
		$type= $_POST['Merchant']['sms_type'];
		
		
		$merchant->enable_sms = $enable;
		$merchant->sms_type = 'MessageBird';
		
		$merchant->save();

		$model->created_at= date('Y-m-d H:i:s');
		$model->updated_at= date('Y-m-d H:i:s');
		if($model->save())
			return  $this->redirect(array('index'));
           // return $this->redirect(['view', 'id' => $model->id]);

        }
        else {
            return $this->render('update', [
                'model' => $model,
		'merchant' => $merchant
            ]);
        }
    }

    /**
     * Updates an existing MessagebirdDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MessagebirdDetails model.
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
     * Finds the MessagebirdDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MessagebirdDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MessagebirdDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
