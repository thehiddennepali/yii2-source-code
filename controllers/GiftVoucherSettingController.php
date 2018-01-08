<?php

namespace merchant\controllers;

use Yii;
use common\models\GiftVoucherSetting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GiftVoucherSettingController implements the CRUD actions for GiftVoucherSetting model.
 */
class GiftVoucherSettingController extends \merchant\components\MerchantController
{
	
	public function init(){
		$this->menu = false;
	}
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

    /**
     * Lists all GiftVoucherSetting models.
     * @return mixed
     */
	public function actionIndex()
	{
		$model = GiftVoucherSetting::findOne(['merchant_id' => Yii::$app->user->id]);
		
		if(count($model) == 0)
		$model = new GiftVoucherSetting();

		if ($model->load(Yii::$app->request->post()) ) {

			$model->merchant_id = Yii::$app->user->id;
			if(in_array(1, $model->delivery_options)){
				
				
				
				if($model->is_delivery_free == 1){
				
					if(empty($model->delivery_fee)){
					

						$model->addError('delivery_fee', 'Delivery Fee cannot be blank');
						
						return $this->render('create', [
							'model' => $model,
						    ]);

					}
				}
				
				
			}else{
				$model->delivery_fee = 0;
			}
			
			if($model->validate()){
				
				$model->delivery_options = json_encode($model->delivery_options);
				$model->payment = json_encode($model->payment);
				$model->created_at = new \yii\db\Expression('NOW()');
				$model->save(false);
				return $this->redirect(['index']);
				
			}
			
			
			//return $this->redirect(['view', 'id' => $model->id]);
		} 
		
		return $this->render('create', [
		    'model' => $model,
		]);
		
	}

    /**
     * Displays a single GiftVoucherSetting model.
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
     * Creates a new GiftVoucherSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GiftVoucherSetting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GiftVoucherSetting model.
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
     * Deletes an existing GiftVoucherSetting model.
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
     * Finds the GiftVoucherSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiftVoucherSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiftVoucherSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
