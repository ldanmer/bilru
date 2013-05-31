<?php
Yii::import('zii.widgets.CPortlet');
 
class UserCabinet extends CPortlet
{
  public function init()
  {
    parent::init(); 
  }
 
  protected function renderContent()
  {
    $criteria = new CDbCriteria;
    $criteria->with = 'settings';
    $criteria->condition = "t.id=:user_id";
    $criteria->params = array(":user_id"=>Yii::app()->user->id);
    $model = User::model()->find($criteria); 
    $this->render('cabinets/view_cabinet', array('model' => $model));       
  }        
}