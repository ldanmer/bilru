<?php

class MaterialBuy extends CActiveRecord
{

	public $categoryList = array(
			1=>'СТРОИТЕЛЬНЫЕ МАТЕРИАЛЫ',
			2=>'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ',
			3=>'ИНЖЕНЕРНОЕ ОБОРУДОВАНИЕ'
		);

	public $goodName;
	public $unit = array('шт.', 'упак.', 'кг.');
	public $quantity;
	public $email_check;
	public $region_id;
	public $org_type;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaterialBuy the static model class
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
		return '{{material_buy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date, end_date, category, material_type, order_list, title', 'required'),
			array('object_id, category, material_type, supply, show_contact', 'numerical', 'integerOnly'=>true),
			array('object_id','required', 'message' => 'Выберите существующий объект, либо создайте новый'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, object_id, start_date, end_date, category, material_type, supply, show_contact, doc_list, order_list', 'safe', 'on'=>'search'),
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
			'object' => array(self::BELONGS_TO, 'Objects', 'object_id'),
			'type' => array(self::BELONGS_TO, 'MaterialList', 'material_type'),
			'supplier' => array(self::HAS_MANY, 'ByOffer', 'material_buy_id'),
			'supplierCount'=>array(self::STAT,'ByOffer','material_buy_id'),
			'offer'=>array(self::BELONGS_TO, 'ByOffer', 'offer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'object_id' => 'Объект',
			'start_date' => 'Начало поставки',
			'end_date' => 'Окончание поставки',
			'category' => 'Тип покупки',
			'material_type' => 'Вид покупки',
			'supply' => 'Только с доставкой',
			'show_contact' => 'Контакты',
			'doc_list' => 'Список документов',
			'order_list' => 'Перечень заказа',
			'email_check' => 'Сохранить текущие настройки для E-mail уведомлений',
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
		$criteria->with = "object";
		$criteria->with = "user";
		$criteria->together = true;
		$criteria->condition = "t.offer_id IS NULL";
		if(!empty($this->region_id))
		{
			$criteria->condition = "region_id=:region_id";
			$criteria->params = array(":region_id"=>$this->region_id);
		}
		if(!empty($this->org_type))
		{
			$criteria->condition = "org_type_id=:org_type";
			$criteria->params = array(":org_type"=>$this->org_type);
		}
		if(!empty($this->category))
		{
			$criteria->condition = "category=:category";
			$criteria->params = array(":category"=>$this->category);
		}
		if(!empty($this->material_type))
		{
			$criteria->condition = "material_type=:material_type";
			$criteria->params = array(":material_type"=>$this->material_type);
		}


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function ordersList($id,$offerId="")
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('supplier'=>array('select'=>'supplier.offer,supplier.total_price'));
		$criteria->together = true;
		$criteria->select=array('order_list');  
		$criteria->condition='t.id=:id';
		$criteria->params=array(':id'=>$id);
		if(!empty($offerId))
			$criteria->addCondition('supplier.id='.$offerId);

		$list = self::model()->find($criteria);
		$order = json_decode($list->order_list);
		$offer = json_decode($list->supplier[0]->offer);

		$res = array();
		foreach ($order as $key=>$value) {
			/*if(array_key_exists(3, $value))
			{
				$value[4] = $value[2] * $value[3];
				$amount += $value[4]; 				
			}*/

			if(!empty($offer[$key]))
			{
				$value[3] = $offer[$key];
				$value[4] = $value[2] * $value[3];	
				$amount = $list->supplier[0]->total_price;
			}
					
			$res[] = $value;
			$key +=1;
		}		
	/*
	* Если кто-то еще когда-нибудь увидит этот код, знайте, что я так делал потому, что меня сильно 
	* подгоняли и не давали время на рефакторинг, а тем более, на тестирование.
	*/
	// Через ЖОПУ расширяем массив на единицу и через НЕЕ же вписываем итоговую сумму в таблицу
		$res[$key] = array();
		array_push($res[$key], 'Итого:', '','','',$amount); 

		return new CArrayDataProvider($res);
	}

	public function categoryImg($category)
	{
		switch ($category) {
			case '1':
				return '/img/stroy_mat.png';
				break;
			case '2':
				return '/img/otdel_mat.png';
				break;
			case '3':
				return '/img/engen_mat.png';
				break;

		}
	}

}