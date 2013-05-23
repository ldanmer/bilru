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
		header('Content-Type: text/html; charset=utf-8'); 
		ini_set('max_execution_time', 3600); 
		Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');	
		$uploadDir = '/files/import/';
		GetName::makeDir($uploadDir);	
		$savePath = Yii::getPathOfAlias('webroot').$uploadDir.'file.ip';
		$banned = array('приобретение','покупка');
 		
		$start = $this->curl_get("http://zakupki.gov.ru/pgz/public/action/rss/order/extended/search?c0=true&a=false&b=OK&b=OA&b=EF&c=AP&d=&_e=on&_f=on&_g=on&h=&p0=1865&j=true&_j=on&k=&l=&m=&n=&o=RUB&i=&p=&q=&r=&s=&b8=false&t=&customer.organizationId=&letter=%D0%90&_w=on&x=&y=&_z=on&a0=&sellerOrganizationId=&b7=false&f_MP=c&f_MC=c&f_NU=c&f_OLIMPSTROI=c&b6=false&f_UG=c&f_IN=c&b9=false&a1=&a2=&a4=&a5=&a6=&a7=&b5=&a8=&_a9=on&b10=false&_complaintSearchBlock.hasComplaint=on&complaintSearchBlock.complaintNumber=&complaintSearchBlock.subjectId=&complaintSearchBlock.subject=&complaintSearchBlock.controlOrganizationId=&complaintSearchBlock.controlOrganization=&b11=false&auditResultSearchBlock.auditNumber=&auditResultSearchBlock.subjectId=&auditResultSearchBlock.subject=&auditResultSearchBlock.controlOrganizationId=&auditResultSearchBlock.controlOrganization=&_auditResultSearchBlock.hasDecision=on&auditResultSearchBlock.decisionNumber=&auditResultSearchBlock.decisionDateFrom=&auditResultSearchBlock.decisionDateTo=&lotView=false&b0=&_b1=on&_b2=on&_b3=on&_b4=on&ext=cd54487489e21b42f6d1ac7c88f22748");
		echo "<ol>";
		if($html = new SimpleXMLElement($start))
		{
			// сохраняем link-и в массив
			$links = array();
			foreach ($html->channel->item as $item)
 				$links[] = $item->link;

			// Начинаем прогон всех страниц
			foreach ($links as $link) { 
				// проверка на уникальность
				if(Goszakaz::model()->find("link=:link", array(":link"=>$link)))
					continue;

				$model = new Goszakaz;

				// сохраняем содержимое страницы на сервер			
				$page = $this->curl_get($link);
				file_put_contents($savePath,$page);
				
				$simpleHTML = new SimpleHTMLDOM; 
				$html = $simpleHTML->file_get_html($savePath);
				
				// link
				$model->link = $link;	

			 foreach ($html->find('td.orderInfoCol1') as $field)
			 {	
				// placement		 	
				if(trim($field->plaintext) == "Способ размещения заказа")
					$model->placement = $field->next_sibling(1)->plaintext;

				// title		 	
				if(trim($field->plaintext) == "Краткое наименование аукциона")
					$model->title = $field->next_sibling(1)->plaintext;

				// Поиск запрещенных слов
				foreach ($banned as $word)
				{
					if(stripos($model->title, $word) != false)
						$model->status = 0;
				}

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
					echo '<li style="color:#468847">'.$model->title . " - сохранено</li>";
				else
				{
					echo '<li style="color:#b94a48">'.$model->link . " - НЕ сохранено</li>";
					continue;
				} 
			}
		}
		echo "</ol>";
}

	public function curl_get($host)
	{
    $ch = curl_init($host); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $html = $this->curl_exec_follow($ch);
    return $html;
	}

	protected function curl_exec_follow($ch, &$maxredirect = null) 
	{

  $user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5)".
                " Gecko/20041107 Firefox/1.0";
  curl_setopt($ch, CURLOPT_USERAGENT, $user_agent );

  $mr = $maxredirect === null ? 5 : intval($maxredirect);

  if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
    curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  } else {
    
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

    if ($mr > 0)
    {
      $original_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
      $newurl = $original_url;
      
      $rch = curl_copy_handle($ch);
      
      curl_setopt($rch, CURLOPT_HEADER, true);
      curl_setopt($rch, CURLOPT_NOBODY, true);
      curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
      do
      {
        curl_setopt($rch, CURLOPT_URL, $newurl);
        $header = curl_exec($rch);
        if (curl_errno($rch)) {
          $code = 0;
        } else {
          $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
          if ($code == 301 || $code == 302) {
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $newurl = trim(array_pop($matches));
            
            // if no scheme is present then the new url is a
            // relative path and thus needs some extra care
            if(!preg_match("/^https?:/i", $newurl)){
              $newurl = $original_url . $newurl;
            }   
          } else {
            $code = 0;
          }
        }
      } while ($code && --$mr);
      
      curl_close($rch);
      
      if (!$mr)
      {
        if ($maxredirect === null)
        trigger_error('Too many redirects.', E_USER_WARNING);
        else
        $maxredirect = 0;
        
        return false;
      }
      curl_setopt($ch, CURLOPT_URL, $newurl);
    }
  }
 	 return curl_exec($ch);
	}
}