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
			array('allow', 
				'actions'=>array('feed', 'view', 'update', 'main','profile', 'about',  'licenceUpload'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index','update'),
				'users'=>array('admin@bilru.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	// Просмотр реквизитов
	public function actionView()
	{	
		$this->render('view',array(
			'model'=>$this->loadModel(Yii::app()->user->id),
		));
	}

	// Просмотр основной информации
	public function actionMain()
	{	
		$model = $this->loadModel(Yii::app()->user->id);
		$this->render('main',array(
			'model'=>$model,
		));
	}

	// Просмотр профиля другим пользователем
	public function actionProfile($id)
	{	
		$model = $this->loadModel($id);
		$gallery = json_decode($model->userInfo[0]->portfolio);
		$license = json_decode($model->userInfo[0]->license);		
		$photoArr = array();
		foreach ($model->objects as $object) 
		{
			$photoArr[] = json_decode($object->photoes);
		}

		$objectsPhoto = GetName::multipleToSingleArray($photoArr);

		$this->render('profile',array(
			'model'=>$model,
			'gallery'=>$gallery,
			'license'=>$license,
			'objectsPhoto' => $objectsPhoto
		));
	}

	// Просмотр/Редактирование деятельности
	public function actionAbout()
	{	
		$model = $this->loadModel(Yii::app()->user->id);	
		$uploadDir = '/files/docs_upload/'.$model->id.'/';
		GetName::makeDir($uploadDir);

		if(isset($_POST['OrganizationData']))
		{
			$model->userInfo[0]->description = $_POST['OrganizationData']['description'];
			if($model->userInfo[0]->update())
				Yii::app()->user->setFlash('success',"Описание сохранено");	
			else
				Yii::app()->user->setFlash('error',"Ошибка сохранения. Попробуйте еще раз или свяжитесь с администратором");
		}
		
		if(isset($_POST['UserSettings']))
		{
			if((CUploadedFile::getInstancesByName('license')))
				$model->userInfo[0]->license = GetName::saveUploadedFiles('license',$uploadDir, $model->userInfo[0]->license);

			if((CUploadedFile::getInstancesByName('portfolio')))
				$model->userInfo[0]->portfolio = GetName::saveUploadedFiles('portfolio',$uploadDir, $model->userInfo[0]->license);

			if($file = CUploadedFile::getInstance($model->settings[0],'avatar'))
			{
				$fileName = GetName::translit($file->getName());
				$model->settings[0]->avatar = $uploadDir.$fileName;
				if($model->settings[0]->validate())
				{
					$model->settings[0]->save();
					$file->saveAs(Yii::getPathOfAlias('webroot').$model->settings[0]->avatar);	
				}
			}
		}
		
		if(isset($_POST['UserInfo']['regions']))
			$model->userInfo[0]->regions = json_encode($_POST['UserInfo']['regions']);

		if(isset($_POST['UserInfo']['profiles']))
				$model->userInfo[0]->profiles = json_encode($_POST['UserInfo']['profiles']);

		if(isset($_POST['UserInfo']['goods']))
			$model->userInfo[0]->goods = json_encode($_POST['UserInfo']['goods']);
		
		$model->userInfo[0]->update();		


		$gallery = json_decode($model->userInfo[0]->portfolio);
		$geography = GetName::jsonToString($model->userInfo[0]->regions, GetName::getNames('Region', 'region_name'), "li");
		if(GetName::getCabinetAttributes()->type == 2)
		{
			$profile = GetName::jsonToString($model->userInfo[0]->profiles, Orders::model()->categoryList, "li");
			$goods = GetName::jsonToString($model->userInfo[0]->goods, GetName::getNames('WorkTypes', 'name'), "li");
		}

		if(GetName::getCabinetAttributes()->type == 3)
		{
			$profile = GetName::jsonToString($model->userInfo[0]->profiles, MaterialBuy::model()->categoryList, "li");
			$goods = GetName::jsonToString($model->userInfo[0]->goods, GetName::getNames('MaterialList', 'name'), "li");
		}

		$model->userInfo[0]->regions = json_decode($model->userInfo[0]->regions);
		$model->userInfo[0]->profiles = json_decode($model->userInfo[0]->profiles);
		$model->userInfo[0]->goods = json_decode($model->userInfo[0]->goods);
		$this->render('about',array(
			'model'=>$model,
			'gallery'=>$gallery,
			'geography'=>$geography,
			'profile'=>$profile,
			'goods'=>$goods,
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
		$userInfo = new UserInfo;

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
			$orgData->attributes=isset($_POST['OrganizationData'])?$_POST['OrganizationData']:array();		
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
				$userData->user_id = $userSettings->user_id = $userInfo->user_id = $orgData->user_id = $model->id;
				$userData->save();
				$userSettings->save(false);
				$userInfo->save(false);				
				if(empty($orgData->org_name))
				{
					$orgData->org_name = 'Не указано';
					$orgData->terms = true;					
				}
				$orgData->save();
					
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
	public function actionUpdate()
	{
		$model=$this->loadModel(Yii::app()->user->id);


		if(isset($_POST['User']) && isset($_POST['PersonalData']) && isset($_POST['OrganizationData']))
		{
			$model->attributes=$_POST['User'];
			$model->personalData[0]->attributes=$_POST['PersonalData'];
			$model->organizationData[0]->attributes=$_POST['OrganizationData'];
			if($model->update() && $model->personalData[0]->update() && $model->organizationData[0]->update())
				$this->redirect(array('view'));
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
