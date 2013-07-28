<?php

class SiteController extends Controller
{
		public $layout='//layouts/main';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
			'resized' => array(
        'class'   => 'ext.resizer.ResizerAction',        
      ),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{		
		$this->layout="//layouts/main";
		if(Yii::app()->user->isGuest)
			$this->render('index');
		else
			$this->redirect(Yii::app()->user->returnUrl);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) 
		{
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) 
					$this->redirect(Yii::app()->user->returnUrl);
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->user->returnUrl);
	}

		/**
	 * Displays the login page
	 */
	public function actionRecovery()
	{
		$this->layout="//layouts/main";
		if (Yii::app()->user->isGuest) 
		{
			$model = new UserRecovery;	
			if(isset($_POST['UserRecovery']['email']))	
			{
				$model->email = $_POST['UserRecovery']['email'];
				if($model->validate())
				{
					$user = User::model()->findbyPk($model->user_id);
					if(User::model()->sendRecoveryString($user))
						Yii::app()->user->setFlash('success',"Проверьте ваш почтовый ящик");
					else
						Yii::app()->user->setFlash('error',"Ошибка отправки почты. Если ошибка повторяется, свяжитесь с администратором");
				}
			}		
			
			if(isset($_GET['email']) && isset($_GET['activation_string']))
			{
				$user = User::model()->findByAttributes(array('email'=>$_GET['email']));
				if(!empty($user) && $user->activation_string == $_GET['activation_string'])
				{
					if(isset($_POST['User']['password']) && isset($_POST['User']['password_repeat']))
					{
						if($_POST['User']['password'] == $_POST['User']['password_repeat'])
						{
							$user->password = User::model()->hashPassword($_POST['User']['password']);
							$user->activation_string=User::encrypting(microtime().$user->password);
							$user->active_status = 1;
							$user->update();
							Yii::app()->user->setFlash('success',"Пароль изменен");
							$this->redirect($this->createUrl('/site/login'));
						}							
					}
					$this->render('changepassword',array('model'=>$user));
				}					

			}	
			else	
    		$this->render('recovery',array('model'=>$model));
    } 
    else 
    {
    	$this->redirect(Yii::app()->user->returnUrl);
    	
    }
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}