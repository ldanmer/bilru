<?php Yii::import('zii.widgets.CPortlet');
 
class UserAlerts extends CPortlet
{
    public $currentUser;

    public function init()
    {
      parent::init(); 
     	$this->isFinishedBuy();	
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


 


}