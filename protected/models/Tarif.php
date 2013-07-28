<?php

/**
 * This is the model class for table "{{tarifs}}".
 *
 * The followings are the available columns in table '{{tarifs}}':
 * @property integer $id
 * @property string $name
 * @property string $params
 */
class Tarif extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tarif the static model class
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
		return '{{tarifs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, params', 'required'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, params', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'params' => 'Params',
		);
	}

	public function getTarifParams()
	{
		$tarifValues = array();
		$paramNames = array();

		foreach(self::model()->findAll() as $i => $js)
		{
			$js = json_decode($js->params);
			foreach ($js as $j => $value) 
				$tarifValues[$j][$i] = $value;		
		}
		foreach (TarifParams::model()->findAll() as $key => $param)
			array_unshift($tarifValues[$key], $param->name);	
			
		return $tarifValues;
	}
}