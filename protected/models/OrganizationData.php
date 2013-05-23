<?php
class OrganizationData extends CActiveRecord
{
		public $terms;
		public $corpus;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganizationData the static model class
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
		return '{{organization_data}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		 	array('terms',"required", 'requiredValue' => true, 'message' => 'Вы должны согласиться с условиями пользовательского соглашения'),
			array('org_name, user_id', 'required'),
			array('region_id, city_id, office, inn, kpp, bik, current_account, correspond_account, user_id', 'numerical', 'integerOnly'=>true),
			array('org_name, street, bank', 'length', 'max'=>255),
			array('house', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, org_name, region_id, city_id, street, house, office, inn, kpp, bank, bik, current_account, correspond_account, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'org_name' => 'Название организации',
			'region_id' => 'Регион',
			'city_id' => 'Город',
			'street' => 'Улица',
			'house' => 'Дом/Корпус',
			'office' => 'Офис',
			'inn' => 'ИНН',
			'kpp' => 'КПП',
			'bank' => 'Банк',
			'bik' => 'Бик',
			'current_account' => 'Расчётный счёт',
			'correspond_account' => 'Корреспондентский счёт',
			'terms' => 'Я ознакомился и принимаю условия <a data-toggle="modal" data-target="#myModal">пользовательского соглашения</a>',
			'user_id' => 'User',
			'corpus' => 'Корпус',
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
		$criteria->compare('org_name',$this->org_name,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('house',$this->house,true);
		$criteria->compare('office',$this->office);
		$criteria->compare('inn',$this->inn);
		$criteria->compare('kpp',$this->kpp);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('bik',$this->bik);
		$criteria->compare('current_account',$this->current_account);
		$criteria->compare('correspond_account',$this->correspond_account);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}