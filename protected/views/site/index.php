<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1 align="center" class="text-error">Мы экономим ваши время и деньги!</h1>
<div id="enter">
	<?php 
		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Регистрация',
		    'type'=>'primary', 
		    'block'=>true,
		    'url'=>Yii::app()->user->registrationUrl,
		    'size'=>'large',
		)); 
		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Войти',
		    'type'=>'primary', 
		    'block'=>true,
		    'url'=>Yii::app()->user->loginUrl,
		    'size'=>'large',
		)); 
	?>
</div>
