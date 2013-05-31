<?php

class OrdersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $pageTitle = "Заказы";
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			/*
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			), */
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','create','update', 'search','view','finished','rating'),
				'users'=>array('@'),
			),
		/*	array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','view','delete'),
				'users'=>array('admin'),
			),*/
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
		$criteria = new CDbCriteria;
		$criteria->condition = 'order_id=:order_id AND supplier_id='.Yii::app()->user->id;
		$criteria->params = array(':order_id'=>$id);
		$already = OrderOffer::model()->find($criteria);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'already'=>$already,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Orders;

		// Поиск объектов пользователя
		$criteria = new CDbCriteria;
		$criteria->condition = 'user_id = :userId';
		$criteria->params = array(':userId' => Yii::app()->user->id);
		$criteria->select = 'id,title';
		$objectList=Objects::model()->findAll($criteria);

		// Сохранение полей объектов в массив
		if(empty($objectList) || $_GET['object'] == 'new')
			$objects = new Objects;
		else
		{			
			foreach ($objectList as $object) {
				$objects[$object->id]	 = $object->title;
			}
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$uploadDir = '/files/docs_upload/'.Yii::app()->user->id;
		GetName::makeDir($uploadDir);
	
		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
			$model->documents = GetName::saveUploadedFiles('documents',$uploadDir);	
			$publish = isset($_POST['publish']) ? 1 : 0;  
			if(!empty($_POST['Orders']['user_role_id']))
		  	$model->user_role_id = json_encode($_POST['Orders']['user_role_id']);
		  if(!empty($_POST['Orders']['work_type_id']))
				$model->work_type_id = json_encode($_POST['Orders']['work_type_id']);
			$model->pub_status = $publish;

			if(isset($_POST['Objects']))
			{
				$objects->attributes=$_POST['Objects'];	
				$objects->communications = json_encode($_POST['Objects']['communications']);
				$objects->user_id = Yii::app()->user->id;
				$objects->photoes = GetName::saveUploadedFiles('photoes',$uploadDir);
				$objects->blueprints = GetName::saveUploadedFiles('bluprints',$uploadDir);
				$objects->documents = GetName::saveUploadedFiles('objectdocs',$uploadDir);	

				/**
				* TODO 
				*	Как-то придумать, чтобы без валидации заказа, объект не создавался
				*/
					if($objects->validate())
						$model->object_id = Objects::model()->find('id');

				if($model->validate() && $objects->save()) 
					$model->object_id = $objects->id;
			}		
			if($model->save())
			{				
				$this->redirect(array('index'));
			}				
		}
		$this->render('create',array(
			'model'=>$model,
			'objects' => $objects,
		));
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

		if(isset($_POST['Orders']))
		{
			$model->attributes=$_POST['Orders'];
			$model->documents = GetName::saveUploadedFiles('documents',$uploadDir);	
			$publish = isset($_POST['publish']) ? 1 : 0;  
			if(!empty($_POST['Orders']['user_role_id']))
		  	$model->user_role_id = json_encode($_POST['Orders']['user_role_id']);
		  if(!empty($_POST['Orders']['work_type_id']))
				$model->work_type_id = json_encode($_POST['Orders']['work_type_id']);
			$model->pub_status = $publish;
			if($model->save())
				$this->redirect(array('index'));
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
		// Поиск заказов пользователя
		$criteria = new CDbCriteria;
		$criteria->with = array('object');
		$criteria->condition = 'user_id = :userId AND status=0';
		$criteria->params = array(':userId' => Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Orders', array('criteria'=>$criteria));		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists finished models.
	 */
	public function actionFinished()
	{
		// Поиск заказов пользователя
		$criteria = new CDbCriteria;
		$criteria->with = array('object');
		$criteria->condition = 'user_id = :userId AND status=1';
		$criteria->params = array(':userId' => Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Orders', array('criteria'=>$criteria));		
		$this->render('finished',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		$model=new Orders('search');
		
		$model->unsetAttributes();  // clear any default values	

		if(isset($_GET['Orders']['org_type']))
			$model->org_type=$_GET['Orders']['org_type'];

		// Регион
		if(isset($_GET['Orders']['region_id']))
			$model->region=$_GET['Orders']['region_id'];

		// Тип работ
		if(isset($_GET['Orders']['work_type_id']))
			$model->work_type_id=$_GET['Orders']['work_type_id'];


		$this->render('search',array(
			'model'=>$model,
		));
	}


	public function actionRating($id)
	{
		$rating=new UserRating;
		$status=Orders::model()->findByPk($id);		
		$model=OrderOffer::model()->find("order_id=:id", array(":id"=>$id));

		if(isset($_POST['UserRating']))
		{
			$rating->rater_id = Yii::app()->user->id;
			$rating->user_id = $model->supplier_id;
			$rating->review = $_POST['UserRating']['review'];
			// Проверка на 0
			foreach ($_POST['UserRating']['score'] as $value) 
				$sum += $value;
			if($sum != 0)
			$rating->rating = json_encode($_POST['UserRating']['score']);

			if($rating->save())
			{
				$status->status = 1;
				$status->rating_id = $rating->id;
				$status->update();
				Yii::app()->user->setFlash('success',"Благодарим вас за оценку!");
				$this->redirect(array('finished'));
			}
				
		}

		$this->render('rating',array(
			'model'=>$model,
			'rating'=>$rating,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Orders::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='orders-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
