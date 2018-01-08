<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

    public $role = 1;

    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     */
    public function __construct($username,$password,$role = 1)
    {
        $this->username=$username;
        $this->password=$password;
        $this->role = $role;
    }

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if($this->role){
            $user=Merchant::model()->find('LOWER(username)=?',array(strtolower($this->username)));
        }else{
            $user=Merchant::model()->find('LOWER(manager_username)=?',array(strtolower($this->username)));
        }

		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password, $this->role))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$user->merchant_id;
			$this->username=$this->role?$user->username:$user->manager_username;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}