<?php
Yii::import('zii.widgets.CPortlet');
 
class UserCabinet extends CPortlet
{
    public $currentUser;

    public function init()
    {
      parent::init();
      $criteria = new CDbCriteria;
      $criteria->with = 'settings';
      $criteria->condition = "t.id=:user_id";
      $criteria->params = array(":user_id"=>Yii::app()->user->id);
      $this->currentUser = User::model()->find($criteria);     
    }
 
    protected function renderContent()
    {
        $user = $this->cabinetMenuList();
    	$this->render('cabinets/view_cabinet', array('user' => $user));       
    }

    protected function cabinetMenuList()
    {
        $userAttribute = new stdClass();  
        $userAttribute->title = GetName::getCabinetAttributes()->title;
        $cabinetType = GetName::getCabinetAttributes()->type;

        // Поля поставщика услуг
        if($cabinetType != 1)
        {
            $userAttribute->rating = GetName::getRating(Yii::app()->user->id)->averageRating;
            /* TODO: количество вопросов */
            $userAttribute->questions = '0';
        }
        else
            // Ответы заказчикам
            /* TODO: количество ответов */
            $userAttribute->answers = "0";  

        // Оборудование у строителей
        /* TODO: закупка оборудования */
        if($cabinetType == 2) 
            $userAttribute->equipment = "0";                  

        // Общее число заказов
        $userAttribute->orders->total = $this->currentUser->orderCount;

        // Заказы для поставщиков
        if($cabinetType == 3)
        {
            $userAttribute->orders->fizlitsa = 0;
            $userAttribute->orders->company = 0;
            $userAttribute->orders->gang = 0;
            $userAttribute->orders->workers = 0;
        }
            
        // Число объектов
        $userAttribute->objects = $this->currentUser->objectCount;
        // Предложения
        if($cabinetType != 3 && $this->currentUser->role_id != 5)
        {
            if($this->currentUser->role_id != 4)
            {
                $userAttribute->offers->company = User::userOrdersInfo($this->currentUser->id)->offersToMe->builders;
                $userAttribute->offers->gang = User::userOrdersInfo($this->currentUser->id)->offersToMe->gangs;
            }
            $userAttribute->offers->workers = User::userOrdersInfo($this->currentUser->id)->offersToMe->masters;
         }

        // Поставка
         if($cabinetType != 3)
         {
            $userAttribute->supply->materials = User::offersToBuy($this->currentUser->id, 1);
            $userAttribute->supply->finish = User::offersToBuy($this->currentUser->id, 2);      
            $userAttribute->supply->engineer = User::offersToBuy($this->currentUser->id, 3);     
         } 
        

        $userAttribute->region = GetName::getUserTitles($this->currentUser->id)->region;
        $userAttribute->name = GetName::getUserTitles($this->currentUser->id)->name;
        $userAttribute->orgType = GetName::getUserTitles($this->currentUser->id)->orgType;
        $userAttribute->avatar = $this->currentUser->settings[0]->avatar;

        return $userAttribute;
    }

    
}