<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function actions(){
			return array(
				'captcha'=>array(
				'class'=>'CCaptchaAction',
			),
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('register','captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('feed'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','view', 'update'),
				'users'=>array('info@danmer-studio.ru'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		$this->layout="//layouts/main";		

		$model = new User;
		$userData = new PersonalData;
		$orgData = new OrganizationData;
		$userSettings = new UserSettings;

		$userRole = CHttpRequest::getParam('userRole');
		$regionNames = GetName::getNames('Region', 'region_name');
		$cityNames = GetName::getNames('City', 'city_name');
		$orgTypes = GetName::getNames('OrgType', 'org_type_name');

		$this->performAjaxValidation($model);


		// Обработка 1го шага
		if ($userRole > 0 && $userRole < 11) 
			$roleAttributes = $model->getUserAttributes($userRole);				

		//Обработка 2го шага		
		if(isset($_POST['User']) && isset($_POST['PersonalData']))
		{	
			// get form attributes
			$model->attributes=$_POST['User'];
			$userData->attributes = $_POST['PersonalData'];	
			$orgData->attributes=((isset($_POST['OrganizationData'])?$_POST['OrganizationData']:array()));		
			$model->activation_string=User::encrypting(microtime().$model->password);

			// OrgType
			if ($userRole == 1 || $userRole == 5 || $userRole == 6) 
				$model->org_type_id = 1;	
			else 
				$model->org_type_id += 2;	

			// userRole
			if ($userRole > 1) 
				$userRole -= 1;
			$model->role_id = $userRole;		


			if($model->save())
			{
				$userData->user_id = $userSettings->user_id = $model->id;
				$userData->save();
				if(!empty($orgData->attributes))
				{
					$orgData->user_id = $model->id;
					$orgData->save();
				}
					
				Yii::app()->user->setFlash('success',"Благодарим за регистрацию! Пожалуйста, проверьте свой email.");	

				
				if($model->sendActivationString($model))
				{
					Yii::app()->user->setFlash('success',"Благодарим за регистрацию! Пожалуйста, проверьте свой email.");	
				}						
				else
				{
					Yii::app()->user->setFlash('error',"Отправка почтового подтверждения не доступна");
						throw new CHttpException(503,'Отправка почтового подтверждения не доступна');
				}
															
			}	
			else						
			{
				$model->validate();
				$userData->validate();
				if(!empty($orgData->attributes))
					$orgData->validate();
			}

				/* Yii::app()->user->setFlash('error',"Ошибка регистрации. Если ошибка возникает повторно, свяжитесь с администратором сайта ".Yii::app()->params['adminEmail']);	*/				
		}

		// Вывод формы
		$this->render('registration',
			array(
				'model'=>$model, 
				'userData' => $userData,
				'roleAttributes'=>$roleAttributes,
				'regionNames' => $regionNames,
				'cityNames' => $cityNames,
				'orgTypes' => $orgTypes,
				'orgData' => $orgData,
				)
			);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}