<?php
class Zakupki extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Zakupki the static model class
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
		return '{{zakupki}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, organization, placement, price, start_date', 'required'),
			array('price, status', 'numerical', 'integerOnly'=>true),
			array('name, organization, placement', 'length', 'max'=>255),
			array('stop_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, organization, placement, price, status, start_date, stop_date', 'safe', 'on'=>'search'),
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
			'name' => 'Наименование заказа',
			'organization' => 'Организация',
			'placement' => 'Способ размещения заказа',
			'price' => 'Начальная (максимальная) цена контракта (лота)',
			'status' => 'Этап размещения заказа',
			'start_date' => 'Start Date',
			'stop_date' => 'Stop Date',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('placement',$this->placement,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('stop_date',$this->stop_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function totalPrice()
	{	
		$sql = 'SELECT SUM(price) FROM bl_zakupki';
		$connection=Yii::app()->db;		
		$command=$connection->createCommand($sql);
		$dataReader=$command->query();
		$rows=$dataReader->readAll();
		return $rows[0]['SUM(price)'];
	}
}