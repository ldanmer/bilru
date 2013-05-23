<?php

class UserSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSettings the static model class
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
		return '{{user_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('tariff, user_id', 'numerical', 'integerOnly'=>true),
			array('avatar', 'file', 'types'=>'jpg, gif, png','maxSize'=>1024*1024),			
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tariff' => 'Tariff',
			'user_id' => 'User',
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
		$criteria->compare('tariff',$this->tariff);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getThisTariff()
	{
		return self::model()->find("user_id=:user_id", array(":user_id"=>Yii::app()->user->id))->tariff;
	}

	
	public function getSettingsField($field)
	{
		$criteria = new CDbCriteria();
		$criteria->select = $field;
		$criteria->condition = 'user_id=:user_id';
		$criteria->params = array(':user_id'=>Yii::app()->user->id);
		$categories = self::model()->find($criteria);
		return $categories = json_decode($categories->$field);
	}
}