<?php
Yii::import('zii.widgets.CPortlet');
 
class UserMenu extends CPortlet
{
    public function init()
    {
      parent::init();
    }
 
    protected function renderContent()
    {
        $currentUser = User::model()->findByPk(Yii::app()->user->id);
        $userRole = $currentUser->role_id;
        switch ($userRole) {
        	case 1:
        		$role = 1;
        		break;
        	case 2:
        	case 3:
        	case 4:
        	case 5:
        		$role = 2;
        		break;
          case 6:
          case 7:
          case 8:
          case 9:
            $role = 3;
            break;
          default:
          $role = 4;          
        }
    	$this->render('cabinets/view_menu', array('role' => $role));
    }
}