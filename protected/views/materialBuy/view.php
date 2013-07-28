<?php
$this->pageTitle=Yii::app()->name . ' - Закупка материалов';
$this->breadcrumbs=array(
	'Покупка материалов'=>array('index'),
	$model->id,
);

if(!is_null($model->doc_list))
	$docs = GetName::getDocsList($model->doc_list);

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'htmlOptions' => array('class' => 'material-list', 'method'=>'post'),
	'enableAjaxValidation'=>false,
)); 

$arrayData = $model->ordersList($model->id);
$list = array_pop($arrayData->rawData);
?>

<?php echo $form->errorSummary($offer); ?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти заказ', 'url'=>array('materialBuy/search'), 'active'=>true),
         	array('label'=>'Активные заказы', 'url'=>array('byOffer/index'), 'visible'=>!Yii::app()->user->isGuest),
	        array('label'=>'Завершенные заказы', 'url'=>array('byOffer/finished'), 'visible'=>!Yii::app()->user->isGuest),
	    ),
	)); ?>
</div>


<div class="create-form">

<legend><span>ИНФОРМАЦИЯ О Заказе</span></legend>
<fieldset>
<div class="detail-order">
	<div class="span6">
		<table class="table">
			<tr>
				<td class="header">ИНФОРМАЦИЯ О ПОДРЯДЕ:</td>
				<td><?php echo $model->title; ?></td>
			</tr>
			<tr>
				<td class="header">Срок поставки:</td>
				<td style="padding: 0 10px;">
					<table>
						<tr>
							<td class="header">Начало</td>
							<td><?php echo $model->start_date; ?></td>
							<td class="header">Окончание</td>
							<td><?php echo $model->end_date; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="header">Тип покупки:</td>
				<td><?php echo CHtml::encode($model->categoryList[$model->category]); ?></td>
			</tr>
			
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($model->type->name); ?>
				</td>
			</tr>

			<tr class="visible">
				<td class="header">ОБЪЕКТ:</td>
				<td style="padding: 0 10px;">
					<?php 
					if(UserSettings::getThisTariff() == 1):			
						$this->widget('bootstrap.widgets.TbButton', array(
						    'label'=>'Посмотреть профиль объекта',
						    'type'=>'btn-block',
			    			'size'=>'small',
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
			<tr class="visible">
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
			<tr class="visible">
				<td class="header contact">Телефон:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1):
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else: 
						if($model->show_contact==1 || $model->show_contact==2) 
							echo $model->user->personalData->phone1;
						else
							echo "Скрыт заказчиком";
					endif;
					?>
				</td>
			</tr>
			<tr class="visible">
				<td class="header contact">E-mail:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1):
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else: 
						if($model->show_contact==0 || $model->show_contact==2) 
							echo $model->user->email;
						else
							echo "Скрыт заказчиком";
					endif;
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
		<div class="text-info hide">
			Для создания предложения введите цену за единицу товара в каждой строке.  Укажите, Ваше предложение включает доставку или нет. 
		</div>

<div class="grid-view material-list">
	<table class="items table">
		<th>Наименование</th>
		<th class="span0">Ед.изм</th>
		<th class="span0">Количество</th>
		<th class="hide span0">Цена за ед.</th>
		<th class="hide span0">Сумма</th>
		<tbody id="order-list">
			<?php foreach ($arrayData->rawData as $value): ?>
			<tr>
				<td>
					<?php echo CHtml::encode($value[0]); ?>
				</td>
				<td>
					<?php echo CHtml::encode($value[1]); ?>
				</td>
				<td>
					<?php echo CHtml::encode($value[2]); ?>
				</td>
				<td class="hide">
					<input type="number" name="ByOffer[offer][]" placeholder="0" class="order-amount span0" />
				</td>
				<td class="hide sum">
					0
				</td>
			</tr>
		<?php endforeach; ?>
			<tr class="hide">
				<td colspan="4">Итого: </td>
				<td><?php echo $form->textFieldRow($offer, 'total_price', array('class'=>'span0', 'label'=>false, 'value'=>0, 'readonly'=>'readonly')); ?></td>
			</tr>
		</tbody>
	</table>
	<div class="blue-back hide pull-right">УКАЖИТЕ ДАТУ ПОСТАВКИ/ОТГРУЗКИ
		<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'model' => $offer,
					    'attribute' => 'supply_date',
					    'language' => 'ru',
					    'htmlOptions' => array(
 								'class' => 'span1',
 								'value' => date("d.m.Y"),
					    ),
						));
					?>
	</div>
	<div class="clearfix"></div>
	<div class="blue-back hide">
		<div class="pull-right" style="margin-top:8px">
			<?php echo CHtml::image(Yii::app()->request->baseUrl."/img/delivery.png") ?>
			Стоимость доставки: <?php echo CHtml::activeTextField($offer, 'delivery', array('class'=>'span1','value'=>"0",)); ?>
		</div>
		<div>
			<?php echo CHtml::image(Yii::app()->request->baseUrl."/img/undelivery.png") ?> 
			Без доставки <?php echo CHtml::activeCheckBox($offer, 'unsupply', array('style'=>'margin:-5px 50px 0 16px;')) ?>
			<br />
			<?php echo CHtml::image(Yii::app()->request->baseUrl."/img/delivery.png") ?> 
			С доставкой <?php echo CHtml::activeCheckBox($offer, 'supply', array('style'=>'margin:-5px 50px 0 20px;')) ?>
		</div>

	</div>
	<div class="hide">
		<?php echo $form->textAreaRow($offer, 'comment', array('rows'=>5, 'placeholder'=>'Здесь вы можете написать комментарий к Вашему предложению.', 'label'=>false, 'style'=>'width:630px')); ?>
	</div>
</div>
	 
	 <?php 
		if(UserSettings::getThisTariff() == 1):			
				$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Дать предложение',
			    'type'=>'btn-block',
			    'size'=>'small',
			    'htmlOptions'=>array(
		        'data-toggle'=>'modal',
		        'data-target'=>'#alert',
				    ),
					));
		elseif(Yii::app()->user->hasFlash('already')): ?>

    <div class="alert alert-error">
      <?php echo Yii::app()->user->getFlash('already'); ?>
    </div>

<?php else:
 				$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Дать предложение',
			    'type'=>'primary',
			    'size'=>'small',
			    'htmlOptions'=>array('class'=>'pull-right', 'id'=>'offer-add'),
					));
		endif; 
	?>

<?php $this->endWidget(); ?>


	<?php
	if(!empty($model->supplier_id)):	
	 $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>$model->ordersList($model->id),
  'template'=>"{items}",
  'columns'=>array(
      array('name'=>0, 'header'=>'Наименование', 'htmlOptions'=>array('class'=>'span4')),
      array('name'=>1, 'header'=>'Ед.изм', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>2, 'header'=>'Количество', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>3, 'header'=>'Цена за ед.', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>4, 'header'=>'Сумма', 'htmlOptions'=>array('class'=>'span0 sum')), 	 		 
  		),
  'htmlOptions'=>array('class'=>'material-list result-list'),
	)); 

	endif;
	?>	

			</div>
		</div>
	</div>
	</fieldset>
</div>

<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться к результатам поиска',
		    'type'=>'primary',
		    'size'=>'small',
		    'url'=>$this->createUrl('materialBuy/search'),
		    'htmlOptions'=>array(
		        'class' => 'pull-right',
		    ),
		));
 ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'alert')); ?>
 
<div class="alert alert-error">
    Функция недоступна на тарифном плане «БАЗОВЫЙ»
</div>

 
<?php $this->endWidget(); ?>
