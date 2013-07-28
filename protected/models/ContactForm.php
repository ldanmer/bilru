<?php
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, body', 'required'),
			array('subject', 'length', 'min'=>3, 'max'=>100),
			array('body', 'length', 'min'=>15),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	public function attributeLabels()
	{
		return array(
			'subject' => 'Заголовок',
			'body' => 'Текст сообщения',
			'verifyCode'=>'Код проверки',
		);
	}
}