<?php
class Orders extends CActiveRecord
{
	public $contractorTypes = array(
		'Строительные компании', 'Проектные компании', 'Бригады', 'Индивидуальные мастера'
		);

	public $materialType = array(
			'Заказчика', 'Подрядчика', 'По договоренности'
		);

	public $categoryList = array(
			1=>'Архитектура',
			2=>'Проектирование',
			3=>'Дизайн',
			4=>'Строительство и ремонт'
		); 

	public $region_id;
	public $org_type = 2;
	public $subscribe;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orders the static model class
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
		return '{{orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_role_id, work_type_id, title, description, start_date, documents', 'required'),
			array('price, material, duration, pub_status, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('object_id','required', 'message' => 'Выберите существующий объект, либо создайте новый'),
			array('duration','required', 'message' => 'Укажите продолжительность работ'),
			array('end_date, status', 'safe'),
			array('user_role_id, work_type_id, orgType', 'safe', 'on'=>'search'),
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
			'userRole' => array(self::BELONGS_TO, 'Role', 'user_role_id'),
			'workType' => array(self::BELONGS_TO, 'WorkTypes', 'work_type_id'),
			'object' => array(self::BELONGS_TO, 'Objects', 'object_id'),
			'region' => array(self::HAS_MANY, 'Region', 'region_id',  'through' => 'object'),
			'orgType' => array(self::HAS_MANY, 'OrgType', 'org_type_id',  'through' => 'object'),
			'supplierCount'=>array(self::STAT,'OrderOffer','order_id'),
			'offer'=>array(self::BELONGS_TO, 'OrderOffer', 'offer_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_role_id' => 'Тип подрядчика',
			'work_type_id' => 'Вид работ',
			'title' => 'Наименование',
			'description' => 'Описание',
			'price' => 'Стоимость работ',
			'start_date' => 'Начало приема',
			'end_date' => 'Окончание приема',
			'duration' => 'Срок выполнения работ',
			'documents' => 'Документы',
			'object_id' => 'Объект',
			'status'=>'Статус',
			'subscribe' => 'Подпишитесь на email-рассылку по выбранным параметрам',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{		
		if(count($this->region) > 0)
		{
			foreach ($this->region as $key => $region_id)
			{
				$region_name = Region::model()->findByPk($region_id)->region_name;
				if($key > 0)
				{
					$region .= " OR obj.region_id=".$region_id;
					$contact .= " OR gos.object LIKE '%$region_name%'";
				}
					
				else
				{
					$region = "AND obj.region_id=".$region_id;
					$contact = "AND gos.object LIKE '%$region_name%'";
				}					
			}
		}

		if(count($this->work_type_id) > 0)
		{
			foreach ($this->work_type_id as $key => $work_type_id)
			{
				$category_name = WorkTypesList::model()->findByPk($work_type_id)->name;
				if($key > 0)
				{
					$category .= " OR ord.work_type_id LIKE '%$work_type_id%'";
					$gos_category .= " OR gos.category LIKE '%$category_name%'";
				}					
				else
				{
					$category = "AND ord.work_type_id LIKE '%$work_type_id%'";
					$gos_category = "AND gos.category LIKE '%$category_name%'";
				}					

			}				
		}		 						
		$gos_sql = "(SELECT gos.id, gos.title, gos.price, gos.start_date, gos.end_date, gos.object_id, gos.object 
									FROM bl_goszakaz gos 
								 	WHERE gos.status=1 $gos_category $contact
								 	ORDER BY end_date DESC
							 	)";
		$bilru_sql = "(SELECT ord.id,ord.title,ord.price,ord.start_date,ord.end_date,ord.object_id,reg.region_name
									  FROM bl_orders ord
								    INNER JOIN bl_objects obj
								    INNER JOIN bl_region reg
								    ON ord.object_id=obj.id AND obj.region_id=reg.id 
								    WHERE ord.status=0 $category $region
								    ORDER BY end_date DESC
								   )";

		if(is_array($this->org_type) && count($this->org_type) == 1)
		{
			if($this->org_type[0] == 1)
				$sql = $gos_sql;			

			if($this->org_type[0] == 3)
				$sql = $bilru_sql;	
		}
		else
			$sql = $bilru_sql." UNION ".$gos_sql. " ORDER BY end_date DESC";
		
	$rows = Yii::app()->db->createCommand($sql)->queryAll();
	$count = count($rows);

	return new CSqlDataProvider($sql, array(
			'keyField'=>'start_date',
			'totalItemCount'=>$count,
    	'pagination'=>array(
        'pageSize'=>20,
   		),
 			'sort' => array(
			'attributes' => array(
					'title'
				)
		),

		));
	}

	public function searchUserOrders($userId)
	{
		$criteria = new CDbCriteria;
		$criteria->with = "object";
		$criteria->condition = "user_id=:user_id AND offer_id=0";
		$criteria->params = array(':user_id' => $userId);
		return new CActiveDataProvider('Orders', array(
			'criteria'=>$criteria,
		));

	}

	public static function getWorkTypes($keys)
	{
		$keys = json_decode($keys);
		$workTypesList = WorkTypes::model()->findAllByPk($keys);
		foreach ($workTypesList as $value)
		{
			$string .= $value->name.", ";		
		}
		return substr($string, 0, -2);
	}

}