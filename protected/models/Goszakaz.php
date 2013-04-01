<?php

class Goszakaz extends CActiveRecord
{
	public $region;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Goszakaz the static model class
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
		return '{{goszakaz}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, link', 'required'),
			array('link','unique'),
			array('category', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, price, start_date, end_date, category, object, customer, placement, duration, contact, phone, email, persona, docs, link, region', 'safe', 'on'=>'search'),
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
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'price' => 'Price',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'category' => 'Work Type',
			'object' => 'Object',
			'customer' => 'Customer',
			'placement' => 'Placement',
			'duration' => 'Duration',
			'contact' => 'Contact',
			'phone' => 'Phone',
			'email' => 'Email',
			'persona' => 'Persona',
			'docs' => 'Docs',
			'link' => 'Link',
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
		$regionName = Region::model()->findByPk($this->region)->region_name;
		$workType = WorkTypes::model()->findByPk($this->category)->name;
		$criteria=new CDbCriteria;

		if(!empty($regionName))
			$criteria->addSearchCondition('contact', $regionName);

		if(!empty($workType))
			$criteria->addSearchCondition('category', $workType);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function totalPrice()
	{
		$values = self::model()->findAll('price');
		$sum = 0;
		foreach ($values as $value) 
			$sum += $value->price;
		return $sum;
	}
}