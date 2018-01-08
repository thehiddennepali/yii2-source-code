<?php
namespace merchant\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Cookie;
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MerchantController extends Controller
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='merchant_tpl';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    
    
    public function behaviors() {
        parent::behaviors();
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'actions' => ['create','add-single-memcached-order','purchase','update',
			'delete-single-order','get-group-order','get-events','schedule-history',
			'update-inst','get-staff-free-time','get-price','get-free-staff','index','remove',
			'delete','getCats','addOneMany','groupAdd','addOneMany2','add','additional','username', 
			'social', 'payment', 'gallery', 'admin', 'schedule', 'eschedule', 'escheduleh',
			'indexgroup', 'moregroup','get-group-orders', 'group-add', 'activate',
			'client-info', 'change-delivery',
			'setting',
			'view'],
                    'allow' => true,
                    'matchCallback' => function() {
                        return self::allowAccess();
                    }
                    ],
                ]
            ]
        ];
    }
    
    
    public function beforeAction($event)
    {
//        $cookies = Yii::$app->request->cookies;
//        
//        $languageCookie = $cookies['language'];
        
        
        if(!empty(Yii::$app->user->identity->language_id)){
            
            $language = Yii::$app->user->identity->language->code;
//            echo 'i m ahere';
//            echo '<pre>';
//            print_r($language);
//            exit;

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24 * 30, // 30 days
            ]);
            Yii::$app->response->cookies->add($languageCookie);
            
            
            
        }
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        
        
        return parent::beforeAction($event);
    }

    public static  function allowAccess(){
        
        if (!Yii::$app->user->isGuest){
            return true;
        }
        return false;
    }

    public function init(){
        $this->menu = true;
    }

}