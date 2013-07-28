<?php

class MaterialBuy extends CActiveRecord
{

	public $categoryList = array(
			1=>'СТРОИТЕЛЬНЫЕ МАТЕРИАЛЫ',
			2=>'ОТДЕЛОЧНЫЕ МАТЕРИАЛЫ',
			3=>'ИНЖЕНЕРНОЕ ОБОРУДОВАНИЕ'
		);

	public $goodName;
	public $unit = array('пог. м','м2','л','м3','г','кг.','тн.','шт.','рул.','упак.','лист.','ящ.');
	public $quantity;
	public $region_id;
	public $org_type;
	public $subscribe;
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
			'subscribe' => 'Подпишитесь на email-рассылку по выбранным параметрам',
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

		if($this->region_id[0] == 'multiselect-all')
			unset($this->region_id);

		$criteria=new CDbCriteria;
		$criteria->with = array(
			"object" => array('select'=>'region_id'),
			'user' => array('select' => 'org_type_id'),
			);	
		$criteria->condition = "t.offer_id is NULL";
		
		if(!empty($this->region_id))
		{
			$regions = array();
			foreach($this->region_id as $region)
			{
				$cites = City::model()->findAll('region_id='.$region);
				foreach ($cites as $city) 
					$regions[] = $city->id;
			}
			$criteria->addInCondition("region_id",$regions);		
		}
			

		if(!empty($this->org_type))
			$criteria->addInCondition("org_type_id", $this->org_type);

		if(!empty($this->category))
			$criteria->addInCondition("category",$this->category);

		if(!empty($this->material_type))
			$criteria->addInCondition("material_type",$this->material_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchUserPurchases($userId)
	{
		
		$criteria = new CDbCriteria;
		$criteria->with = "user";
		$criteria->condition = "user_id=:user_id AND offer_id IS NULL";
		$criteria->params = array(':user_id' => $userId);
		return new CActiveDataProvider('MaterialBuy', array(
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