<?php

class PersonalData extends CActiveRecord
{
	public $terms;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersonalData the static model class
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
		return '{{personal_data}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, phone1, region_id, user_id', 'required'),
			array('region_id, apartament, user_id', 'numerical', 'integerOnly'=>true),
			array('first_name, middle_name, last_name, street', 'length', 'max'=>255),
			array('phone1, phone2', 'length', 'max'=>20),
			array('phone1, phone2','match','pattern'=>'/^((8|\+7|7)[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{6,10}$/'),
			array('house', 'length', 'max'=>20),
		 	array('terms',"required", 'requiredValue' => true, 'message' => 'Вы должны согласиться с условиями пользовательского соглашения'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, middle_name, last_name, phone1, phone2, region_id, street, house, apartament, user_id', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'City', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'Имя',
			'middle_name' => 'Отчество',
			'last_name' => 'Фамилия',
			'phone1' => 'Телефон',
			'phone2' => 'Дополнительный телефон',
			'region_id' => 'Регион',
			'street' => 'Улица',
			'house' => 'Дом/Корпус',
			'apartament' => 'Офис/Квартира',
			'terms'=>'<p class="text-error">Нажимая кнопку «Регистрация» Вы принимаете условия <a href="#agreement" role="button" data-toggle="modal">Пользовательского соглашения</a></p>',
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
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('house',$this->house,true);
		$criteria->compare('apartament',$this->apartament);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}