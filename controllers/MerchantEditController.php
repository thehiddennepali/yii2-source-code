<?php
namespace merchant\controllers;
use merchant\components\MerchantController;
use Yii;
use common\models\Merchant;
use common\models\MerchantSchedule;
use common\models\MerchantScheduleHistory;

class MerchantEditController extends MerchantController
{
    public function actions()
    {
        return array(
            'addOneMany'=> \common\extensions\AddOneManyAction::className(),
        );
    }

    public function init(){
        $this->menu = false;
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    
    public function actionActivate(){
        $model = Yii::$app->user->identity;
        $model->is_activate = (Yii::$app->user->identity->is_activate == 1) ? 0 : 1;
        $model->save(false);
        
        return $this->goHome();
        
    }
    
    public function actionIndex()
    {
        if(!Yii::$app->user->identity->role)  
            return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;
        $model->scenario = 'edit';



// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
              return  $this->redirect(array('index'));
        }

       return $this->render('update', array(
            'model' => $model,
            'form'=>'_form1'
        ));
    }
    
	public function actionSetting(){
		$model = Yii::$app->user->identity;
		
		if($model->load(Yii::$app->request->post())){
			$model->save(false);
			
		}
		
		
		return $this->render('update', [
		    'model' => $model,
		    'form' => 'setting'
		]);
	}

    public function actionAdditional()
    {
        if(!Yii::$app->user->identity->role)  return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;

        if (isset($_POST['Merchant'])) {
		
		

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
                return $this->redirect(array('index'));
        }

       return $this->render('update', array(
            'model' => $model,
            'form'=>'_form2'
        ));
    }

    public function actionUsername()
    {
        if(!Yii::$app->user->identity->role) return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;
        $model->scenario = 'edit';

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            
            if(!empty($_POST['Merchant']['new_password'])){
                $model->password = $_POST['Merchant']['new_password'];
                $model->setPassword($_POST['Merchant']['new_password']);
                $model->generateAuthKey();
            }
            
            if(!empty($_POST['Merchant']['manager_new_password'])){
		    
                $model->manager_password = $_POST['Merchant']['manager_new_password'];
                $model->setManagerPassword($_POST['Merchant']['manager_new_password']);
		
		
            }
            
            
            if ($model->save()){
		    
		    if(!empty($_POST['Merchant']['manager_new_password'])){
			    \merchant\components\EmailManager::manageLoginDetail($model);
		    
		    }
		    
               return $this->redirect(array('index'));
	    }
        }

       return $this->render('update', array(
            'model' => $model,
            'form'=>'_form3'
        ));
    }

    public function actionSocial()
    {
        if(!Yii::$app->user->identity->role)  return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
               return $this->redirect(array('index'));
        }

        return $this->render('update', array(
            'model' => $model,
            'form'=>'_form5'
        ));
    }

    public function actionPayment()
    {
        if(!Yii::$app->user->identity->role)  return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
                return $this->redirect(array('index'));
        }

       return $this->render('update', array(
            'model' => $model,
            'form'=>'_form6'
        ));
    }

    public function actionGallery()
    {
        if(!Yii::$app->user->identity->role)  return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
              return  $this->redirect(array('index'));
        }

        return $this->render('update', array(
            'model' => $model,
            'form'=>'_form7'
        ));
    }

    public function actionAdmin()
    {
        if(!Yii::$app->user->identity->role)  return $this->redirect(array('dashboard/index'));
        $model = Yii::$app->user->identity;

        if (isset($_POST['Merchant'])) {

            $model->attributes = $_POST['Merchant'];
            $model->detachBehavior('oneManyBehavior');
            if ($model->save())
              return  $this->redirect(array('index'));
        }

        return $this->render('update', array(
            'model' => $model,
            'form'=>'_form4'
        ));
    }

    public function actionSchedule()
    {
        if (isset($_POST['MerchantScheduleHistory'])) {
            $ss = new MerchantScheduleHistory();

            $ss->attributes = $_POST['MerchantScheduleHistory'];
            
            $om = MerchantScheduleHistory::find()
                    ->where('merchant_id='.Yii::$app->user->id)
                    ->orderBy('id desc')
                    ->one();
            
            $change = false;
            if(empty($om))
                $change = true;
            else
                foreach(array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $key){
                    if(($ss->attributes[$key]||$om->attributes[$key])&&($ss->attributes[$key] != $om->attributes[$key])){
                        $change = true; break;
                    }
                }

            if($change){
                $ss->id = '';
                $ss->merchant_id = Yii::$app->user->id;
                $ss->save();
            }

                return $this->redirect(array('schedule'));
        }

        return $this->render('update', array(
            'model' => Yii::$app->user->identity,
            'form'=>'_form8'
        ));
    }

    public function actionEschedule()
    {
        $model = Yii::$app->user->identity;
        $model->oneMany = $model->futureMerchantSchedules;
        

        if (isset($_POST) && !empty($_POST)) {
//            echo '<pre>';
//            print_r($_POST);
//            exit;
            if ($model->save())
              return  $this->redirect(array('index'));
        }

        return $this->render('update', array(
            'model' => $model,
            'form'=>'_form9'
        ));
    }

    /**
     * Manages all models.
     */
    public function actionEscheduleh()
    {
        
        
        
        $searchModel = new \common\models\MerchantScheduleSearch();
        $searchModel->merchant_id = Yii::$app->user->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('history', array(
            'model' => $model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'merchant-form') {
            echo CActiveForm::validate($model);
            Yii::$app->end();
        }
    }

    public function getNewModel(){
        return new Merchant;
    }

    public function actionPurchase()
    {
        if(Yii::$app->request->isPostRequest){
            Merchant::model()->updateByPk(Yii::$app->user->id,['is_purchase'=>1, 'membership_purchase_date'=>date('Y-m-d H:i:s')]);
        }
        Yii::$app->end();
    }
}
