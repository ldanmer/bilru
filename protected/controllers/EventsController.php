<?php

class EventsController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
			'ajaxOnly + like',
			'ajaxOnly + comment',
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
				'actions'=>array('create','update','index','like','comment'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Events;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			$model->user_id = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Events']))
		{
			$model->attributes=$_POST['Events'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionComment()
	{
		$comment = new EventsComments;
		if(Yii::app()->getRequest()->getIsAjaxRequest()) 
		{
			if(isset($_POST['EventsComments']) && isset($_POST['Events']))
			{
				$comment->comment = $_POST['EventsComments']['comment'];
				$comment->event_id = $_POST['Events']['id'];
				$comment->user_id = Yii::app()->user->id;				

				if($comment->validate())
				{
					$comment->save(false);
					$event = $this->loadModel($comment->event_id);
			   	echo CJSON::encode(array(
			   		'id'=>$comment->event_id,
         		'status'=>'success',
         		'count'=>$event->commentsCount,
         	));
         Yii::app()->end();
				}
				else
				{
			   	echo CJSON::encode(array(
         		'error'=>$comment->getError('comment'),
         		'id'=>$comment->event_id,
         	));			   	
					Yii::app()->end(); 
				}
			}
		}
	}

	public function actionLike()
	{ 
		if(isset($_POST['event']))
		{	
			$event=$this->loadModel($_POST['event']);
			$criteria = new CDbCriteria;
			$criteria->condition = "user_id=:user_id AND event_id=:event_id";
			$criteria->params = array(':user_id'=>Yii::app()->user->id, ':event_id'=>$event->id);
			if(EventsLikes::model()->find($criteria) || $event->user_id == Yii::app()->user->id)
				return;

			$like = new EventsLikes;
      $like->user_id = Yii::app()->user->id;
      $like->event_id = $event->id;
    	if($like->save())
    	{
    		$arr = array('id'=>$event->id, 'count'=>$event->likesCount);
    		 $arr = json_encode($arr);
    		echo $arr;
    	}    		
      Yii::app()->end();
		}

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider= new CActiveDataProvider('Events', array('criteria'=>array(
				'order'=>'date DESC',
			)));
		
		foreach($dataProvider->getData() as $record)
			$record->userName = GetName::getUserTitles($record->user_id)->name;

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Events('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Events']))
			$model->attributes=$_GET['Events'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Events the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Events::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Events $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='events-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
