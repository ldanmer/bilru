<?php

class ByOffer extends CActiveRecord
{
	public $unsupply;
	public $supply;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ByOffer the static model class
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
		return '{{buy_offer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('offer, material_buy_id, supplier_id,supply_date', 'required'),
			array('supply', 'required', 'message'=> 'Выберите статус доставки'),
			array('material_buy_id, supplier_id, delivery', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, offer, material_buy_id, supplier_id, comment', 'safe', 'on'=>'search'),
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
			'materialBuy' => array(self::BELONGS_TO, 'MaterialBuy', 'material_buy_id'),
			'acceptedBuy' => array(self::BELONGS_TO, 'MaterialBuy', 'offer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'offer' => 'Предложение',
			'material_buy_id' => 'Material Buy',
			'supplier_id' => 'Supplier',
			'supply_date'=>'Дата поставки',
			"comment"=>'Комментарий',
			'delivery'=>'Стоимость доставки',
			'unsupply'=>'Без доставки',
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
		$criteria->condition = "material_buy_id=:id";
		$criteria->params = array(':id'=>$id);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort'=>array('attributes'=>array(
					'Стоимость, руб'=>array(
                'asc'=>'total_price',
                'desc'=>'total_price DESC',
            ),
					'Поставка, отгрузка'=>array(
                'asc'=>'supply_date',
                'desc'=>'supply_date DESC',
          ),
					'Доставка'=>array(
	          'asc'=>'delivery',
	          'desc'=>'delivery DESC',
          ),
				)),
			));
	}

	
}