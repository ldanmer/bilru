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
	        array('label'=>'Деятельность', 'url'=>array('user/about'),'visible' =>!($model->role_id == 1 && $model->org_type_id == 1)),
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
					$form->textFieldRow($model->organizationData,'org_name', array(
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
								<?php echo $form->dropDownListRow($model->personalData, 'region_id', Region::model()->getRegionsList(), array(
									'label'=>false, 
									'empty' => '- выберите регион -',
								)); ?>
								<?php echo $form->textFieldRow($model->personalData,'street'); ?>	
								<?php echo $form->textFieldRow($model->personalData,'house'); ?>							
							</td>
							<td>
								<?php echo $form->textFieldRow($model->personalData,'apartament'); ?>
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
								<?php echo $form->dropDownListRow($model->organizationData, 'region_id', GetName::getNames('Region', 'region_name')); ?>
								<?php echo $form->textFieldRow($model->organizationData,'street'); ?>
								<?php echo $form->textFieldRow($model->organizationData,'office'); ?>
							</td>
							<td>
								<?php echo $form->textFieldRow($model->organizationData,'house'); ?>

							</td>
						</tr>
					</table>
				</td>
			</tr>	
		<?php endif; ?>
			<tr>
				<td class="header">Телефон:</td>
				<td>
					<?php echo $form->textFieldRow($model->personalData,'phone1', array('label'=>false)); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Телефон/Факс:</td>
				<td>
					<?php echo $form->textFieldRow($model->personalData,'phone2', array('label'=>false)); ?>
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
					<?php echo $form->textFieldRow($model->personalData,'last_name'); ?>	
					<?php echo $form->textFieldRow($model->personalData,'first_name'); ?>		
					<?php echo $form->textFieldRow($model->personalData,'middle_name'); ?>	
				</td>
			</tr>	
			<tr>
				<td class="header">Банковские реквизиты:</td>
				<td>
					<?php echo $form->textFieldRow($model->organizationData,'inn'); ?>	
					<?php echo $form->textFieldRow($model->organizationData,'kpp'); ?>		
					<?php echo $form->textFieldRow($model->organizationData,'bank'); ?>	
					<?php echo $form->textFieldRow($model->organizationData,'bik'); ?>	
					<?php echo $form->textFieldRow($model->organizationData,'current_account'); ?>		
					<?php echo $form->textFieldRow($model->organizationData,'correspond_account'); ?>	
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