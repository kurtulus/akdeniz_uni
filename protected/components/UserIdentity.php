<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_user_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',//do everything...
			'viewer'=>'viewer',//just download related exam

		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;*/
		$record=User::model()->findByAttributes(array('username'=>$this->username));
		error_log(print_r($record,1));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==hash('sha512', $this->password.Yii::app()->params['salt']))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->setState('user_id', $record->user_id);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
	}
    public function getUserId()
    {
        return $this->_user_id;
    }
    public function getUserName()
    {
    	return $this->_username;
    }
}