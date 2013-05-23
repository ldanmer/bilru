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
	        array('label'=>'Реквизиты', 'url'=>array('user/view'), 'active'=>true),
	        array('label'=>'Деятельность', 'url'=>array('user/about')),
	    ),
	)); ?>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'orders-form',
	'htmlOptions' => array('class' => 'create-form','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<legend><span>Редактирование ИНФОРМАЦИИ о компании</span></legend>
<fieldset>
<div class="detail-order">
	<div class="span6">
		<table class="table">
			<?php if($model->role_id != 4 && $model->role_id != 5): ?>
			<tr>
				<td class="header">Организационно-правовая форма:</td>
				<td>
					<?php echo $form->dropDownListRow($model, 'org_type_id', GetName::getNames('OrgType', 'org_type_name'), array('label'=>false));?>
				</td>
			</tr>	
			<?php endif; ?>	
			<tr>
				<td class="header"> <?php 
						if($model->role_id == 4)
							echo "Название бригады";
						elseif($model->role_id == 5)
							echo "Профессия";
						else
							echo "Название компании";
				 ?>:</td>
				<td><?php echo 
					$form->textFieldRow($model->organizationData[0],'org_name', array(
						'label'=>false, 
						'placeholder' => 'Название организации',
					)); ?>
			</td>
			</tr>
			<tr>
				<td class="header">Фактический адрес</td>
				<td>
					<table>
						<tr>
							<td>
								<?php echo $form->dropDownListRow($model->personalData[0], 'region_id', GetName::getNames('Region', 'region_name')); ?>
								<?php echo $form->textFieldRow($model->personalData[0],'street'); ?>	
								<?php echo $form->textFieldRow($model->personalData[0],'house'); ?>							
							</td>
							<td>
								<?php echo $form->dropDownListRow($model->personalData[0], 'city_id', GetName::getNames('City', 'city_name')); ?>
								<?php echo $form->textFieldRow($model->personalData[0],'apartament'); ?>
							</td>
						</tr>
					</table>

				</td>
			</tr>	
			<?php if($model->role_id != 4 && $model->role_id != 5): ?>
			<tr>
				<td class="header">Юридический адрес:</td>
				<td>
					<table>
						<tr>
							<td>
								<?php echo $form->dropDownListRow($model->organizationData[0], 'region_id', GetName::getNames('Region', 'region_name')); ?>
								<?php echo $form->textFieldRow($model->organizationData[0],'street'); ?>
								<?php echo $form->textFieldRow($model->organizationData[0],'office'); ?>
							</td>
							<td>
								<?php echo $form->dropDownListRow($model->organizationData[0], 'city_id', GetName::getNames('City', 'city_name')); ?>
								<?php echo $form->textFieldRow($model->organizationData[0],'house'); ?>

							</td>
						</tr>
					</table>
				</td>
			</tr>	
		<?php endif; ?>
			<tr>
				<td class="header">Телефон:</td>
				<td>
					<?php echo $form->textFieldRow($model->personalData[0],'phone1', array('label'=>false)); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Телефон/Факс:</td>
				<td>
					<?php echo $form->textFieldRow($model->personalData[0],'phone2', array('label'=>false)); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Email:</td>
				<td><?php echo $form->textFieldRow($model,'email', array('label'=>false)); ?></td>
			</tr>	
			<tr>
				<td class="header"><?php 
						if($model->role_id == 4)
							echo "Бригадир/Прораб";
						else
							echo "Контактное лицо";
				 ?>:</td>
				<td>
					<?php echo $form->textFieldRow($model->personalData[0],'last_name'); ?>	
					<?php echo $form->textFieldRow($model->personalData[0],'first_name'); ?>		
					<?php echo $form->textFieldRow($model->personalData[0],'middle_name'); ?>	
				</td>
			</tr>	
			<tr>
				<td class="header">Банковские реквизиты:</td>
				<td>
					<?php echo $form->textFieldRow($model->organizationData[0],'inn'); ?>	
					<?php echo $form->textFieldRow($model->organizationData[0],'kpp'); ?>		
					<?php echo $form->textFieldRow($model->organizationData[0],'bank'); ?>	
					<?php echo $form->textFieldRow($model->organizationData[0],'bik'); ?>	
					<?php echo $form->textFieldRow($model->organizationData[0],'current_account'); ?>		
					<?php echo $form->textFieldRow($model->organizationData[0],'correspond_account'); ?>	
				</td>
			</tr>	
			
		</table>
	</div>
</div>
</fieldset>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Сохранить',
		'htmlOptions' => array('class' => 'pull-right'),
	)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'url'=>array('site/changepassword'),
		'type'=>'primary',
		'label'=>'Сменить пароль',
		'htmlOptions' => array('class' => 'clearfix'),
	)); ?>
<?php $this->endWidget(); ?>