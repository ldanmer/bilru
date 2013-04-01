<?php

class User extends CActiveRecord
{
	public $password_repeat;
	public $username;
	public $verifyCode;
	public $cabinetType;
	public $orderCount = 0;

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
			array('email, password, password_repeat, org_type_id, role_id', 'required'),
			array('org_type_id, role_id', 'numerical', 'integerOnly'=>true),
			array('email, password', 'length', 'max'=>255),
			array('email, password', 'length', 'min'=>6),
			array('activation_string', 'length', 'max'=>255),
			array('last_visit, password_repeat, create_time, activation_string, active_status', 'safe'),			
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
			'settings' => array(self::HAS_MANY, 'UserSettings', 'user_id'),		
			'orders' => array(self::HAS_MANY, 'Orders', 'user_id'),
			'materials' => array(self::HAS_MANY, 'MaterialBuy', 'user_id'),
			'supplier' => array(self::HAS_MANY, 'ByOffer', 'supplier_id'),
			'objectCount' => array(self::STAT, 'Objects', 'user_id'),
			'orgType' => array(self::BELONGS_TO, 'OrgType', 'org_type_id'),
			'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
			'rating' => array(self::HAS_MANY, 'UserRating', 'user_id'),
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

}