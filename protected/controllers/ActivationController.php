<?php

class ActivationController extends Controller
{
	public function actionIndex () {
		$email = $_GET['email'];
		$activkey = $_GET['activation_string'];
		if ($email&&$activkey) {
			$find = User::model()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->active_status) {
			    $this->render('/user/message',array('content'=>"Ваш аккаунт уже был активирован."));
			} elseif(isset($find->activation_string) && ($find->activation_string==$activkey)) {
				$find->active_status = 1;
				$find->update();
			    $this->render('/user/message',array('content'=>"Ваш аккаунт активирован"));
			} else {
			    $this->render('/user/message',array('content'=>"Неверный код активации 1."));
			}
		} else {
			$this->render('/user/message',array('content'=>"Неверный код активации 2."));
		}
	}
}