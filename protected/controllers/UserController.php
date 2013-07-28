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
				'actions'=>array('feed', 'view', 'update', 'main','profile', 'about', 'payment', 'tarifUpdate','detailsEdit'),
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
		$model = $this->loadModel(Yii::app()->user->id);
		// смена пароля
		if($_POST['User'])
		{
			if(!$model->validatePassword($_POST['User']['password']))
				Yii::app()->user->setFlash('error',"<h4>Ошибка!</h4>. Текущий пароль указан неверно.");
			else
			{
				$model->password = $_POST['User']['newPassword'];
				$model->password_repeat = $_POST['User']['newPassword_repeat'];
				$model->verifyCode = $_POST['User']['verifyCode'];
				if($model->validate())
				{
					$model->update();
					Yii::app()->user->setFlash('success','Новый пароль успешно сохранен!');
				}					
				else
					Yii::app()->user->setFlash('error',GetName::arrayToUl($model->getErrors()));
					
			}	
		}
		$this->render('view',array(
			'model'=>$model,
		));
	}

	// Просмотр основной информации
	public function actionMain()
	{	
		$model = $this->loadModel(Yii::app()->user->id);
		
		if(CUploadedFile::getInstancesByName('avatar'))
		{
			$uploadDir = '/images/originals/'.$model->id;
			$model->settings->avatar = GetName::saveUploadedFiles('avatar',$uploadDir);
			$model->settings->update();
		}

		$this->render('main',array(
			'model'=>$model,
		));
	}

	// Просмотр профиля другим пользователем
	public function actionProfile($id)
	{	
		$model = $this->loadModel($id);
		$gallery = json_decode($model->userInfo->portfolio);
		$license = json_decode($model->userInfo->license);		
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
		if(isset($_POST['UserInfo']))
		{
			$model->userInfo->description = $_POST['UserInfo']['description'];
			if($model->userInfo->update())
				Yii::app()->user->setFlash('success',"Описание сохранено");	
			else
				Yii::app()->user->setFlash('error',"Ошибка сохранения. Попробуйте еще раз или свяжитесь с администратором");
		}
		
			if(!empty($_FILES['license']) && CUploadedFile::getInstancesByName('license'))
				$model->userInfo->license = GetName::saveUploadedFiles('license',$uploadDir, $model->userInfo->license);
			if(!empty($_FILES['portfolio']) && CUploadedFile::getInstancesByName('portfolio'))
				$model->userInfo->portfolio = GetName::saveUploadedFiles('portfolio',$uploadDir, $model->userInfo->portfolio);

		
		if(isset($_POST['UserInfo']['regions']))
			$model->userInfo->regions = json_encode($_POST['UserInfo']['regions']);

		if(isset($_POST['UserInfo']['profiles']))
				$model->userInfo->profiles = json_encode($_POST['UserInfo']['profiles']);

		if(isset($_POST['UserInfo']['goods']))
			$model->userInfo->goods = json_encode($_POST['UserInfo']['goods']);
		
		$model->userInfo->update();	
		
		$gallery = json_decode($model->userInfo->portfolio);
		$geography = User::geographyList($model->userInfo->regions);

		if(GetName::getCabinetAttributes()->type == 2)
		{
			$profile = GetName::jsonToString($model->userInfo->profiles, Orders::model()->categoryList, "li");
			$goods = GetName::jsonToString($model->userInfo->goods, GetName::getNames('WorkTypesList', 'name'), "li");
		}

		if(GetName::getCabinetAttributes()->type == 3)
		{
			$profile = GetName::jsonToString($model->userInfo->profiles, MaterialBuy::model()->categoryList, "li");
			$goods = GetName::jsonToString($model->userInfo->goods, GetName::getNames('MaterialList', 'name'), "li");
		}

		$model->userInfo->regions = json_decode($model->userInfo->regions);
		$model->userInfo->profiles = json_decode($model->userInfo->profiles);
		$model->userInfo->goods = json_decode($model->userInfo->goods);
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
					$orgData->org_name = 'Не указано';	

				$orgData->save();
				
				if($model->sendActivationString($model))
					Yii::app()->user->setFlash('success',"Благодарим за регистрацию! Пожалуйста, проверьте свой email.");					
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
		
		}

		// Вывод формы
		$this->render('registration',
			array(
				'model'=>$model, 
				'userData' => $userData,
				'roleAttributes'=>$roleAttributes,
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
			$model->personalData->attributes=$_POST['PersonalData'];
			$model->organizationData->attributes=$_POST['OrganizationData'];
			if($model->update() && $model->personalData->update() && $model->organizationData->update())
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
	public function actionPayment()
	{
		$model=$this->loadModel(Yii::app()->user->id);
		$emptyFields = array();
		foreach($model->organizationData->attributes as $key=>$attribute)
		{
			if(empty($attribute))
			{
				if($key == 'region_id' || $key == 'street' || $key == 'house' || $key == 'office')
					continue;
				else
					$emptyFields[] = $key;
			}				
		}

		if($_GET['UserSettings']['tariff'] && $_GET['UserSettings']['tariff'] != 1)
		{
			if($_GET['mode'] != 0)
				Yii::app()->user->setFlash('success', 'Переадресация к форме оплаты');
			else
				$this->redirect(array('bill/create', 'tarif'=>$_GET['UserSettings']['tariff'], 'term' =>$_GET['term'], 'mode'=>$_GET['mode']));	
		}
		
		$this->render('payment',array(
			'model'=>$model,
			'emptyFields'=>$emptyFields,
		));
	}

	public function actionTarifUpdate()
	{
	 	$data = array();
  	$data["tarifVal"] = $_POST['tarifVal']; 
  	$data["month"] = $_POST['month'];
    $this->renderPartial('_payment', $data, false, true);
	}

	public function actionDetailsEdit()
	{
		$model=$this->loadModel(Yii::app()->user->id);
		if(Yii::app()->getRequest()->getIsAjaxRequest()) 
		{
			if(isset($_POST['OrganizationData']))
			{
				foreach($_POST['OrganizationData'] as $key=>$data)
				{
					if(empty($data))
					{
						echo CJSON::encode(array(
	         		'status'=>'error',
	         		'message'=>'не все поля заполнены!',
         		));	
         		Yii::app()->end();					
					}
				}


				$model->organizationData->attributes = $_POST['OrganizationData'];
				if($model->organizationData->validate())
				{
					$model->organizationData->save(false);
					echo CJSON::encode(array(
	         		'status'=>'success',	         		
         		));	
					Yii::app()->end();
				}
				else
					echo CJSON::encode(array(
	         		'status'=>'error',
	         		'message'=>'ошибка сохранения! Попробуйте еще раз',
         		));	

				Yii::app()->end();
			}
		}

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
