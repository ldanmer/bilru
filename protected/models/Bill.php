<?php
class Bill extends CActiveRecord
{
	public $terms = array(1=>'1 месяц',3=>'3 месяца',6=>'6 месяцев',12=>'12 месяцев');
	public $paymentList = array(0=>'Оплата по счету в безналичной форме',1=>'Онлайн');

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bills}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, date, tariff, term', 'required'),
			array('user_id, tariff, term', 'numerical', 'integerOnly'=>true),
			array('date', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, date, tariff, term', 'safe', 'on'=>'search'),
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
			'tarif' => array(self::BELONGS_TO, 'Tarif', 'tariff'),
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
			'date' => 'Date',
			'tariff' => 'Tariff',
			'term' => 'Term',
		);
	}
}