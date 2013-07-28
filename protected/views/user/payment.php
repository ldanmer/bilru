<?php $this->breadcrumbs=array('Кабинет пользователя');?>
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
		<div class="order-title">
			Кабинет пользователя
		</div>

		<div class="order-view clearfix" id="payment">
			<div class="span1">
				<?php if(!empty($model->settings->avatar)): 
				$avatar = json_decode($model->settings->avatar);
				?>
		    <?php $this->widget('ext.SAImageDisplayer', array(
        'image' => str_replace('/images/originals/', '', $avatar[0]),
        'size' => 'middle',
    )); ?>
			<?php else: ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
		<?php endif; ?>
	</div>
	<div id="maininfo" class="span6">
		<span class="pull-right">Зарегистрирован: <?php echo CHtml::encode(date("d.m.Y",strtotime($model->create_time))); ?></span>
		<p class="header"> <?php echo CHtml::encode($model->role->role_name) ?></p> 
		<p class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo ($model->org_type_id == 1 && $model->role_id == 1 ) ? CHtml::encode($model->personalData->first_name . ' ' .$model->personalData->middle_name . ' ' . $model->personalData->last_name) : CHtml::encode($model->organizationData->org_name) ?></p>
		<?php if($model->role_id == 4): ?>
		<p class="header">Бригадир/Прораб:  
			<span class="big"><?php echo CHtml::encode($model->personalData->first_name) ?> <?php echo CHtml::encode($model->personalData->last_name) ?></span></p>
		<?php endif; ?>
		<?php if($model->role_id == 5): ?>			 
		<p class="big"><?php echo CHtml::encode($model->personalData->first_name)?> <?php echo CHtml::encode($model->personalData->middle_name) ?> <?php echo CHtml::encode($model->personalData->last_name) ?></p>
		<?php endif; ?>
		<div class="span3a">
		 	<table class="table info">
		 		<tr>
		 			<td colspan="2" class="header" style="text-align:center"><strong>СЛЕДУЮЩИЙ ПЛАТЕЖ</strong></td>
		 		</tr>
		 		<tr>
		 			<td class="header">Минимальная сумма</td>
		 			<td style="font-size:15px;text-align:center"><?php echo number_format($model->settings->tarif->price, 2, ',', ' ') ?> руб.</td>
		 		</tr>
		 		<tr>
		 			<td class="header">Не позднее</td>
		 			<td style="font-size:15px;text-align:center"><?php echo ($model->settings->tarif->price != 0) ? date('d.m.Y', $model->settings->tariff_start) : '-'?></td>
		 		</tr>
		 	</table>
	 	</div>
	 	<div class="span3a pull-right">
		 	<table class="table info">
		 		<tr>
		 			<td class="header" style="text-align:center"><strong>ВАШ ТАРИФНЫЙ ПЛАН</strong></td>
		 		</tr>
		 		<tr>
		 			 <td style="text-align:center" class="dark-green"><h3><?php echo $model->settings->tarif->name ?></h3></td>
		 		</tr>
		 	</table>
	 	</div>
	</div>
	<div id="payment-info">
		<ul class="nav nav-tabs">
		  <li><a href="#payment-act" data-toggle="tab">Оплата</a></li>
		  <li class="active"><a href="#tariffs" data-toggle="tab">Тарифные планы</a></li>
		  <li><a href="#payment-history" data-toggle="tab">История платежей</a></li>	  
		</ul>

		<div class="tab-content">
		  <div class="tab-pane" id="payment-act">
			<?php 
				$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(			    
			    'id' => 'payment-form',	 
			    'htmlOptions'=>array('method '=>'get'),  
				)); ?>
			<table class="items table" id="tarif-choose">
				<tr>
					<th colspan="2">Выберите тарифный план</th>
				</tr>
				 <?php 				 
				 echo $form->radioButtonListRow($model->settings, 'tariff', CHtml::listData(Tarif::model()->findAll(), 'id', 'name'), array(
				 	'template'=>'<tr><td>{label}</td><td class="dark-blue">{input}</td></tr>', 
				 	'label'=>false,
		    	'ajax' => array(
		    		'type'=> 'POST',
		        'url' => $this->createUrl('user/TarifUpdate'),
		        'data' => new CJavaScriptExpression('"tarifVal="+this.value'),		
		        'update' =>'#refresh'        
		    		),
		    	'return' => true,
				 )); ?>				
			</table>			
			<table class="items table" id="payment-term" style="margin-bottom:0">
				<tr>
					<th width="200">Выберите сумму</th>
					 <?php echo CHtml::radioButtonList('term', '', Bill::model()->terms, array(
					 'template'=>'<th class="text-center" width="100">{input}</th>', 
					 'label'=>false,
					 'separator'=>'',
					 )); ?>	
				</tr>
			</table>	
			<div id="refresh">
				<?php $this->renderPartial('_payment'); ?>				 	
			</div>	
			<div id="result">
				<?php $this->renderPartial('_payment2',array('model'=>$model)); ?>				 	
			</div>
			<div class="pull-right" id="fucking-idiocy">
				<?php 
				if(count($emptyFields) > 0)
					$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'success',
						'label'=>'Перейти',
						'htmlOptions' => array('data-toggle'=>'modal','data-target'=>'#details'),
					)); 
				else
					$this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'type'=>'success',
						'label'=>'Перейти',						
					)); 
				?>
			</div>
			<?php $this->endWidget(); ?>
		  </div>
		  <div class="tab-pane active material-list" id="tariffs">
		  	<table class="items table">
		  		<tr>
		  			<th></th>
		  			<?php foreach (Tarif::model()->findAll() as $tarif): ?>
		  			<th><?php echo $tarif->name ?></th>
		  			<?php endforeach; ?>
		  		</tr>
		  		<?php foreach (Tarif::getTarifParams() as $param): ?>
		  		<tr>
		  			<?php foreach($param as $val): ?>
		  			<td>
		  				<?php 
			  				if(is_numeric($val))
			  				{
			  					if($val == 1)
			  						$val = '<h3 class="dark-green">+</h3>';
			  					else
			  						$val = '<h3 class="red">-</h3>';
			  				}
		  					echo $val;
		  				?>
		  			</td>
		  			<?php endforeach; ?>
		  		</tr>
		  		<?php endforeach; ?>		  		
		  	</table>
			<a href="#payment-act" data-toggle="tab" class="btn btn-success pull-right">Сменить тариф</a>
		  </div>
		  <div class="tab-pane material-list" id="payment-history">
		  	<table class="items table">
		  		<tr>
		  			<th>Способ оплаты</th>
		  			<th>Сумма</th>
		  			<th>Дата зачисления</th>
		  		</tr>
		  		<?php foreach($model->bills as $bill): ?>
		  			<tr>
		  				<td><strong><?php echo $bill->mode ?></strong></td>
		  				<td class="text-center"><?php echo $bill->sum ?> руб.</td>
		  				<td class="text-center"><?php echo date('d.m.Y',$bill->date) ?></td>
		  			</tr>
		  		<?php endforeach; ?>
		  	</table>
		  </div>
		</div>
	</div>
</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'details')); ?>
	<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'detailsForm',
    'type'=>'horizontal',   
	)); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h4>Мы не можем выставить счет, так как у вас не заполнены следующие реквизиты:</h4>
</div>
 
<div class="modal-body">
	<div id="error" class="text-error"></div>

		<?php 
			foreach ($emptyFields as $field)
				echo $form->textFieldRow($model->organizationData, $field, array()); 
		?>	  
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Сохранить',
        'buttonType'=>'ajaxSubmit',
        'url'=>array('user/detailsEdit'),  
  			'ajaxOptions'=>array(
					'type'=>'POST',					
					'success'=>'function(data){	
						var data = $.parseJSON(data);								
							if(data.status == "error")
								$("#error").html(data.message);
							else
							{
								$(".close").click();
								$("#payment-form").submit();
							}		
					}'
				),      
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Отмена',        
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'base-trans')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">x</a>
    <h4>Вы уверены, что хотите перейти на тарифный план "Базовый"?</h4>
</div>
 
<div class="modal-body">	
	Переход на тарифный план "Базовый" будет осуществлен по завершении оплаченного периода действующего тарифа 
	"<?php echo $model->settings->tarif->name; ?>"	
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Сохранить',
        'buttonType'=>'ajaxSubmit',
        'url'=>array('user/detailsEdit'),  
  			'ajaxOptions'=>array(
					'type'=>'POST',					
					'success'=>'function(data){	
						var data = $.parseJSON(data);								
							if(data.status == "error")
								$("#error").html(data.message);
							else
							{
								$(".close").click();
								$("#payment-form").submit();
							}		
					}'
				),      
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Отмена',        
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
<?php $this->endWidget(); ?>
