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
        		$role = 2;
        		break;
        	case 4:
        		$role = 3;
        		break;
        	case 5:
        		$role = 4;
        		break;
      		default:
      			$role = 5;
      			break;
        }
    	$this->render('cabinets/view_menu', array('role' => $role));
    }
}