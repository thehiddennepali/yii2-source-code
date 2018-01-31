<?php

namespace item\controllers;

use inventory\models\InventoryLocationManualCount;
use Yii;
use item\models\Item;
use item\models\search\ItemSearch;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('createItem');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexItem');
                        }
                    ],
                    [
                        'actions' => ['select', 'get-converted-pound-price', 'cost'],
                        'allow' => true,
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
    protected function performAjaxValidation($model, $attributes = null)
    {
        if(!Yii::$app->request->isPjax && Yii::$app->request->isAjax)
        {
            if($model->load(Yii::$app->request->post()))
            {
                /*
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
                */
                echo json_encode(ActiveForm::validate($model, $attributes));
                Yii::$app->end();
            }
        }
    }

    public function actionSelect($index)
    {
        $models = Item::find()->onlyRaw()->all();

        $return = Html::tag('option', "Select", ['value'=>'']);
        foreach($models as $model)
            $return.=Html::tag('option', $model->item_name, ['value'=>$model->id]);
        return $return;
    }

    public function actionGetConvertedPoundPrice($item_id, $amount, $unit)
    {
        $item = Item::findOne($item_id);
        $price = $item->getConvertedPoundPrice($unit) * $amount;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'price'=>$price,
            'priceAsCurrency'=>Yii::$app->formatter->asCurrency($price),
        ];
    }

    public function actionCost($item_id, $case=0, $unit)
    {
        $inventory_location_manual_count = new InventoryLocationManualCount;
        $inventory_location_manual_count->item_id = $item_id;
        $inventory_location_manual_count->on_hand_quantity = $case;
        $inventory_location_manual_count->unit = $unit;

        return $inventory_location_manual_count->countCost;
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Item model.
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
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
