<?php

class UserRecovery extends CFormModel
{
	public $email;
	public $user_id;

	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'checkexists'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function checkexists($attribute,$params)
	{
		$email=$this->email;
   	$criteria = new CDbCriteria();
   	$criteria->condition='email=:email';
   	$criteria->params=array(':email'=>$email);
   	$user = User::model()->find($criteria);
	  if(empty($user))
      $this->addError('email', 'Пользователь с таким email не найден');
    else
    	$this->user_id=$user->id;
	}
}
