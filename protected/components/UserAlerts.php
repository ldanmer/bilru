<?php Yii::import('zii.widgets.CPortlet');
 
class UserAlerts extends CPortlet
{
	public $currentUser;

	public function init()
	{
	  parent::init(); 
		//$this->isFinishedBuy();	
		//$this->isFinishedOrder();	

		$flashMessages = Yii::app()->user->getFlashes();
		if($flashMessages)
			foreach($flashMessages as $key => $message) 
				echo "<div class=\"alert alert-$key\">
								<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>
							$message</div>";
	}

	public function isFinishedBuy()
	{
		$criteria = new CDbCriteria;
		$criteria->with = 'offer';
		$criteria->condition = "user_id=".Yii::app()->user->id." AND offer_id IS NOT NULL";
		$supply = MaterialBuy::model()->findAll($criteria); 
		$flashArray = array();	
		foreach ($supply as $value) {
			if(strtotime($value->offer->supply_date) < time()) 
			Yii::app()->user->setFlash('error',"Вы забыли оценить работу " . CHtml::link("поставщика",array(
				'materialBuy/rating',
				'id'=>$value->id,
				)
			));  	
		}   	
	}

	public function isFinishedOrder()
	{
		$criteria = new CDbCriteria;
		$criteria->with = 'offer';
		$criteria->with = 'object';
		$criteria->together = true;
		$criteria->condition = "user_id=".Yii::app()->user->id." AND offer_id IS NOT NULL";
		$supply = Orders::model()->findAll($criteria); 
		$flashArray = array();	
		foreach ($supply as $value) {
			if(strtotime($value->offer->start_date + $value->offer->duration) < time()) 
			Yii::app()->user->setFlash('error',"Вы забыли оценить работу " . CHtml::link("подрядчика",array(
				'orders/rating',
				'id'=>$value->id,
				)
			));  	
		}   	
	}


 


}