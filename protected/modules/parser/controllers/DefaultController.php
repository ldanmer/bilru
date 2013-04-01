<?php
class DefaultController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('admin@bilru.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		ini_set('max_execution_time', 600); 
		Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');		
 
		$start = $this->curl_get("http://zakupki.gov.ru/pgz/public/action/search/extended/rss?c0=true&a=false&b=OK&b=OA&b=EF&c=AP&d=&_e=on&_f=on&_g=on&h=&p0=1865&j=true&_j=on&k=&l=&m=&n=&o=RUB&i=03.03.2013&p=09.03.2013&q=&r=&r1=ETP_AVK&r1=ETP_EETP&r1=ETP_SBAST&r1=ETP_RTS&r1=ETP_MMVB&s=&b8=false&t=&customer.organizationId=&letter=%D0%90&_w=on&x=&y=&_z=on&a0=&sellerOrganizationId=&b7=false&f_MP=c&f_NU=c&f_OLIMPSTROI=c&b6=false&f_UG=c&f_IN=c&b9=false&a1=&a2=&a4=&a5=&a6=&a7=&b5=&a8=&_a9=on&lotView=false&b0=&b1=true&_b1=on&_b2=on&_b3=on&_b4=on&ext=1e4be2d8df7473db15343a843e16cb47");

		if($html = new SimpleXMLElement($start))
		{
			// сохраняем link-и в массив
			$links = array();
			foreach ($html->channel->item as $item)
 				$links[] = $item->link;
	
			// Начинаем прогон всех страниц
			for ($i=0; $i < count($links); $i++) { 
				// проверка на уникальность
				if(Goszakaz::model()->find("link=:link", array(":link"=>$links[$i])))
					continue;

				$model = new Goszakaz;

				// сохраняем содержимое страницы на сервер
				$uploadDir = '/files/import/';
				GetName::makeDir($uploadDir);
				$page = $this->curl_get($links[$i]);
				file_put_contents(Yii::getPathOfAlias('webroot').$uploadDir.'file.ip',$page);
				
				$simpleHTML = new SimpleHTMLDOM; 
				$html = $simpleHTML->file_get_html(Yii::getPathOfAlias('webroot').$uploadDir.'file.ip');
				
				// link
				$model->link = $links[$i];	

			 foreach ($html->find('td.orderInfoCol1') as $field)
			 {	
				// placement		 	
				if(trim($field->plaintext) == "Способ размещения заказа")
					$model->placement = $field->next_sibling(1)->plaintext;

				// title		 	
				if(trim($field->plaintext) == "Краткое наименование аукциона")
					$model->title = $field->next_sibling(1)->plaintext;

				// price		 	
				if(trim($field->plaintext) == "Начальная (Максимальная) цена контракта")
				{
					$price = filter_var($field->next_sibling(1)->plaintext,FILTER_SANITIZE_NUMBER_INT);
					$model->price = substr($price, 0, -2);
				}

				// category
				if(trim($field->plaintext) == "Классификация товаров, работ и услуг")
					$model->category = $field->next_sibling(1)->plaintext;

				// customer
				if(trim($field->plaintext) == "Организация")
					$model->customer = $field->next_sibling(1)->plaintext;

				// contact
				if(trim($field->plaintext) == "Почтовый адрес")
					$model->contact = $field->next_sibling(1)->plaintext;

				// personal contact data
				if(trim($field->plaintext) == "Контактное лицо")
				{
					$contactData = $field->next_sibling(1);
					$model->persona = $contactData->find('span.iceOutTxt',0)->plaintext;
					$model->phone = $contactData->find('span.iceOutTxt',2)->plaintext;
					$model->email = $contactData->find('a.iceOutLnk',1)->plaintext;
				}

				// object
				if(trim($field->plaintext) == "Место поставки товара, выполнения работ, оказания услуг")
					$model->object = $field->next_sibling(1)->plaintext;
					
				// duration
				if(trim($field->plaintext) == "Срок поставки товара, выполнения работ, оказания услуг (по местному времени заказчика)")
					$model->duration = $field->next_sibling(1)->plaintext;

				// start_date
				if(trim($field->plaintext) == "Дата и время окончания срока подачи заявок на участие в открытом аукционе в электронной форме")
					$model->start_date = $field->next_sibling(1)->plaintext;

				// end_date
				if(trim($field->plaintext) == "Окончание срока рассмотрения первых частей заявок")
					$model->end_date = $field->next_sibling(1)->plaintext;	 
				
				}

				if($model->save())
					echo '<p style="color:#468847">'.$model->title . " - сохранено</p>";
				else
				{
					echo '<p style="color:#b94a48">'.$model->title . " - НЕ сохранено</p>";
					continue;
				} 
			}
		}
}

	public function curl_get($host, $referer = 'http://google.com'){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_USERAGENT, "Opera/9.80 (Windows NT 5.1; U; ru) Presto/2.9.168 Version/11.51");
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 
    $html = curl_exec($ch);
    curl_error($ch);
    curl_close($ch);
    return $html;
	}
}