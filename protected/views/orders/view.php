<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	$model->title,
);

$user_info = PersonalData::model()->find('user_id=:user_id', array(':user_id' => $model->object->user_id));
$org_info = OrganizationData::model()->find('user_id=:user_id', array(':user_id' => $model->object->user_id));

if($model->documents != "null")
	$docs = GetName::getDocsList($model->documents);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти подряд', 'url'=>array('orders/search'), 'active' => true),
	        array('label'=>'Мои подряды', 'url'=>array('orderOffer/index'), 'visible'=>!Yii::app()->user->isGuest),
	        array('label'=>'Завершенные подряды', 'url'=>array('orderOffer/finished'), 'visible'=>!Yii::app()->user->isGuest),
	    ),
	)); ?>
</div>

<form class="create-form">

<legend><span>ИНФОРМАЦИЯ О ПОДРЯДЕ</span></legend>
<fieldset>
<div class="detail-order">
	<div class="span6">
		<table class="table">
			<tr>
				<td class="header">ИНФОРМАЦИЯ О ПОДРЯДЕ:</td>
				<td><?php echo $model->title; ?></td>
			</tr>
			<tr>
				<td class="header">СТОИМОСТЬ РАБОТ:</td>
				<td><?php echo $model->price == 0 ? 'По договоренности' : number_format($model->price, 2, ',', ' '); ?></td>
			</tr>
			<tr>
				<td class="header">ПРИЕМ ЗАЯВОК:</td>
				<td style="padding: 0 10px;">
					<table>
						<tr>
							<td class="header">Начало</td>
							<td><?php echo date('d.m.Y',$model->start_date); ?></td>
							<td class="header">Окончание</td>
							<td><?php echo date('d.m.Y',$model->end_date); ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="header">ВИД РАБОТ:</td>
				<td>
					<?php echo Orders::getWorkTypes($model->work_type_id); ?>
				</td>
			</tr>
			<tr>
				<td class="header">ОБЪЕКТ:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1):			
						$this->widget('bootstrap.widgets.TbButton', array(
						    'label'=>'Посмотреть профиль объекта',
						    'type'=>'btn-block',
						    'htmlOptions'=>array(
						        'data-toggle'=>'modal',
						        'data-target'=>'#alert',
						    ),
						));
						else:
						 echo CHtml::link('Посмотреть профиль объекта', array("objects/view", "id"=>$model->object->id));
						endif; 
						?>
				</td>
			</tr>
			<tr>
				<td class="header">АДРЕС ОБЪЕКТА:</td>
				<td>
					<?php echo $model->object->region->city_name ?>, 
					ул.<?php echo $model->object->street ?>, 
					д.<?php echo $model->object->house ?>
				</td>
			</tr>
			<tr>
				<td class="header">ЗАКАЗЧИК:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1):
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else: 
						if (empty($org_info->org_name))
							echo $user_info->first_name . " " . $user_info->last_name;
						else
							echo $org_info->org_name;
					endif;
					?>
				</td>
			</tr>
			<tr>
				<td class="header">СПОСОБ РАЗМЕЩЕНИЯ:</td>
				<td>
					Открытый конкурс на bilru.com
				</td>
			</tr>
			<tr>
				<td class="header">ЭТАП/СТАТУС ПОДРЯДА:</td>
				<td>
					Прием заявок
				</td>
			</tr>
			<tr>
				<td class="header">МАТЕРИАЛЫ НА ОБЪЕКТ:</td>
				<td>
					<?php echo $model->materialType[CHtml::encode($model->material)]; ?>
				</td>
			</tr>
			<tr>
				<td class="header">СРОКИ ВЫПОЛНЕНИЯ РАБОТ:</td>
				<td>
					<?php 					
					if($model->duration != 0)
						echo CHtml::encode($model->duration) . " дней"; 
					else
						echo "По договоренности"; 
						 ?>
				</td>
			</tr>
			<tr>
				<td class="header">КОНТАКТЫ:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1):
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else:
						echo $model->object->region->city_name ?>, 
						ул.<?php echo $model->object->street ?>, 
						д.<?php echo $model->object->house ?>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="header contact">Телефон:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
						echo $user_info->phone1 
					?>
				</td>
			</tr>
			<tr>
				<td class="header contact">E-mail:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
					 echo $model->object->user->email;
				  ?>
				</td>
			</tr>
			<tr>
				<td class="header contact">Контактное лицо:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
					 echo $user_info->first_name . " " . $user_info->middle_name . " " . $user_info->last_name; 
					?>
				</td>
			</tr>
			<tr>
				<td class="header">Документы:</td>
				<td>
					<ol class="doc-list"><?php echo $docs->list ?></ol>	
				</td>
			</tr>
		</table>


	<?php 
	if(UserSettings::getThisTariff() == 1):
		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Дать предложение',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'data-toggle'=>'modal',
		        'data-target'=>'#alert',
		        'class' => 'span2 pull-right',
		    ),
		));
		else:
			if(empty($already)):
				$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Дать предложение',
			    'type'=>'primary',
			    'url'=>array('orderOffer/create', 'id'=>$model->id),
			    'htmlOptions'=>array('class' => 'span2 pull-right'),
				));
			else:
				$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Мои подряды',
			    'type'=>'success',
			    'url'=>array('orderOffer/index'),
			    'htmlOptions'=>array('class' => 'span2 pull-right'),
				));
			endif;
		endif;
		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться к результатам поиска',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-left',
		    ),
		));
	?>
	</div>

	</div>
</div>
</fieldset>
</form>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'alert')); ?>
 
<div class="alert alert-error">
    Функция недоступна на тарифном плане «БАЗОВЫЙ»
</div>
 
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'already')); ?>
 
<div class="alert alert-info">
  Вы уже давали предложение к этому заказу
</div>
 
<?php $this->endWidget(); ?>