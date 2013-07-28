<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property integer $id
 * @property string $city_name
 * @property integer $region_id
 *
 * The followings are the available model relations:
 * @property Region $region
 * @property OrganizationData[] $organizationDatas
 * @property PersonalData[] $personalDatas
 */
class City extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return City the static model class
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
		return '{{city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_name, region_id', 'required'),
			array('region_id', 'numerical', 'integerOnly'=>true),
			array('city_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, city_name, region_id', 'safe', 'on'=>'search'),
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
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'city_name' => 'City Name',
			'region_id' => 'Region',
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
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('region_id',$this->region_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}