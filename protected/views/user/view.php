<?php
	$this->breadcrumbs=array(
		'Кабинет пользователя',
	);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Основное', 'url'=>array('user/main')),
	        array('label'=>'Реквизиты', 'url'=>array('user/view')),
	        array('label'=>'Деятельность', 'url'=>array('user/about'),'visible' =>!($model->role_id == 1 && $model->org_type_id == 1)),
	        array('label'=>'Кабинет', 'url'=>array('user/payment'),'visible' =>!($model->role_id == 1 && $model->org_type_id == 1))

	    ),
	)); ?>
</div>

<form class="create-form">
<legend><span>Реквизиты компании</span></legend>
<fieldset>
<div class="detail-order">
	<div class="span6">
		<table class="table">
			<?php if($model->role_id != 1 && $model->org_type_id != 1): ?>
			<tr>
				<td class="header">
					<?php 
						if($model->role_id == 4)
							echo "Бригада";
						elseif($model->role_id == 5)
							echo "Мастер";
						else
							echo "Компания";
				 ?>
				</td>
				<td><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo $model->organizationData->org_name; ?></td>
			</tr>	
			<?php endif; ?>
			<tr>
				<td class="header">
					<?php 
						if($model->role_id == 4)
							echo "Бригадир/Прораб";
						elseif($model->role_id == 5 || ($model->role_id == 1 && $model->org_type_id == 1))
							echo "Ф.И.О.";
						else
							echo "Контактное лицо";
				 ?>:
				</td>
				<td>
					<?php echo $model->personalData->first_name .' '. $model->personalData->middle_name.' '.$model->personalData->last_name; ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Регион:</td>
				<td><?php echo $model->personalData->city->region->region_name; ?></td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td><?php echo $model->personalData->city->city_name; ?></td>
			</tr>	
			<tr>
				<td class="header">Фактический адрес:</td>
				<td>
					ул.<?php echo !empty($model->personalData->street) ? $model->personalData->street : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					д.<?php echo !empty($model->personalData->house) ? $model->personalData->house : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					оф.<?php echo !empty($model->personalData->apartament) ? $model->personalData->apartament : '<span class="text-error">НЕ УКАЗАНО</span>'; ?>
				</td>
			</tr>	
			<?php if($model->org_type_id != 1): ?>
			<tr>
				<td class="header">Юридический адрес:</td>
					<td>
					ул.<?php echo !empty($model->organizationData->street) ? $model->organizationData->street : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					д.<?php echo !empty($model->organizationData->house) ? $model->organizationData->house : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					оф.<?php echo !empty($model->organizationData->office) ? $model->organizationData->office : '<span class="text-error">НЕ УКАЗАНО</span>'; ?>
				</td>
			</tr>	
		<?php endif; ?>
			<tr>
				<td class="header">Телефон:</td>
				<td><?php echo !empty($model->personalData->phone1) ? $model->personalData->phone1 : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Телефон/Факс:</td>
				<td><?php echo !empty($model->personalData->phone2) ? $model->personalData->phone2 : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Email:</td>
				<td><?php echo $model->email; ?></td>
			</tr>				
			<tr>
				<td class="header">ИНН:</td>
				<td><?php echo !empty($model->organizationData->inn) ? $model->organizationData->inn : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">КПП:</td>
				<td><?php echo !empty($model->organizationData->kpp) ? $model->organizationData->kpp : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Банк:</td>
				<td><?php echo !empty($model->organizationData->bank) ? $model->organizationData->bank : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
			<td class="header">БИК:</td>
				<td><?php echo !empty($model->organizationData->bik) ? $model->organizationData->bik : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Расчетный счет:</td>
				<td><?php echo !empty($model->organizationData->current_account) ? $model->organizationData->current_account : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Корреспондентский счет:</td>
				<td><?php echo !empty($model->organizationData->correspond_account) ? $model->organizationData->correspond_account : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
		</table>
	</div>
</div>
</fieldset>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'url'=>array('user/update'),
		'type'=>'primary',
		'label'=>'Редактировать информацию',
		'htmlOptions' => array('class' => 'pull-right'),
	)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Сменить пароль',
	    'type'=>'primary',
	    'htmlOptions'=>array(
	        'data-toggle'=>'modal',
	        'data-target'=>'#change-password',
	    ),
	)); ?>
</form>

 <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'change-password')); ?>
 <div class="modal-header">
    <a class="close" data-dismiss="modal">Х</a>
    <h4>Смена пароля</h4>
</div>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
	)); ?>
<div class="modal-body">
			<?php echo $form->passwordFieldRow($model,'password',array(
				'maxlength'=>60,
				'label'=>false, 
				'value' => false,
				'placeholder' => 'Текущий пароль'
			)); ?>

		<?php echo $form->passwordFieldRow($model,'newPassword',array(
				'maxlength'=>60,
				'label'=>false, 
				'value' => false,
				'placeholder' => 'Новый пароль'
			)); ?>

		<?php echo $form->passwordFieldRow($model,'newPassword_repeat',array(
				'maxlength'=>60,
				'label'=>false, 
				'placeholder' => 'Подтверждение пароля'
		)); ?>
		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->captchaRow($model,'verifyCode',array(
					'label'=>false, 
	        'placeholder'=>'Введите код проверки...',
      	)); ?>
		<?php endif; ?>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('name' => 'save'),			
	)); ?>
</div>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>