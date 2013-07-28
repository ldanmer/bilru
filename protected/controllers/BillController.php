<?php

class BillController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $defaultAction = 'create';

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
			array('allow', 
				'actions'=>array('create', 'pdf'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionCreate()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if($user->org_type_id != 1 && isset($_GET['tarif']) && isset($_GET['term']))
		{	
			$bill = new Bill;
			$bill->user_id = $user->id;
			$bill->tariff = $_GET['tarif'];
			$bill->date = time();
			$bill->term = $_GET['term'];
			$bill->mode = $_GET['mode'];
			$bill->sum = 1200*$_GET['term'];
			if($bill->save())
			{
				$org_name = $user->orgType->org_type_name . ' ' . $user->organizationData->org_name;
				$this->render('index',array('bill'=>$bill));	
			}			
		}		
	}

	public function actionPdf()
	{
		$bill = Bill::model()->find('user_id='.Yii::app()->user->id.' order by id desc');
		$mPDF1 = Yii::app()->ePdf->mpdf();        
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.min.css');
    $mPDF1->WriteHTML($stylesheet, 1); 
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/styles.css');
    $mPDF1->WriteHTML($stylesheet, 1); 
    $mPDF1->WriteHTML($this->renderPartial('bill-template',array('bill'=>$bill), true)); 
    $mPDF1->Output();
	}

	public function loadModel($id)
	{
		$model=Bill::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
