<?php 
Yii::import('zii.widgets.CPortlet');
class Contact extends CPortlet
{
	public $email;
  public function init()
  {
    parent::init();
  }
 
	protected function renderContent()
	{
		$model=new ContactForm;
		$user = User::model()->findByPk(Yii::app()->user->id);
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			$model->name = $user->personalData->first_name.' '.$user->personalData->middle_name.' '.$user->personalData->last_name;
			$model->email = $user->email;
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail($this->email,$subject,$model->body,$headers);
				Yii::app()->user->setFlash('success','Сообщение отправлено');
				$this->controller->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}
}

