<?php

namespace user\controllers;

use user\models\search\UserSearch;
use user\models\Token;
use user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use extended\controller\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Response;


class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'select'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionSelect()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->select(['id', 'email', 'first_name', 'last_name']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $dataProvider->models;
    }

    /**
     * Lists all User models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => [
                'first_name' => SORT_ASC,
                //'user.updated_at' => SORT_DESC,
            ],
            'attributes' => [
                'first_name' => [
                    'asc' => [
                        '{{%user}}.first_name' => SORT_ASC,
                        'username' => SORT_ASC,
                    ],
                    'desc' => [
                        '{{%user}}.first_name' => SORT_DESC,
                        'username' => SORT_DESC,
                    ],
                ],
            ],

        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
