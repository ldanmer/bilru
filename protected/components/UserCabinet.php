<?php
Yii::import('zii.widgets.CPortlet');
 
class UserCabinet extends CPortlet
{
    public $currentUser;

    public function init()
    {
      parent::init();
      $this->currentUser = User::model()->findByPk(Yii::app()->user->id);     
    }
 
    protected function renderContent()
    {

        $userAttributes = $this->currentUser ? $this->cabinetMenuList() : "";

    	$this->render('cabinets/view_cabinet', array(
            'type' => $type, 
            'userAttributes' => $userAttributes,
            ));       
    }

    protected function cabinetMenuList()
    {
        $currentUserAttributes = new stdClass();  
        $currentUserAttributes->title = $this->cabinetAttributes->title;
        $cabinetType = $this->cabinetAttributes->type;

        // Поля поставщика услуг
        if($cabinetType != 1)
        {
            $currentUserAttributes->rating = "10.25";
            $currentUserAttributes->questions = '26';
        }
        else
            // Ответы заказчикам
            $currentUserAttributes->answers = "12";  

        // Оборудование у строителей
        if($cabinetType == 2) 
            $currentUserAttributes->equipment = "12";                    


        // Общее число заказов
        $currentUserAttributes->orders->total = $this->currentUser->orderCount;

        // Заказы для поставщиков
        if($cabinetType == 3)
        {
            $currentUserAttributes->orders->fizlitsa = 59;
            $currentUserAttributes->orders->company = 28;
            $currentUserAttributes->orders->gang = 34;
            $currentUserAttributes->orders->workers = 74;
        }
            
        // Число объектов
        $currentUserAttributes->objects = $this->currentUser->objectCount;
        // Предложения
        if($cabinetType != 3 && $this->currentUser->role_id != 5)
        {
            if($this->currentUser->role_id != 4)
            {
                $currentUserAttributes->offers->company = "28";
                $currentUserAttributes->offers->gang = "34";
            }
            $currentUserAttributes->offers->workers = "74";
         }

        // Поставка
         if($cabinetType != 3)
         {
            $currentUserAttributes->supply->materials = "12";
            $currentUserAttributes->supply->finish = "43";      
            $currentUserAttributes->supply->engineer = "9";     
         } 
        

        $currentUserAttributes->region = GetName::getUserTitles($this->currentUser->id)->region;
        $currentUserAttributes->name = GetName::getUserTitles($this->currentUser->id)->name;
        $currentUserAttributes->orgType = GetName::getUserTitles($this->currentUser->id)->orgType;
        

        /*
        if(!empty($userInfo->org_name))
        {   
            $currentUserAttributes->name = $userInfo->org_name;
            $currentUserAttributes->orgType = $this->currentUser->orgType->org_type_name;            
        }
        // поля Физ.Лица   
        else 
        {   
            $currentUserAttributes->name = $userInfo->first_name . " " . $userInfo->last_name;
            $currentUserAttributes->orgType = "Частное лицо";
        }     
        */
        return $currentUserAttributes;
    }

    public function getCabinetAttributes()
    {   
        $cabinetType;
        $currentUser = User::model()->findByPk(Yii::app()->user->id);
        $userRole = $currentUser->role_id;
        switch ($userRole) {
            case 1:
                $cabinetType = 1;
                $cabinetTitle = "Заказчика";
                break;
            case 2:
            case 3:
            case 4:
            case 5:
                $cabinetType = 2;
                $cabinetTitle = "Строителя";
                break;
            case 6:
            case 7:
            case 8:
            case 9:
                $cabinetType = 3;
                $cabinetTitle = "Поставщика";
                break;
            
            default:
                $cabinetType = false;
                break;
        }

        $cabinetAttributes = new stdClass();
        $cabinetAttributes->type = $cabinetType;
        $cabinetAttributes->title = $cabinetTitle;

        return $cabinetAttributes;
    }
}