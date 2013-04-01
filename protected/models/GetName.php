<?php
class GetName extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	

	// Получение списка ролей
	public static function getNames($class_name, $name_field)
	{
		$names = array();
		$fields = $class_name::model()->findAll();		
		foreach ($fields as $field) {
			$names[$field->id] = $field->$name_field;
		}
		return $names;
	}

	public static function getUserTitles($id)
	{	
		$userAttributes = new stdClass();
		$user = User::model()->findByPk($id);
		if($user->org_type_id == 1)
      $userInfo = PersonalData::model()->find('user_id=?',array($id));
    else
      $userInfo = OrganizationData::model()->find('user_id=?',array($id));
      
    $userAttributes->region = $userInfo->region->region_name;

    if(!empty($userInfo->org_name))
    {   
        $userAttributes->name = $userInfo->org_name;
        $userAttributes->orgType = $user->orgType->org_type_name;            
    }  
    else 
    {   
        $userAttributes->name = $userInfo->first_name . " " . $userInfo->last_name;
        $userAttributes->orgType = "Частное лицо";
    }   
    return $userAttributes;
	}

	// Сохранение загруженных файлов
	public static function saveUploadedFiles($fieldName, $uploadDir)
	{
		$files = CUploadedFile::getInstancesByName($fieldName);
		$absoluteDir = Yii::getPathOfAlias('webroot') . $uploadDir . "/";
		$uploadDir .= "/";
    if (isset($files) && count($files) > 0) {
    	$docs = array();
    	foreach ($files as $pic) {
    		$fileName = self::translit($pic->name);
    		$pic->saveAs($absoluteDir.$fileName);
        $docs[] = $uploadDir.$fileName;        
	    }
	  }

	  return json_encode($docs);
	}

	public function jsonToString($jsonKeys, $searchArray, $divider = ", ")
	{
		if(!empty($jsonKeys)){
			$keys = array_flip(json_decode($jsonKeys));
			$resultString = implode($divider,array_intersect_key($searchArray,$keys));
			return $resultString;
		}
		else
			return "";

	}

	public function getImage($fileName)
	{
		$imgArray = array('jpg', 'jpeg', 'png', 'gif');
		$ext = strtolower(self::getExtension($fileName));
		if(array_search($ext, $imgArray))
			return true;
	}

	// Список документов
	public function getDocsList($json)
	{
		$docs = json_decode($json);	
		$list = "";
		$docsObject =  new stdClass();
		foreach ($docs as $doc) {
			$substring = substr($doc, strripos($doc, '/') + 1);
			$list .= "<li><a href=".Yii::app()->baseUrl.$doc." target=\"_blank\">$substring</a></li>";
			if(self::getImage(Yii::app()->baseUrl.$doc))
				$docsObject->img = Yii::app()->baseUrl.$doc;
		}
		$docsObject->list = $list;
		return $docsObject;			
	}




	/* Private methods */

	private function translit($str){
    $alphavit = array(
    "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e",
    "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", "м"=>"m",
    "н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
    "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh",
    "ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya",
    "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E", "Ё"=>"Yo",
    "Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L","М"=>"M",
    "Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y",
    "Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh",
    "Ы"=>"I","Э"=>"E","Ю"=>"U","Я"=>"Ya",
    "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"", " "=> "-", "'"=>"","_"=>"-", "`"=>""
    );
    return strtr($str, $alphavit);
	}

	private function getExtension($filename) {
    return $path_info = pathinfo($filename,PATHINFO_EXTENSION);
  }

  public static function makeDir($dirPath)
  {
		if(!is_dir(Yii::getPathOfAlias('webroot').$dirPath))
		{
	 		mkdir(Yii::getPathOfAlias('webroot').$dirPath);
	 		chmod(Yii::getPathOfAlias('webroot').$dirPath, 0755); 
		}	
  }

	// Получаем рейтинг юзера
  public function getRating($user_id)
  {
  	$ratingValues = new stdClass;

  	$criteria = new CDbCriteria;
  	$criteria->select = 'rating';
  	$criteria->condition = 'user_id=:user_id';
  	$criteria->params = array(':user_id'=>$user_id);
  	$rating = UserRating::model()->findAll($criteria);
  	$ratingCount = UserRating::model()->count($criteria);
  	if($ratingCount > 0)
  	{
	  	$sumInner = 0;
	  	$sumOuter = 0;
	  	$price = 0;
	  	$quality = 0;
	  	$delivery = 0;
	  	$personal = 0;
	  	$assortiment = 0;
	  	$service = 0;
	  	foreach ($rating as $currRecord) 
	  	{
	  		$currRecord = json_decode($currRecord->rating);
	  		foreach ($currRecord as $key=>$value) 
	  		{
	  			switch ($key) 
	  			{
	  				case 0:
	  					$price += $value;
	  					break;
	  				case 1:
	  					$quality += $value;
	  					break;
  					case 2:
	  					$delivery += $value;
	  					break;
	  				case 3:
	  					$personal += $value;
	  					break;
	  				case 4:
	  					$assortiment += $value;
	  					break;
	  				case 5:
	  					$service += $value;
	  					break;	  				
	  				default:	  					
	  					break;
	  			}
	  			$sumInner += $value; 
	  		}
	  		$sumOuter += round(($sumInner / 6), 1);
	  	}
	  	$ratingValues->averageRating = round(($sumOuter/$ratingCount), 1);
	  	$ratingValues->count = $ratingCount;	 
	  	$ratingValues->price 				= round(($price/$ratingCount), 1);
	  	$ratingValues->quality 			= round(($quality/$ratingCount), 1);
	  	$ratingValues->delivery 		= round(($delivery/$ratingCount), 1);
	  	$ratingValues->personal 		= round(($personal/$ratingCount), 1);
	  	$ratingValues->assortiment 	= round(($assortiment/$ratingCount), 1);
	  	$ratingValues->service	   	= round(($service/$ratingCount), 1);	  		
  	}
  	else
		{
			$ratingValues->averageRating= 0;
			$ratingValues->count 				= 0;
			$ratingValues->price 				= 0;
	  	$ratingValues->quality 			= 0;
	  	$ratingValues->delivery 		= 0;
	  	$ratingValues->personal 		= 0;
	  	$ratingValues->assortiment 	= 0;
	  	$ratingValues->service	   	= 0;	  	
		}
  	return $ratingValues;
  }

	// Получение конкретного рейтинга и отзыва
  public function getThisRating($id)
  {
  	$thisRating = new stdClass;
  	$rating = UserRating::model()->findByPk($id);
  	if(!empty($rating))
  	{
	  	$sum = 0;
	  	foreach (json_decode($rating->rating) as $value) 
	  		$sum += $value;
	  	$thisRating->rating = round(($sum/6), 1);
	  	$thisRating->review = $rating->review;
  	}
  	else
  	{
  		$thisRating->rating = 0;
  		$thisRating->review = "";
  	}
  	return $thisRating;
  }

}