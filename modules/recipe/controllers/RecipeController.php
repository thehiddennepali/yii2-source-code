<?php

namespace recipe\controllers;

use measurement\models\Measurement;
use recipe\models\Ingredient;
use Yii;
use recipe\models\Recipe;
use recipe\models\search\RecipeSearch;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends Controller
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
                            return Yii::$app->user->can('createRecipe');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('updateRecipe', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('deleteRecipe', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            if(!isset($_GET['id']))
                                throw new Exception("id parameter is missing");
                            return Yii::$app->user->can('viewRecipe', ['model' => $this->findModel($_GET['id'])]);
                        }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            return Yii::$app->user->can('indexRecipe');
                        }
                    ],
                    [
                        'actions' => ['ingredient'],
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

    /**
     * Lists all Recipe models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecipeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Recipe model.
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
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Recipe();

        $newIngredient = new Ingredient;
        $ingredients = $ingredientsOld = [0=>$newIngredient];

        if(Yii::$app->request->isPost){

            $model->load(Yii::$app->request->post());

            $ingredients = [];
            if(isset($_POST[(new Ingredient)->formName()])){
                foreach ($_POST[(new Ingredient)->formName()] as $i=>$ingredientPost) {
                    if($ingredientPost['id'] && isset($ingredientsOld[$ingredientPost['id']]))
                        $ingredient = $ingredientsOld[$ingredientPost['id']];
                    else
                        $ingredient = new Ingredient;
                    $ingredient->attributes = $ingredientPost;
                    $ingredients[$i] = $ingredient;
                }
            }


            if(Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $errorArray = array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($ingredients));
                return $errorArray;
            }
            if($model->save()) {
                foreach ($ingredients as $ingredient) {
                    $ingredient->parent_id = $model->id;
                    if($ingredient->save()){
                    }
                    else
                        throw new Exception(Html::errorSummary($ingredient));
                }
                $model->trigger($model::EVENT_AFTER_INSERT_DELAY);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'ingredients' => $ingredients,
        ]);


    }

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $ingredients = $ingredientsOld = $model->getIngredients()->indexBy('id')->all();

        if(Yii::$app->request->isPost){

            $model->load(Yii::$app->request->post());

            $ingredients = [];
            if(isset($_POST[(new Ingredient)->formName()])){
                foreach ($_POST[(new Ingredient)->formName()] as $i=>$ingredientPost) {
                    if($ingredientPost['id'])
                        $ingredient = $ingredientsOld[$ingredientPost['id']];
                    else
                        $ingredient = new Ingredient(['parent_id'=>$model->id]);
                    $ingredient->attributes = $ingredientPost;
                    $ingredients[$i] = $ingredient;
                }
            }


            if(Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $errorArray = array_merge(ActiveForm::validate($model), ActiveForm::validateMultiple($ingredients));
                return $errorArray;
            }
            if($model->save()) {
                $ingredientsIDs = [];
                foreach ($ingredients as $ingredient) {
                    if($ingredient->save()){
                        $ingredientsIDs[] = $ingredient->id;
                    }
                    else
                        throw new Exception(Html::errorSummary($ingredient));
                }
                if($ingredientsIDs)
                    Ingredient::deleteAll(['AND',['parent_id'=> $model->id], ['NOT IN', 'id', $ingredientsIDs]]);
                else
                    Ingredient::deleteAll(['parent_id'=> $model->id]);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'ingredients' => $ingredients,
        ]);
    }
    public function actionIngredient($index)
    {
        return $this->renderPartial('ingredient', ['index'=>$index]);
    }

    /**
     * Deletes an existing Recipe model.
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
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
