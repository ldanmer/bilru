<?php
class DefaultController extends Controller
{
	public function actionIndex()
	{
		header('Content-Type: text/html; charset=utf-8'); 
		ini_set('max_execution_time', 3600); 
		Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');	
		$uploadDir = '/files/import/';
		GetName::makeDir($uploadDir);	
		$savePath = Yii::getPathOfAlias('webroot').$uploadDir;
		$banned = array('приобретение','покупка');
 		
		$start = $this->curl_get("http://zakupki.gov.ru/pgz/public/action/search/extended/run?c0=true&a=true&c=AP&c=CW&d=&_e=on&_f=on&_g=on&h=&p0=1865&j=true&_j=on&k=&l=&m=&n=&o=RUB&i=&p=&q=&r=&r1=ETP_TEST&r1=ETP_AVK&r1=ETP_EETP&r1=ETP_SBAST&r1=ETP_RTS&r1=ETP_MMVB&s=&b8=false&t=&customer.organizationId=&letter=%D0%90&_w=on&x=&y=&_z=on&a0=&sellerOrganizationId=&b7=false&f_MP=c&f_MC=c&f_NU=c&f_OLIMPSTROI=c&b6=false&f_UG=c&f_IN=c&b9=false&a1=&a2=&a4=&a5=&a6=&a7=&b5=&a8=&_a9=on&b10=false&_complaintSearchBlock.hasComplaint=on&complaintSearchBlock.complaintNumber=&complaintSearchBlock.subjectId=&complaintSearchBlock.subject=&complaintSearchBlock.controlOrganizationId=&complaintSearchBlock.controlOrganization=&b11=false&auditResultSearchBlock.auditNumber=&auditResultSearchBlock.subjectId=&auditResultSearchBlock.subject=&auditResultSearchBlock.controlOrganizationId=&auditResultSearchBlock.controlOrganization=&_auditResultSearchBlock.hasDecision=on&auditResultSearchBlock.decisionNumber=&auditResultSearchBlock.decisionDateFrom=&auditResultSearchBlock.decisionDateTo=&lotView=false&b0=&b1=true&_b1=on&_b2=on&_b3=on&_b4=on&ext=40a75a667a1e7d80bfe91d9209fc4317");

		file_put_contents($savePath.'links.ip',$start);
		$simpleHTML = new SimpleHTMLDOM; 		

		echo "<ol>";
		if($html = $simpleHTML->file_get_html($savePath.'links.ip'))
		{
			foreach ($html->find('a[href^="/pgz/printForm?type=NOTIFICATION&id="]') as $el) 
			{
				$zakazId = substr($el->href, -7);
				$link = 'http://zakupki.gov.ru'.$el->href;
				$url = 'http://zakupki.gov.ru/pgz/public/action/orders/info/common_info/show?notificationId='.$zakazId;

				if(!Goszakaz::model()->find('link=:link', array(':link'=>$url)))
				{
					$model = new Goszakaz;
					$advert = $this->curl_get($link);		
					$model->link = $url;		

					$xml = new SimpleXMLElement($advert);
					$model->title = $xml->orderName;

					foreach ($banned as $word)
					{
						if(stripos($model->title, $word) != false)
							$model->status = 0;
					}

					$model->price = preg_replace("/\s+|((\,|\.)\d{2}$)/","",$xml->lots->lot->customerRequirements->customerRequirement->maxPrice);
					$model->start_date = strtotime($xml->createDate);
					$model->end_date = strtotime($xml->notificationCommission->p1Date);
					$model->category = $xml->lots->lot->products->product->name;
					$model->object = $xml->lots->lot->customerRequirements->customerRequirement->deliveryPlace;
					$model->customer = $xml->lots->lot->customerRequirements->customerRequirement->organization->fullName;
					$model->placement = $xml->placingWay->name;
					$model->duration = $xml->lots->lot->customerRequirements->customerRequirement->deliveryTerm;
					$model->contact = $xml->contactInfo->orgPostAddress;
					$model->phone = $xml->contactInfo->contactPhone;
					$model->email = $xml->contactInfo->contactEMail;
					$model->persona = $xml->contactInfo->contactPerson->lastName . ' ' 
													. $xml->contactInfo->contactPerson->firstName . ' '
													. $xml->contactInfo->contactPerson->middleName;					
				if($model->save())
					echo '<li style="color:#468847">'.$model->title . " - сохранено</li>";
				else
					echo '<li style="color:#b94a48">'.$model->link . " - НЕ сохранено</li>";
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