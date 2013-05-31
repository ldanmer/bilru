<?php $this->pageTitle=Yii::app()->name;?>
<div style="margin-top:50px;">
	<?php echo CHtml::image(Yii::app()->baseUrl.'/img/sand.png', '', array('align'=>'center', 'style'=>'margin-left:450px;')); ?>

	<div class="span5 pull-right" style="margin-right:100px">
		<h1 align="center" class="text-error">Мы экономим ваши время и деньги!</h1>
		<div id="enter">
			<?php 
				$this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>'Регистрация',
				    'type'=>'primary', 
				    'block'=>true,
				    'url'=>Yii::app()->user->registrationUrl,
				)); 
				$this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>'Войти',
				    'type'=>'primary', 
				    'block'=>true,
				    'url'=>Yii::app()->user->loginUrl,
				)); 
			?>
		</div>
	</div>
</div>