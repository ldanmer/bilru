<?php

class ObjectsController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'index', 'view', 'search', 'finished'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model = $this->loadModel($id); 
		$photos = json_decode($model->photoes); 
		$blueprints = json_decode($model->blueprints);		
		$this->render('view',array(
			'model'=>$model,
			'photos'=>$photos,
			'blueprints'=>$blueprints,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id='')
	{
		if(!empty($id))
		{
			$objects=$this->loadModel($id);
			$objects->communications = json_decode($objects->communications);
		}			
		else
		{
			$objects=new Objects;	
			$objects->user_id = Yii::app()->user->id;		
			$objects->save(false);
			$this->redirect(array('create', 'id' => $objects->id));
		}	

			if(isset($_POST['Objects']))
			{
				$objects->attributes=$_POST['Objects'];	
				$objects->communications = $_POST['Objects']['communications'] != "" ? json_encode($_POST['Objects']['communications']) : NULL;				
				if(!empty($_FILES['photoes']) && CUploadedFile::getInstancesByName('photoes'))
					$objects->photoes = GetName::saveUploadedFiles('photoes',$uploadDir);
				if(!empty($_FILES['bluprints']) && CUploadedFile::getInstancesByName('bluprints'))
					$objects->blueprints = GetName::saveUploadedFiles('bluprints',$uploadDir);
				if(!empty($_FILES['objectdocs']) && CUploadedFile::getInstancesByName('objectdocs'))
					$objects->documents = GetName::saveUploadedFiles('objectdocs',$uploadDir);	

				if($objects->save()) 
				{
		  		$objects->deleteAll('region_id=0');
		  		$this->redirect(array('view','id'=>$objects->id));
				}
					
			}	

		$this->render('create',array(
			'objects'=>$objects,
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

		if(isset($_POST['Objects']))
		{
			$model->attributes=$_POST['Objects'];
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
		if($_POST['Objects']['id'])
		{
			$object = $this->loadModel($_POST['Objects']['id']);
			$object->status=1;
			if($object->update())
				$this->redirect(array('finished'));
		}
			
		$criteria = new CDbCriteria;
		$criteria->condition = 'status=0 AND user_id='.Yii::app()->user->id;
		$dataProvider=new CActiveDataProvider('Objects', array('criteria'=>$criteria));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionFinished()
	{
		if($_POST['Objects']['id'])
		{
			$object = $this->loadModel($_POST['Objects']['id']);
			$object->status=0;
			if($object->update())
				$this->redirect(array('index'));
		}
			
		$criteria = new CDbCriteria;
		$criteria->condition = 'status=1 AND user_id='.Yii::app()->user->id;
		$dataProvider=new CActiveDataProvider('Objects', array('criteria'=>$criteria));
		$this->render('finish',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Objects('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Objects']))
			$model->attributes=$_GET['Objects'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionSearch()
	{
		$model=new Objects('search');
		
		$model->unsetAttributes();  // clear any default values	

		// Регион
		if(isset($_GET['Objects']['region_id']))
		{
			$model->region=$_GET['Objects']['region_id'];			
		}			

		// Тип работ
		if(isset($_GET['Objects']['work_type_id']))
		{
			$model->work_type_id=$_GET['Objects']['work_type_id'];
		}

		$this->render('search',array(
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
		$model=Objects::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='objects-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
