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
	        array('label'=>'Деятельность', 'url'=>array('user/about')),
	    ),
	)); ?>
</div>
<div class="order-title">
	Основное
</div>
<div class="order-view clearfix" id="mainprofile">
	<div class="span1">
  	<?php if(!empty($model->settings[0]->avatar)): ?>
      <?php echo CHtml::image(Yii::app()->baseUrl.$model->settings[0]->avatar); ?>
    <?php else: ?>
      <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
    <?php endif; ?>
		<span class="pull-right">Зарегистрирован: <?php echo CHtml::encode(date("d.m.Y",strtotime($model->create_time))); ?></span>
	</div>

	<div id="maininfo" class="span4">
		<p class="header"> <?php echo CHtml::encode($model->role->role_name) ?>: 
		<span class="big"><?php echo CHtml::encode($model->organizationData[0]->org_name) ?></span></p>
		<?php if($model->role_id == 4): ?>
			<p class="header">Бригадир/Прораб:  
			<span class="big"><?php echo CHtml::encode($model->personalData[0]->first_name) ?> <?php echo CHtml::encode($model->personalData[0]->last_name) ?></span></p>
		<?php endif; ?>
		<?php if($model->role_id == 5): ?>			 
			<p class="big"><?php echo CHtml::encode($model->personalData[0]->first_name), CHtml::encode($model->personalData[0]->middle_name), CHtml::encode($model->personalData[0]->last_name) ?></p>
		<?php endif; ?>
		<div class="tarif light-blue light-blue-border clearfix">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Изменить',
			    'type'=>'info',
			     'size'=>'small',
			     'url'=>array('#'),
			    'htmlOptions' => array('class'=>'pull-right')
			)); ?>
		Тарифный план 
			<span class="big"><?php echo UserSettings::getThisTariff() == 0 ? "Базовый" : "Vip"; ?></span>
		</div>
		<p class="green margin-top">Вашу компанию рекомендовало <span class="red"><?php echo GetName::getRating($model->id)->count ?></span> пользователей</p>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
			<h4>Мой Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
		</div>				
		<div class="rating-title"><?php echo $model->rating[0]->category[0] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->price ?></span>
		</div>
		<div class="rating-title"><?php echo $model->rating[0]->category[1] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->quality ?></span>
		</div>
		<div class="rating-title"><?php echo $model->rating[0]->category[2] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->delivery ?></span>
		</div>
		<div class="rating-title"><?php echo $model->rating[0]->category[3] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->personal ?></span>
		</div>
		<div class="rating-title"><?php echo $model->rating[0]->category[4] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->assortiment ?></span>
		</div>
		<div class="rating-title"><?php echo $model->rating[0]->category[5] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->service ?></span>
		</div>
	</div>
<div class="clearfix"></div>
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
		<!--
		<div class="rating-title">Загруженных/созданных прайс-листов:
			<span class="red pull-right"><?php echo !empty($model->userInfo->price) ? count(json_decode($model->userInfo->price)) : "0"; ?></span>
		</div>-->
	</div>
<div class="clearfix"></div>
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
			<span class="red pull-right"><?php echo !empty($model->userInfo->personal) ? $model->userInfo->personal : "0"; ?></span>
		</div>
	</div>
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
	<?php if(GetName::getCabinetAttributes()->type == 3): ?>
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
		<div class="rating-title clearfix">Непринятых предложений:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->offersToMe->unaccepted ?></span>
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

