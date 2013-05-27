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
				<td><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo $model->organizationData[0]->org_name; ?></td>
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
					<?php echo $model->personalData[0]->first_name .' '. $model->personalData[0]->middle_name.' '.$model->personalData[0]->last_name; ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Регион:</td>
				<td><?php echo $model->personalData[0]->region->region_name; ?></td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td><?php echo $model->personalData[0]->city->city_name; ?></td>
			</tr>	
			<tr>
				<td class="header">Фактический адрес:</td>
				<td>
					ул.<?php echo !empty($model->personalData[0]->street) ? $model->personalData[0]->street : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					д.<?php echo !empty($model->personalData[0]->house) ? $model->personalData[0]->house : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					оф.<?php echo !empty($model->personalData[0]->apartament) ? $model->personalData[0]->apartament : '<span class="text-error">НЕ УКАЗАНО</span>'; ?>
				</td>
			</tr>	
			<?php if($model->org_type_id != 1): ?>
			<tr>
				<td class="header">Юридический адрес:</td>
					<td>
					ул.<?php echo !empty($model->organizationData[0]->street) ? $model->organizationData[0]->street : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					д.<?php echo !empty($model->organizationData[0]->house) ? $model->organizationData[0]->house : '<span class="text-error">НЕ УКАЗАНО</span>'; ?> 
					оф.<?php echo !empty($model->organizationData[0]->office) ? $model->organizationData[0]->office : '<span class="text-error">НЕ УКАЗАНО</span>'; ?>
				</td>
			</tr>	
		<?php endif; ?>
			<tr>
				<td class="header">Телефон:</td>
				<td><?php echo !empty($model->personalData[0]->phone1) ? $model->personalData[0]->phone1 : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Телефон/Факс:</td>
				<td><?php echo !empty($model->personalData[0]->phone2) ? $model->personalData[0]->phone2 : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Email:</td>
				<td><?php echo $model->email; ?></td>
			</tr>				
			<tr>
				<td class="header">ИНН:</td>
				<td><?php echo !empty($model->organizationData[0]->inn) ? $model->organizationData[0]->inn : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">КПП:</td>
				<td><?php echo !empty($model->organizationData[0]->kpp) ? $model->organizationData[0]->kpp : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Банк:</td>
				<td><?php echo !empty($model->organizationData[0]->bank) ? $model->organizationData[0]->bank : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
			<td class="header">БИК:</td>
				<td><?php echo !empty($model->organizationData[0]->bik) ? $model->organizationData[0]->bik : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Расчетный счет:</td>
				<td><?php echo !empty($model->organizationData[0]->current_account) ? $model->organizationData[0]->current_account : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
			</tr>	
			<tr>
				<td class="header">Корреспондентский счет:</td>
				<td><?php echo !empty($model->organizationData[0]->correspond_account) ? $model->organizationData[0]->correspond_account : '<span class="text-error">НЕ УКАЗАНО</span>'; ?></td>
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