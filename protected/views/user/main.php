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
<div class="order-title">
	Основное
</div>
<?php $this->renderPartial('_head', array('model'=>$model)); ?>
<div class="clearfix"></div>
<?php if($model->role_id != 1): ?>
	<div class="span45">
		<div class="subtitle">
			<h4>Заказы</h4>
		</div>				
		<div class="rating-title">Актуальных для вас заказов:
			<span class="red pull-right"><?php echo count(User::userOrdersInfo($model->id)->actualOrders) ?></span>
		</div>
		<div class="rating-title">Количество предложений заказчику:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->offers ?></span>
		</div>
		<div class="rating-title">Принято заказчиком:
			<span class="red pull-right"><?php echo count(User::userOrdersInfo($model->id)->acceptedOffers) ?></span>
		</div>
		<div class="rating-title">В работе:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->inWork ?></span>
		</div>
		<div class="rating-title">Выполнено:
			<span class="red pull-right"><?php echo count(User::userOrdersInfo($model->id)->acceptedOffers) - User::userOrdersInfo($model->id)->inWork ?></span>
		</div>
		<div class="rating-title">Непринятых предложений:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->offers - count(User::userOrdersInfo($model->id)->acceptedOffers) ?></span>
		</div>
	</div>
	<div class="span45 pull-right">
		<div class="subtitle">
			<h4>Активность</h4>
		</div>				
		<div class="rating-title">Ваших сообщений в ЛЕНТЕ:
			<span class="red pull-right"><?php echo $model->eventsCount ?></span>
		</div>
		<div class="rating-title">Отзывов о Вашей компании:
			<span class="red pull-right"><?php echo $model->ratingCount ?></span>
		</div>
		<div class="rating-title">Лицензий, сертификатов, дипломов :
			<span class="red pull-right"><?php echo !empty($model->userInfo->license) ? count(json_decode($model->userInfo->license)) : "0"; ?></span>
		</div>
		<div class="rating-title">Файлов в портфолио:
			<span class="red pull-right"><?php echo !empty($model->userInfo->portfolio) ? count(json_decode($model->userInfo->portfolio)) : "0"; ?></span>
		</div>
	</div>
<?php else: ?>
	<div class="span45">
		<div class="subtitle">
			<h4>Объекты</h4>
		</div>				
		<div class="rating-title">Ваших объектов:
			<span class="red pull-right"><?php echo $model->objectCount ?></span>
		</div>
		<div class="rating-title">Размещенных заказов:
			<span class="red pull-right"><?php echo User::ordersCount($model->id) + $model->materialsCount ?></span>
		</div>
		<div class="rating-title">Идут торги (прием заявок):
			<span class="red pull-right"><?php echo User::ordersCount($model->id, 1) + $model->materialsCountActual ?></span>
		</div>
		<div class="rating-title">Заказов/поставок в работе:
			<span class="red pull-right"><?php echo User::ordersCount($model->id, 2) + $model->materialsCountInWork ?></span>
		</div>
		<div class="rating-title">Завершенных заказов/поставок:
			<span class="red pull-right"><?php echo User::ordersCount($model->id, 3) + $model->materialsCountFinished ?></span>
		</div>
	</div>
	<div class="span45 pull-right">
		<div class="subtitle">
			<h4>Активность</h4>
		</div>				
		<div class="rating-title">Ваших сообщений в ЛЕНТЕ:
			<span class="red pull-right"><?php echo $model->eventsCount ?></span>
		</div>
		<div class="rating-title">Оставлено отзывов:
			<span class="red pull-right"><?php echo $model->ratingMadeCount ?></span>
		</div>
		<div class="rating-title">Файлов в портфолио:
			<span class="red pull-right"><?php echo !empty($model->userInfo->portfolio) ? count(json_decode($model->userInfo->portfolio)) : "0"; ?></span>
		</div>
	</div>
<?php endif; ?>
<div class="clearfix"></div>
<?php if($model->role_id != 1): ?>
	<div class="span45">
		<div class="subtitle">
			<h4>Деятельность</h4>
		</div>				
		<div class="rating-title">Регионов деятельности:
			<span class="red pull-right"><?php echo !empty($model->userInfo->regions) ? count(json_decode($model->userInfo->regions)) + 1 : "1"; ?></span>
		</div>		
		<div class="rating-title">Профилей деятельности:
			<span class="red pull-right"><?php echo !empty($model->userInfo->profiles) ? count(json_decode($model->userInfo->profiles)) : "0"; ?></span>
		</div>
		<div class="rating-title">
			<?php if(GetName::getCabinetAttributes()->type == 2)
				echo "Видов работ";
			?>
			<?php if(GetName::getCabinetAttributes()->type == 3)
				echo "Категорий товаров";
			?>
			<span class="red pull-right"><?php echo !empty($model->userInfo->goods) ? count(json_decode($model->userInfo->goods)) : "0"; ?></span>
		</div>
		<div class="rating-title">Сотрудников в компании:
			<span class="red pull-right"><?php echo $model->userInfo->personal; ?></span>
		</div>
	</div>
<?php else: ?>
	<div class="span45 clearfix">
		<div class="subtitle">
			<h4>Купить</h4>
		</div>				
		<div class="rating-title">Размещенные Вами заказы:
			<span class="red pull-right"><?php echo count($model->materials) ?></span>
		</div>
		<div class="rating-title">Поступило предложений:
			<div align="right"><i>строительные материалы:</i> <span class="red"><?php echo User::offersToBuy($model->id, 1) ?></span></div>
			<div align="right"><i>отделочные материалы:</i> <span class="red"><?php echo User::offersToBuy($model->id, 2) ?></span></div>
			<div align="right"><i>инженерное оборудование:</i> <span class="red"><?php echo User::offersToBuy($model->id, 3) ?></span></div>
		</div>
	</div>
<?php endif; ?>
<?php if(GetName::getCabinetAttributes()->type == 2): ?>
	<div class="span45 pull-right">
		<div class="subtitle">
			<h4>Купить</h4>
		</div>				
		<div class="rating-title">Размещенные Вами заказы:
			<span class="red pull-right"><?php echo count($model->materials) ?></span>
		</div>
		<div class="rating-title">Поступило предложений:
			<div align="right"><i>строительные материалы:</i> <span class="red"><?php echo User::offersToBuy($model->id, 1) ?></span></div>
			<div align="right"><i>отделочные материалы:</i> <span class="red"><?php echo User::offersToBuy($model->id, 2) ?></span></div>
			<div align="right"><i>инженерное оборудование:</i> <span class="red"><?php echo User::offersToBuy($model->id, 3) ?></span></div>
		</div>
	</div>
		<?php if($model->role_id != 4 && $model->role_id != 5): ?>	
		<div class="span45 pull-right clearfix">
			<div class="subtitle">
				<h4>Найти субподрядчика</h4>
			</div>				
			<div class="rating-title">Размещенные Вами заказы:
				<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->ordersCount ?></span>
			</div>
			<div class="rating-title">Поступило предложений:
				<div align="right"><i>строительные компании:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->builders ?></span></div>
				<div align="right"><i>строительные бригады:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->gangs ?></span></div>
				<div align="right"><i>индивидуальные мастера:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->masters ?></span></div>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php if($model->role_id == 1 || GetName::getCabinetAttributes()->type == 3): ?>
	<div class="span45 pull-right">
		<div class="subtitle">
			<h4>Найти подрядчика</h4>
		</div>				
		<div class="rating-title">Размещенные Вами заказы:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->ordersCount ?></span>
		</div>
		<div class="rating-title">Поступило предложений:
			<div align="right"><i>строительные компании:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->builders ?></span></div>
			<div align="right"><i>строительные бригады:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->gangs ?></span></div>
			<div align="right"><i>индивидуальные мастера:</i> <span class="red"><?php echo User::userOrdersInfo($model->id)->offersToMe->masters ?></span></div>
		</div>
	</div>	
	<?php endif; ?>

	<?php if($model->role_id == 4 || $model->role_id == 5): ?>
	<div class="span45 pull-right clearfix">
		<div class="subtitle">
			<h4>Нанять мастера</h4>
		</div>				
		<div class="rating-title">Размещенные Вами заказы:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->ordersCount ?></span>
		</div>
		<div class="rating-title">Поступило предложений:
			<span class="red pull-right"><?php 
				foreach (User::userOrdersInfo($model->id)->offersToMe as $value) 
				{
				 	$value += $value;
			 	}  
			 	echo $value;
			?></span>
	</div>	
	<?php endif; ?>


</div>

