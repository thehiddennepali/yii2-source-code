<?php
namespace merchant\models;


use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends Model
{
	public $username;
	public $password;
	public $rememberMe;

        private $_user;
        public $role = 0;


	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return [
			// username and password are required
			[['username', 'password'], 'required'],
			// rememberMe needs to be a boolean
			[['rememberMe', 'role'], 'boolean'],
                    [['rememberMe', 'role'], 'safe'],
			// password needs to be authenticated
			['password', 'validatePassword'],
		];
	}

	/**
	 * Declares attribute labels.
	 */
	public function validatePassword($attribute, $params)
        {

            if (!$this->hasErrors()) {
                $user = $this->getUser();
                
                if($this->role){
                    
                    if (!$user || !$user->validatePassword($this->password)) {
                        $this->addError($attribute, 'Incorrect email or password.');
                    }
                
                }else{
                    
                    if (!$user || !$user->validateManagerPassword($this->password)) {
                        $this->addError($attribute, 'Incorrect email or password.');
                    }
                    
                }
            }
        }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    
    
    

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            
            if($this->role){
                $this->_user = \common\models\Merchant::findByUsername($this->username);
            }else{
                $this->_user = \common\models\Merchant::findByManagerUsername($this->username);
            }
        }
        
//        echo $this->role;
//        echo 'i ma here';
//        print_r($this->_user->attributes);
//        exit;
        
        
        

        return $this->_user;
    }
}
