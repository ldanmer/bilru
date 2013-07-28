<?php
class DefaultController extends Controller
{
	public function actionIndex()
	{
		$users =  User::model()->findAll();
		foreach ($users as $user) 
		{
			if(!is_null($user->settings->order_subscribe))
			{
				$orderSetting = CJSON::decode($user->settings->order_subscribe);

				$orders=new Orders('search');		
				$orders->unsetAttributes();  

				if($orderSetting['org_type'])
					$orders->org_type=$orderSetting['org_type'];
			
				// Регион
				if($orderSetting['region_id'])
					$orders->region=$orderSetting['region_id'];

				// Тип работ
				if($orderSetting['work_type_id'])
					$orders->work_type_id=$orderSetting['work_type_id'];

				$message = new YiiMailMessage;
				$message->view = 'orders';
				$message->setBody(array('model'=>$orders), 'text/html');
				$message->subject = 'Новые заказы на сайте Bilru.com';
				$message->addTo($user->email);
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);					
			}		

			if(!is_null($user->settings->material_subscribe))
			{
				$materialSetting = CJSON::decode($user->settings->material_subscribe);

				$materials=new MaterialBuy('search');		
				$materials->unsetAttributes();  

				if(isset($materialSetting['region_id']))
					$materials->region_id=$materialSetting['region_id'];

				// Тип заказчика
				if(isset($materialSetting['org_type']))
					$materials->org_type=$materialSetting['org_type'];

				// Тип
				if(isset($materialSetting['category']))
					$materials->category=$materialSetting['category'];

				// Категория
				if(isset($materialSetting['material_type']))
					$materials->material_type=$materialSetting['material_type'];

				$message = new YiiMailMessage;
				$message->view = 'materials';
				$message->setBody(array('model'=>$materials), 'text/html');
				$message->subject = 'Новые покупки на сайте Bilru.com';
				$message->addTo($user->email);
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);					
			}					
		}
	}
}