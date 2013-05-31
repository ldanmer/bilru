<div class="user-form register-form" id="registration-form">

<h3 class="form-title">Регистрация</h3>
<p class="muted text-center" style="margin-top: 10px; margin-bottom:0">Выберите основной тип пользователя</p>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'enableAjaxValidation'=>false,
	'method' => 'get',
)); ?>
<fieldset>
	<div class="row">
		<div class="span3">
			<h4 class="type-title">Заказчик</h4>
	   	<label class="radio">
		  	<input type="radio" name="userRole" value="1" checked>
			  Частное лицо
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="2">
       	Юридическое лицо, ИП 
			</label>
		</div>

		<div class="span3">
			<h4 class="type-title">Строитель</h4>
	   	<label class="radio">
		  	<input type="radio" name="userRole" value="3">
			  Строительная компания
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="4">
 	     	Проектная компания
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="5">
       	Бригада 
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="6">
 	     	Индивидуальный мастер
			</label>
		</div>

		<div class="span3">
			<h4 class="type-title">Поставщик</h4>
	   	<label class="radio">
		  	<input type="radio" name="userRole" value="7">
			   Строительных материалов
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="8">
       	Отделочных материалов
			</label>
	   	<label class="radio">
		  	<input type="radio" name="userRole" value="9">
			  Инженерного оборудования 
			</label>
			<label class="radio">
		  	<input type="radio" name="userRole" value="10">
       	Оборудования и инструментов
			</label>
		</div>
	</div>
</fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Далее',
			'block'=>true,
			'htmlOptions' => array('class'=>'pull-right span2', 'name'=>''),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
</div>