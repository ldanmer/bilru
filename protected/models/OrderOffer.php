<?php

class OrderOffer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderOffer the static model class
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
		return '{{order_offer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, supplier_id, work_price, material_price, duration, start_date', 'required'),
			array('order_id, supplier_id, work_price, material_price, duration', 'numerical', 'integerOnly'=>true),
			array('start_date', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, supplier_id, work_price, material_price, duration, start_date, doc_list, comment', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'User', 'supplier_id'),
			'order' => array(self::BELONGS_TO, 'Orders', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Заказ',
			'supplier_id' => 'Поставщик',
			'work_price' => 'Стоимость работ',
			'material_price' => 'Стоимость материалов',
			'duration' => 'Срок выполнения работ',
			'start_date' => 'Готов начать',
			'doc_list' => 'Документы',
			'comment' => 'Комментарий',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id)
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('supplier');
		$criteria->condition = "order_id=:id";
		$criteria->params = array(':id'=>$id);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort'=>array('attributes'=>array(
					'Стоимость работ, руб'=>array(
                'asc'=>'work_price',
                'desc'=>'work_price DESC',
            ),
					'Сроки выполнения работ'=>array(
                'asc'=>'duration',
                'desc'=>'duration DESC',
          ),
				)),
			));
	}
}