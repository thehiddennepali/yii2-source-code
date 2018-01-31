<?php

namespace measurement\controllers;

use Yii;
use measurement\models\MeasurementItem;
use measurement\models\search\MeasurementItemSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use user\models\User;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use extended\controller\Controller;


/**
 * MeasurementItemController implements the CRUD actions for MeasurementItem model.
 */
class MeasurementItemController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        //'roles' => [User::ROLE_USER],
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('createMeasurementItem');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateMeasurementItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteMeasurementItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewMeasurementItem', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexMeasurementItem');
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


    /**
     * Lists all MeasurementItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MeasurementItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MeasurementItem model.
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
     * Creates a new MeasurementItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MeasurementItem;
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionAdd($item_id)
    {
        $model = new MeasurementItem(['item_id'=>$item_id]);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            return $this->redirect(Yii::$app->request->referrer);
        }
        else
            throw new Exception(Html::errorSummary($model));
    }

    /**
     * Updates an existing MeasurementItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MeasurementItem model.
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
     * Finds the MeasurementItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MeasurementItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MeasurementItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
