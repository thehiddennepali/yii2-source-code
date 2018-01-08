<?php
namespace merchant\controllers;
use merchant\components\MerchantController;
use Yii;
use common\models\ServiceSubcategory;
use common\models\CategoryHasMerchant;

class ServiceSubcategoryController extends MerchantController
{


    public function actionGetCats(){
        $data=ServiceSubcategory::model()->findAll('category_id=:category_id',
            array(':category_id'=>(int) $_POST['cat_id']));

        $data=CHtml::listData($data,'id','title');
        foreach($data as $value=>$name)
        {
            echo CHtml::tag('option',
                array('value'=>$value),CHtml::encode($name),true);
        }
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CategoryHasMerchant('single');

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CategoryHasMerchant'])) {
            $model->attributes = $_POST['CategoryHasMerchant'];
            $model->merchant_id = Yii::$app->user->id;
            $model->addons = $model->addon_list;
            $model->is_group = 0;
            if ($model->save())
                return $this->redirect(array('index'));
        }

        return $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if($model->merchant_id!=Yii::$app->user->id)
            return $this->redirect(array('index'));

// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['CategoryHasMerchant'])) {
            $model->attributes = $_POST['CategoryHasMerchant'];
            $model->merchant_id = Yii::$app->user->id;
            $model->addons = $model->addon_list;
            $model->is_group = 0;
            
            
            if ($model->save())
               return $this->redirect(array('index'));
        }

       return $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                return $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new CategoryHasMerchant('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CategoryHasMerchant']))
            $model->attributes = $_GET['CategoryHasMerchant'];

        return $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = CategoryHasMerchant::findOne($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        $model->addon_list = CHtml::listData($model->m_c_has_addon,'addon_id','addon_id');
        $model->scenario = 'single';
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-subcategory-form') {
            echo CActiveForm::validate($model);
            Yii::$app->end();
        }
    }
}
