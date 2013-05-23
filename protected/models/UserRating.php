<?php

class UserRating extends CActiveRecord
{
	public $category = array('Цена', 'Качество товаров', 'Доставка', 'Персонал','Ассортимент', 'Сервис');
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserRating the static model class
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
		return '{{user_rating}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, rater_id, review, rating', 'required'),
			array('user_id, rater_id', 'numerical', 'integerOnly'=>true),
			array('review', 'length', 'allowEmpty'=>false, 'min'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, rater_id, review, rating', 'safe', 'on'=>'search'),
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
			'rater' => array(self::BELONGS_TO, 'User', 'rater_id'),
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
			'user_id' => 'User',
			'rater_id' => 'Rater',
			'review' => 'Ваш отзыв',
			'rating' => 'Рейтинг',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('rater_id',$this->rater_id);
		$criteria->compare('review',$this->review,true);
		$criteria->compare('rating',$this->rating,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}