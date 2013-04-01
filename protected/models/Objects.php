<?php

class Objects extends CActiveRecord
{
	public $communicationTypes = array(
		'Электроснабжение','Водоснабжение', 'Канализация', 'Природный газ','Отопление'
		);
	public $work_type_id;
	public $org_type;
	public $email_check;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Objects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{objects}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, object_type_id, region_id, city_id, street, house, square, floors, user_id', 'required'),
			array('object_type_id, region_id, city_id, square, floors, user_id', 'numerical', 'integerOnly'=>true),
			array('title, street', 'length', 'max'=>255),
			array('house', 'length', 'max'=>10),
			array('photoes, blueprints, documents', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, object_type_id, photoes, blueprints, documents, region_id, city_id, street, house, square, floors, communications, user_id', 'safe', 'on'=>'search'),
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
			'objectType' => array(self::BELONGS_TO, 'ObjectTypes', 'object_type_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'orders' => array(self::HAS_MANY, 'Orders', 'object_id'),
			'goszakaz' => array(self::MANY_MANY, 'Goszakaz', 'object_id'),
			'orgType' => array(self::HAS_MANY, 'OrgType', 'org_type_id',  'through' => 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'object_type_id' => 'Тип объекта',
			'photoes' => 'Фото',
			'blueprints' => 'Чертежи',
			'documents' => 'Документы',
			'region_id' => 'Регион',
			'city_id' => 'Город',
			'street' => 'Улица',
			'house' => 'Дом',
			'square' => 'Площадь',
			'floors' => 'Этажность',
			'communications' => 'Коммуникации',
			'user_id' => 'Пользователь',
			'email_check' => 'Сохранить текущие настройки для E-mail уведомлений',
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
		$criteria->with = array('orders');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}