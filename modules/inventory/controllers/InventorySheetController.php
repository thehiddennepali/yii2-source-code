<?php

namespace inventory\controllers;

use inventory\models\InventoryLocationManualCount;
use inventory\models\ItemLocation;
use item\models\Item;
use Yii;
use inventory\models\InventorySheet;
use inventory\models\search\InventorySheetSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use extended\controller\Controller;
use item\models\search\ItemSearch;
use yii\widgets\ActiveForm;
use yii\db\ActiveQuery;


/**
 * InventorySheetController implements the CRUD actions for InventorySheet model.
 */
class InventorySheetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        //'roles' => [User::ROLE_USER],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('createInventorySheet');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateInventorySheet', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteInventorySheet', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewInventorySheet', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index', 'par'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexInventorySheet');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionPar($item_id, $location_id)
    {
        $model = ItemLocation::findOne(['item_id'=>$item_id,'location_id'=>$location_id]);
        if(!$model)
            $model = new ItemLocation(['item_id'=>$item_id,'location_id'=>$location_id]);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Yii::$app->request->referrer);
        }
        else
            throw new Exception("Something is wrong.");
    }

    /**
     * Lists all InventorySheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySheetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventorySheet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $inventory_location_manual_counts = $model->inventoryLocationManualCounts;
        return $this->render('view', [
            'model' => $model,
            'inventory_location_manual_counts' => $inventory_location_manual_counts,
        ]);
    }

    /**
     * Creates a new InventorySheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //inventory_sheet
        $model = new InventorySheet;
        $model->load(Yii::$app->request->post());

        //items
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        $dataProvider->query->with(['itemLocation'=>function(ActiveQuery $leftQuery) use ($model){
            $leftQuery->andOnCondition(['location_id'=>$model->location_id]);
        }]);


        //inventory_location_manual_counts
        $inventory_location_manual_counts = $model->getInventoryLocationManualCounts()->indexBy("item_id")->all();
        foreach ($dataProvider->models as $item) {
            $inventory_location_manual_count = isset($inventory_location_manual_counts[$item->id]) ? $inventory_location_manual_counts[$item->id] : new InventoryLocationManualCount();
            $inventory_location_manual_count->item_id = $item->id;
            $inventory_location_manual_count->location_id = $model->location_id;
            $inventory_location_manual_count->inventory_sheet_id = $model->id;
            if(isset($_POST[$inventory_location_manual_count->formName()][$item->id]))
                $inventory_location_manual_count->attributes = Yii::$app->request->post($inventory_location_manual_count->formName())[$item->id];
            $inventory_location_manual_counts[$item->id] = $inventory_location_manual_count;
        }


        //ajax validation
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($inventory_location_manual_counts));
        }

        if (Yii::$app->request->isPost && $model->save()) {
            foreach ($inventory_location_manual_counts as $inventory_location_manual_count){
                $inventory_location_manual_count->inventory_sheet_id = $model->id;
                if($inventory_location_manual_count->on_hand_quantity!=='')
                    $inventory_location_manual_count->save();
                else{
                    if($inventory_location_manual_count->id)
                        $inventory_location_manual_count->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'inventory_location_manual_counts' => $inventory_location_manual_counts,
            ]);
        }
    }

    /**
     * Updates an existing InventorySheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //inventory_sheet
        $model->load(Yii::$app->request->post());

        //items
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=5;
        $dataProvider->query->with(['itemLocation'=>function(ActiveQuery $leftQuery) use ($model){
            $leftQuery->andOnCondition(['location_id'=>$model->location_id]);
        }]);

        //inventory_location_manual_counts
        $inventory_location_manual_counts = $model->getInventoryLocationManualCounts()->indexBy("item_id")->all();
        foreach ($dataProvider->models as $item) {
            $inventory_location_manual_count = isset($inventory_location_manual_counts[$item->id]) ? $inventory_location_manual_counts[$item->id] : new InventoryLocationManualCount();
            $inventory_location_manual_count->item_id = $item->id;
            $inventory_location_manual_count->location_id = $model->location_id;
            $inventory_location_manual_count->inventory_sheet_id = $model->id;
            if(isset($_POST[$inventory_location_manual_count->formName()][$item->id]))
                $inventory_location_manual_count->attributes = Yii::$app->request->post($inventory_location_manual_count->formName())[$item->id];
            $inventory_location_manual_counts[$item->id] = $inventory_location_manual_count;
        }

        //ajax validation
        if(Yii::$app->request->isPost && Yii::$app->request->isAjax){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($inventory_location_manual_counts));
        }

        if (Yii::$app->request->isPost && $model->save()) {
            foreach ($inventory_location_manual_counts as $inventory_location_manual_count){
                $inventory_location_manual_count->inventory_sheet_id = $model->id;
                if($inventory_location_manual_count->on_hand_quantity!==''){
                    $inventory_location_manual_count->save();
                }
                else{
                    if($inventory_location_manual_count->id)
                        $inventory_location_manual_count->delete();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataProvider' => $dataProvider,
                'inventory_location_manual_counts' => $inventory_location_manual_counts,
            ]);
        }
    }

    /**
     * Deletes an existing InventorySheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * Finds the InventorySheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InventorySheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventorySheet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
