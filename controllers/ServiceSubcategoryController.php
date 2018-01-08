<?php

namespace merchant\controllers;

use Yii;
use common\models\CategoryHasMerchant;
use common\models\CategoryHasMerchantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ServiceSubcategoryController implements the CRUD actions for CategoryHasMerchant model.
 */
class ServiceSubcategoryController extends \merchant\components\MerchantController
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
    
    
    public function actionGetCats(){
        $data = \common\models\ServiceSubcategory::find()
                ->where(['category_id'=> $_REQUEST['cat_id']])
                ->all();

        $data = \yii\helpers\ArrayHelper::map($data,'id','title');
        foreach($data as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),['value' => $value]);
        }
    }

    /**
     * Lists all CategoryHasMerchant models.
     * @return mixed
     */
    public function actionIndex()
    {
//        echo '<pre>';
//        print_r(Yii::$app->user->identity->merchant_id);
//        //echo Yii::app()->user->id;
//        exit;
        $searchModel = new CategoryHasMerchantSearch();
        $searchModel->merchant_id = Yii::$app->user->id;
        $searchModel->is_group = 0;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoryHasMerchant model.
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
     * Creates a new CategoryHasMerchant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryHasMerchant();
        $model->merchant_id = Yii::$app->user->id;
        
        if ($model->load(Yii::$app->request->post()) ) {
            $model->editableAddons = $model->addon_list;
            $model->is_group = 0;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CategoryHasMerchant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->editableAddons = $model->addon_list;
            
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
     * Deletes an existing CategoryHasMerchant model.
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
     * Finds the CategoryHasMerchant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryHasMerchant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryHasMerchant::findOne($id)) !== null) {
            $model->addon_list = \yii\helpers\ArrayHelper::map($model->m_c_has_addon, 'addon_id', 'addon_id');
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
