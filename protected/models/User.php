<?php

class User extends CActiveRecord
{
	public $password_repeat;
	public $username;
	public $verifyCode;
	public $cabinetType;
	public $orderCount = 0;
	public $newPassword;
	public $newPassword_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
		$username = $this->email;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		 	array('verifyCode','captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			array('email', 'unique'),
			array('email', 'email'),
			array('password', 'compare'),
			array('newPassword', 'compare'),
			array('email, password, password_repeat, org_type_id, role_id', 'required'),
			array('org_type_id, role_id', 'numerical', 'integerOnly'=>true),
			array('email, password, newPassword', 'length', 'max'=>255),
			array('email, password, newPassword', 'length', 'min'=>6),
			array('activation_string', 'length', 'max'=>255),
			array('last_visit, password_repeat, newPassword, newPassword_repeat, create_time, activation_string, active_status', 'safe'),			
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'organizationData' => array(self::HAS_MANY, 'OrganizationData', 'user_id'),		
			'personalData' => array(self::HAS_MANY, 'PersonalData', 'user_id'),	
			'userInfo' => array(self::HAS_MANY, 'UserInfo', 'user_id'),	
			'objects' => array(self::HAS_MANY, 'Objects', 'user_id'),
			'materials' => array(self::HAS_MANY, 'MaterialBuy', 'user_id'),
			'materialsCount' => array(self::STAT, 'MaterialBuy', 'user_id'),
			'materialsCountActual' => array(self::STAT, 'MaterialBuy', 'user_id', 'condition'=>'offer_id IS NULL'),
			'materialsCountInWork' => array(self::STAT, 'MaterialBuy', 'user_id', 'condition'=>'offer_id IS NOT NULL'),
			'materialsCountFinished' => array(self::STAT, 'MaterialBuy', 'user_id', 'condition'=>'status=1'),
			'supplier' => array(self::HAS_MANY, 'ByOffer', 'supplier_id'),
			'objectCount' => array(self::STAT, 'Objects', 'user_id'),
			'offersCount' => array(self::STAT, 'OrderOffer', 'supplier_id'),
			'materialOffersCount' => array(self::STAT, 'ByOffer', 'supplier_id'),			
			'eventsCount' => array(self::STAT, 'Events', 'user_id'),
			'ratingCount' => array(self::STAT, 'UserRating', 'user_id'),
			'ratingMadeCount' => array(self::STAT, 'UserRating', 'rater_id'),
			'orgType' => array(self::BELONGS_TO, 'OrgType', 'org_type_id'),
			'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
			'rating' => array(self::HAS_MANY, 'UserRating', 'user_id'),
			'settings' => array(self::HAS_MANY, 'UserSettings', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Пароль',
			'password_repeat' => 'Подтверждение пароля', 
			'newPassword' => 'Новый пароль',
			'newPassword_repeat' => 'Подтверждение нового пароля',
			'org_type_id' => 'Организационно-правовая форма',
			'role_id' => 'Роль',
			'active_status' => 'Активный статус',
			'create_time' => 'Дата создания',
			'activation_string' => 'Строка активации',
			'last_visit' => 'Последний визит',
			'verifyCode' => 'Код проверки',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('org_type_id',$this->org_type_id);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('active_status',$this->active_status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('activation_string',$this->activation_string,true);
		$criteria->compare('last_visit',$this->last_visit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
  {
      return crypt($password,$this->password)===$this->password;
  }

  public function hashPassword($password)
  {
      return crypt($password, $this->generateSalt());
  }

	protected function generateSalt($cost=10)
	{
		if(!is_numeric($cost)||$cost<4||$cost>31){
			throw new CException(Yii::t('Cost parameter must be between 4 and 31.'));
		}
		// Get some pseudo-random data from mt_rand().
		$rand='';
		for($i=0;$i<8;++$i)
			$rand.=pack('S',mt_rand(0,0xffff));
		// Add the microtime for a little more entropy.
		$rand.=microtime();
		// Mix the bits cryptographically.
		$rand=sha1($rand,true);
		// Form the prefix that specifies hash algorithm type and cost parameter.
		$salt='$2a$'.str_pad((int)$cost,2,'0',STR_PAD_RIGHT).'$';
		// Append the random salt string in the required base64 format.
		$salt.=strtr(substr(base64_encode($rand),0,22),array('+'=>'.'));
		return $salt;
	}

	protected function afterValidate()
  {   
    parent::afterValidate();
  	if(!$this->hasErrors())
      	$this->password = $this->hashPassword($this->password);
  }

  protected function beforeSave() 
  {
    if($this->getIsNewRecord()) {
        $this->create_time = new CDbExpression('NOW()');
    }
    //$this->user_id = Yii::app()->user->id;
    return parent::beforeSave();
	}

	public static function encrypting($string="") 
	{			
		return md5($string);		
	}

	public static function sendMail($email,$subject,$message) {
  	$adminEmail = Yii::app()->params['adminEmail'];
    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
    $message = wordwrap($message, 70);
    $message = str_replace("\n.", "\n..", $message);
    return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}

	public function sendActivationString($model)
	{
		$activation_url = Yii::app()->createAbsoluteUrl('/activation/index',
			array("activation_string" => $model->activation_string, "email" => $model->email));
		$subject = "Подтверждение регистрации на сайте ".Yii::app()->name;
		$body = 'Пожалуйста, проследуйте по ссылке для подтверждения вашей регистрации: <a href="'.$activation_url.'">'.$activation_url.'</a>';				
		return $this->sendMail($model->email, $subject, $body);			
	}

	public function sendRecoveryString($user)
	{
		$activation_url = Yii::app()->createAbsoluteUrl('/site/recovery',
			array("activation_string" => $user->activation_string, "email" => $user->email));
		$subject = "Подтверждение смены пароля пользователя";
		$body = 'Пожалуйста, проследуйте по ссылке для подтверждения смены пароля: <a href="'.$activation_url.'">'.$activation_url.'</a>';				
		return $this->sendMail($user->email, $subject, $body);
	}

	// Получаем роль и заголовок на основе переменной userRole
	public function getUserAttributes($currentRole)
	{
		switch ($currentRole) {
			case '1':
				$jur = "Частное лицо";
				$title = "Заказчика";
			break;

			case '2':
				$jur = "Юридическое лицо или ИП";
				$title = "Заказчика";
			break;

			case '3':
				$jur = "Юридическое лицо или ИП";
				$title = "Строительной компании";
			break;

			case '4':
				$jur = "Юридическое лицо или ИП";
				$title = "Проектной компании";
			break;

			case '5':
				$jur = "Частное лицо";
				$title = "Бригады";
			break;

			case '6':
				$jur = "Частное лицо";
				$title = "Индивидуального мастера";
			break;

			case '7':
				$jur = "Юридическое лицо или ИП";
				$title = "Поставщика строительных материалов";
			break;

			case '8':
				$jur = "Юридическое лицо или ИП";
				$title = "Поставщика отделочных материалов";
			break;

			case '9':
				$jur = "Юридическое лицо или ИП";
				$title = "Поставщика инженерного оборудования";
			break;

			case '10':
				$jur = "Юридическое лицо или ИП";
				$title = "Поставщика оборудования и инструментов";
			break;			
			
			default:
				$jur = "Неизвестный юридический статус";
				$title = "Неизвестный тип пользователя";
				break;
		}

		$arr = new stdClass();
		$arr->title = $title;
		$arr->jur = $jur;
		return $arr;
	}

	public function userOrdersInfo($user_id)
	{
		$user = self::model()->findByPk($user_id);
		if($user)
		{
			$info = new stdClass;
			$info->actualOrders = self::getActualOrders($user);
			if(GetName::getCabinetAttributes()->type == 2)
			{
				$info->offers = $user->offersCount;
				$info->acceptedOffers = self::getAcceptedOffers($user)->all;
				$info->inWork = self::getAcceptedOffers($user)->inWork;
			}			

			if(GetName::getCabinetAttributes()->type == 3)
				$info->offers = $user->materialOffersCount;

			$info->ordersCount = self::ordersCount($user_id);
			$info->offersToMe->builders = self::offersToMe($user)->builders;
			$info->offersToMe->gangs = self::offersToMe($user)->gangs;
			$info->offersToMe->masters = self::offersToMe($user)->masters;
			$info->offersToMe->unaccepted = self::offersToMe($user)->unaccepted;
			return $info;
		}
		
	}

	// Получение актуальных заказов
	private function getActualOrders($user)
	{
		if(GetName::getCabinetAttributes()->type == 2)
		{
			$role = $user->role->id;
			$categories = UserSettings::getSettingsField("order_category");
			if(empty($categories)) 
				return array();
			else
			{
				$criteria = new CDbCriteria();
				foreach ($categories as $category) 
		    	$criteria->addSearchCondition('work_type_id',$category, true, 'OR'); 

				$criteria->addCondition('status=0');
				$criteria->addSearchCondition('user_role_id',$role);
				return $orders = Orders::model()->findAll($criteria);	
			}
		}

		if(GetName::getCabinetAttributes()->type == 3)
		{
			$category = UserSettings::getSettingsField("material_category");
			if(empty($category)) 
				return array();
			else
			{
				$criteria = new CDbCriteria();				
		    $criteria->condition('material_type='.$category); 

				$criteria->addCondition('status=0');				
				return $orders = MaterialBuy::model()->findAll($criteria);	
			}
		}
		
	
	}

	// Получение актуальных заявок на поставку материалов
	private function getActualMaterials()
	{		
		$categories = UserSettings::getSettingsField("material_category");
		if(empty($categories)) 
			return array();
		else
		{
			$criteria = new CDbCriteria();
			$criteria->addInCondition('material_type',$categories, 'OR');
			$criteria->addCondition('status=0');
			return $orders = MaterialBuy::model()->findAll($criteria);
		}
	}

	private function getAcceptedOffers($user)
	{	
		$criteria = new CDbCriteria();
		$criteria->with = 'offer';
		$criteria->condition = "supplier_id=".$user->id;
		$orders = Orders::model()->findAll($criteria);
		$inWork = 0;
		$offers = new stdClass;	

		foreach ($orders as $order) 
		{
			if($order->status == 0)
				++$inWork;
		}

		$offers->all = $orders;
		$offers->inWork = $inWork;
		return $offers;
	}

	public function ordersCount($user_id, $actual="")
	{
		$model = self::model()->findByPk($user_id);
		$count = 0;
		foreach ($model->objects as $object)
		{
			foreach ($object->orders as $order)
			{
				if($actual == 1) // идут торги
				{
					if($order->offer_id != 0)
						continue;
				}

				if($actual == 2) // подрядчик выбран, идут работы
				{
					if($order->offer_id == 0)
						continue;
				}

				if($actual == 3) // работы завершены
				{
					if($order->status != 1)
						continue;
				}				
				++$count;		
			}
	
		}

		return $count;
	}

	private function offersToMe($user)
	{		
		$sql = "SELECT offer.supplier_id, ord.offer_id
			  FROM bl_order_offer offer
		    INNER JOIN bl_objects obj
		    INNER JOIN bl_orders ord
		    ON ord.object_id=obj.id AND offer.order_id=ord.id
		    WHERE obj.user_id='$user->id'";
    $rows = Yii::app()->db->createCommand($sql)->queryAll();
		$count = new stdClass;
		$count->builders = $count->gangs = $count->masters = $count->unaccepted = 0; 

		foreach ($rows as $row) 
		{
			$user = self::model()->findByPk($row['supplier_id']);
			if($user->role_id == 2)
				++$count->builders;
			if($user->role_id == 4)
				++$count->gangs;
			if($user->role_id == 5)
				++$count->masters;
			if($row['offer_id'] == 0)
				++$count->unaccepted;
		}		

		return $count;	 
	}

	public function offersToBuy($user, $category)
	{	
		$model = self::model()->findByPk($user);
		$count = 0;	
		foreach ($model->materials as $material) 
		{
			if($material->category == $category)				
				$count += ByOffer::model()->count('material_buy_id='.$material->id);
		}

		return $count;	 
	}
	

}