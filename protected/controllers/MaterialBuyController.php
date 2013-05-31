<?php

class MaterialBuyController extends Controller
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
				'actions'=>array('create','update','index','view', 'search','finished', 'rating'),
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
		$offer = new ByOffer;	
		$isNew = ByOffer::model()->find('supplier_id=:user_id AND material_buy_id=:this_id', array(
			':user_id'=>Yii::app()->user->id,
			':this_id'=>$id,
			));

		if(!empty($isNew))
			Yii::app()->user->setFlash('already',"Вы уже дали свое предложение");

		if(isset($_POST['ByOffer']['offer']))
		{
			foreach ($_POST['ByOffer']['offer'] as $value)
				$sum += $value;
			if($sum != 0)
			{
				$offer->offer = json_encode($_POST['ByOffer']['offer']);
				$offer->material_buy_id = $id;
				$offer->supplier_id = Yii::app()->user->id;
				$offer->supply_date = $_POST['ByOffer']['supply_date'];
				if(isset($_POST['ByOffer']['delivery']))
					$offer->delivery = $_POST['ByOffer']['delivery'];
				if(isset($_POST['ByOffer']['comment']))
					$offer->comment = $_POST['ByOffer']['comment'];
				if(!empty($_POST['ByOffer']['total_price']))
					$offer->total_price = $_POST['ByOffer']['total_price'];

				if($_POST['ByOffer']['unsupply'] == 0 && $_POST['ByOffer']['supply'] == 0)
					$offer->supply = false;
				if($_POST['ByOffer']['unsupply'] == 1 || $_POST['ByOffer']['supply'] == 1)
					$offer->supply = true;	

				if($_POST['ByOffer']['unsupply'] == 1)
					$offer->delivery = null;

				if($offer->save())
					Yii::app()->user->setFlash('success',"Предложение сохранено");
			}
			else
				Yii::app()->user->setFlash('error',"Стоимость не может равняться нулю");

		}

		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'offer'=>$offer,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MaterialBuy;

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

		$uploadDir = '/files/docs_upload/'.Yii::app()->user->id;

			if(!is_dir(Yii::getPathOfAlias('webroot').$uploadDir)) {
	   		mkdir(Yii::getPathOfAlias('webroot').$uploadDir);
	   		chmod(Yii::getPathOfAlias('webroot').$uploadDir, 0755); 
			}	

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaterialBuy']))
		{
			$model->attributes=$_POST['MaterialBuy'];
			$model->user_id = Yii::app()->user->id;
			$model->doc_list = GetName::saveUploadedFiles('documents',$uploadDir);	

			// Показ контактов
			if(!empty($_POST['MaterialBuy']['show_contact']))
			{	// 0 - email, 1 - телефон, 2 - email + телефон, 3 - ничего
				$model->show_contact = $_POST['MaterialBuy']['show_contact'][0];
				if(isset($_POST['MaterialBuy']['show_contact'][0]) && isset($_POST['MaterialBuy']['show_contact'][1]))
					$model->show_contact = 2;
			}

			// Список заказов
			if(!empty($_POST['MaterialBuy']['goodName']))
			{
				// удалить пустые элементы массива
				$goods = array_filter($_POST['MaterialBuy']['goodName'],function($el){ return !empty($el);});

				$orderList = array();
				$i = 0;
				while($i < count($goods))
				{	
					$orderList[$i] = array($goods[$i], $_POST['MaterialBuy']['unit'][$i], $_POST['MaterialBuy']['quantity'][$i]);
					++$i;
				}
				if(!empty($orderList))
				{
					$orderList = json_encode($orderList);
					$model->order_list = $orderList;
				}
					
			}							

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
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['MaterialBuy']))
		{
			$model->attributes=$_POST['MaterialBuy'];
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
	 * Lists active models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('offer');
		$criteria->condition='user_id='.Yii::app()->user->id.' AND status=0';
		$dataProvider=new CActiveDataProvider('MaterialBuy', array('criteria'=>$criteria));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Lists finished models.
	 */
	public function actionFinished()
	{
		$criteria=new CDbCriteria;
		$criteria->with=array('offer');
		$criteria->condition='user_id='.Yii::app()->user->id.' AND status=1';
		$dataProvider=new CActiveDataProvider('MaterialBuy', array('criteria'=>$criteria));
		$this->render('finished',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Search all models.
	 */
	public function actionSearch()
	{
		$model=new MaterialBuy('search');
		$model->unsetAttributes();  // clear any default values
		
		// Регион
		if(isset($_GET['MaterialBuy']['region_id']))
			$model->region_id=$_GET['MaterialBuy']['region_id'];

		// Тип заказчика
		if(isset($_GET['MaterialBuy']['org_type']))
			$model->org_type=$_GET['MaterialBuy']['org_type'];

		// Тип
		if(isset($_GET['MaterialBuy']['category']))
			$model->category=$_GET['MaterialBuy']['category'];

		// Категория
		if(isset($_GET['MaterialBuy']['material_type']))
			$model->material_type=$_GET['MaterialBuy']['material_type'];

		$this->render('search',array(
			'model'=>$model,
		));
	}

	public function actionRating($id)
	{
		$rating=new UserRating;
		$status=MaterialBuy::model()->findByPk($id);		
		$model=ByOffer::model()->find("material_buy_id=:id", array(":id"=>$id));

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
		$model=MaterialBuy::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='material-buy-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
