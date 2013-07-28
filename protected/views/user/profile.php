<?php
	$this->breadcrumbs=array(
		'Кабинет пользователя',
	);
?>
<div class="order-title">
	Профиль пользователя
</div>
<div class="order-view clearfix" id="mainprofile">
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
    <span class="pull-right">Зарегистрирован: <?php echo CHtml::encode(date("d.m.Y",strtotime($model->create_time))); ?></span>
	</div>

	<div id="maininfo" class="span4">
		<p class="header"> <?php echo CHtml::encode($model->role->role_name) ?></p> 
		<p class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo ($model->org_type_id == 1 && $model->role_id == 1 ) ? CHtml::encode($model->personalData->first_name . ' ' .$model->personalData->middle_name . ' ' . $model->personalData->last_name) : CHtml::encode($model->organizationData->org_name) ?></p>
		<?php if($model->role_id == 4): ?>
			<p class="header">Бригадир/Прораб:  
			<span class="big"><?php echo CHtml::encode($model->personalData->first_name) ?> <?php echo CHtml::encode($model->personalData->last_name) ?></span></p>
		<?php endif; ?>
		<?php if($model->role_id == 5): ?>			 
			<p class="big"><?php echo CHtml::encode($model->personalData->first_name)?> <?php echo CHtml::encode($model->personalData->middle_name) ?> <?php echo CHtml::encode($model->personalData->last_name) ?></p>
		<?php endif; ?>
		<h4>
			<span class="red">
				<?php echo CHtml::encode($model->personalData->city->city_name) ?>				
			</span>
			<span><a href="#geography" role="button" data-toggle="modal"> и другие регионы</a></span>
		</h4>
		<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData->phone1) . '; ' . CHtml::encode($model->personalData->phone2)  ?></p>
		<p><strong>Email: </strong><a href="#message" role="button" data-toggle="modal">Отправить сообщение</a></p>
		<?php if($model->role_id != 1): ?>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
			<h4>Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
		</div>				
		<div class="rating-title"><?php echo UserRating::model()->category[0] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->price ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[1] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->quality ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[2] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->delivery ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[3] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->personal ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[4] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->assortiment ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[5] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->service ?></span>
		</div>
	</div>
<div class="clearfix"></div>
	<div class="span45">		
		<h4 class="subtitle" align="center">Галерея</h4>
		<?php if($gallery): ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($gallery as $photo)
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/site/resized/76x76'.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				 ?>
			</div>			
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif ?>
		<div class="clearfix"></div>
		<h4 class="subtitle" align="center">Лицензии, сертификаты, дипломы</h4>
		<?php if(!is_null($model->userInfo->license)): ?>
			<ol class="doc-list"><?php echo GetName::getDocsList($model->userInfo->license)->list ?></ol>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</div>

	<div class="span45 pull-right">
		<div class="subtitle">
			<h4>О компании</h4>
		</div>

		<div class="rating-title">Принятых заказчиками предложений:
			<span class="red pull-right">
				<?php echo count(User::userOrdersInfo($model->id)->acceptedOffers) ?>
			</span>
		</div>
		<div class="rating-title">Всех предложений заказчикам:
			<span class="red pull-right"><?php echo User::userOrdersInfo($model->id)->offers ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Отзывов о компании', array('userRating/view', 'id'=>$model->id)) ?>:
			<span class="red pull-right"><?php echo $model->ratingCount ?></span>
		</div>
		<div class="rating-title">Лицензий, сертификатов, дипломов :
			<span class="red pull-right"><?php echo !empty($model->userInfo->license) ? count(json_decode($model->userInfo->license)) : "0"; ?></span>
		</div>
		<div class="rating-title">
			<a href="#geography" role="button" data-toggle="modal">Регионов деятельности</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo->regions) ? count(json_decode($model->userInfo->regions)) + 1 : "1"; ?></span>
		</div>		
		<div class="rating-title"><a href="#profile" role="button" data-toggle="modal">Профилей деятельности</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo->profiles) ? count(json_decode($model->userInfo->profiles)) : "0"; ?></span>
		</div>		
		<div class="rating-title"><a href="#category" role="button" data-toggle="modal">
			<?php if(GetName::getCabinetAttributes($model->id)->type == 2)
				echo "Видов работ";
			?>
			<?php if(GetName::getCabinetAttributes($model->id)->type == 3)
				echo "Категорий товаров";
			?>
		</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo->goods) ? count(json_decode($model->userInfo->goods)) : "0"; ?></span>
		</div>
		<div class="rating-title">Опыт компании (лет):
			<span class="red pull-right"><?php echo !empty($model->userInfo->age) ? $model->userInfo->age : "0"; ?></span>
		</div>
	</div>

	<?php else: ?>
	</div>	
	<div class="span45 clearfix">		
		<h4 class="subtitle" align="center">Объекты</h4>
		<?php if($objectsPhoto): ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($objectsPhoto as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/site/resized/76x76'.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				} ?>
			</div>			
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif ?>	
	</div>
	<div class="span45 pull-right">		
		<h4 class="subtitle" align="center">О компании</h4>
		<div class="rating-title">Объектов:
			<span class="red pull-right"><?php echo $model->objectCount ?></span>
		</div>
		<div class="rating-title">Размещенных заказов:
			<span class="red pull-right"><?php echo User::ordersCount($model->id) + $model->materialsCount ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Идут торги. Поиск подрядчика', '', array('id'=>'orders-show')) ?>:
			<span class="red pull-right"><?php echo User::ordersCount($model->id, 1) ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Идут торги. Поиск поставщика', '', array('id'=>'purchases-show')) ?>:
			<span class="red pull-right"><?php echo $model->materialsCountActual ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Отзывы о подрядчиках/поставщиках', array('userRating/self', 'id'=>$model->id)) ?>:
			<span class="red pull-right"><?php echo $model->ratingMadeCount ?></span>
		</div>
	</div>
<?php endif; ?>

	<div class="subtitle clearfix"><h4>Краткое описание компании</h4></div>	
		<p class="comment">
			<?php echo !empty($model->organizationData->description) ? CHtml::encode($model->organizationData->description) : "Пользователь не оставил описания."; ?>
		</p>
 	<?php if($model->role_id == 1): ?>
 	<div class="hidden" id="user-orders">
 		<div class="blue-header">Идут торги. Поиск подрядчика</div>
 		<?php 
		$this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'material-grid',
			'dataProvider'=>Orders::searchUserOrders($model->id),
			'ajaxUpdate'=>true,
			'enablePagination' => true,
			'columns'=>array(
				array('name'=>'Тип', 'value' => 'CHtml::image(Yii::app()->request->baseUrl."/img/bill.png")', 'type' => 'raw'),
				array('name' => 'Наименование заказа','type' => 'raw', 'value' => 'CHtml::link($data->title, array("orders/view", "id"=>$data["id"]))'),
				array('name' => 'Начальная цена, руб', 'value' => '$data->price != 0 ? number_format($data->price, 2, ",", " ") : "По договоренности"'),
				array('name' => 'Регион', 'value' => '$data->object->region->city_name'),
				array('name' => 'Окончание подачи заявок', 'value' => '$data["end_date"]',)
			),
			'template' => '{items}{pager}',
		));
		?>
	</div>
	<div class="hidden" id="user-purchases">
		<div class="blue-header">Идут торги. Поиск поставщика</div>
		<?php 
			$this->widget('bootstrap.widgets.TbGridView',array(
				'id'=>'material-grid',
				'dataProvider'=>MaterialBuy::searchUserPurchases($model->id),
				'ajaxUpdate'=>true,
				'enablePagination' => true,
				'columns'=>array(
					array('name'=>'Вид', 'value' => 'CHtml::image(Yii::app()->request->baseUrl.MaterialBuy::categoryImg($data->category))', 'type' => 'raw'),
					array('name' => 'Наименование покупки', 'value' => 'CHtml::link($data->title, array("materialBuy/view", "id"=>$data->id))', 'type' => 'raw'),
					array('name' => 'Доставка', 'value' => '$data->supply == 1 ? CHtml::image(Yii::app()->request->baseUrl."/img/delivery.png") : ""', 'type' => 'raw'),
					array('name' => 'Регион', 'value' => '$data->object->region->city_name'),
					array('name' => 'Срок поставки', 'value' => '$data->start_date ." - ". $data->end_date',
			      ),
				),
				'template' => '{items}{pager}',
			));

 		?>
 	</div>

	<?php endif; ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-right clearfix',
		    ),
			));
	 ?>

</div>
<?php
$this->widget('ext.fancybox.EFancyBox', array(
    'target'=>'a[rel=fancybox]',
    'config'=>array(),
    ));	
 ?>

 <!-- Регионы -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'geography')); ?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">X</a>
  <h4>Регионы деятельности</h4>
</div>

<div class="modal-body">
	<ul>
		<li><strong>Основной: <?php echo CHtml::encode($model->personalData->city->city_name) ?></strong></li>
		<?php echo GetName::jsonToString($model->userInfo->regions, GetName::getNames('Region', 'region_name'), "li"); ?>
	</ul>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>

 <!-- Профили -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'profile')); ?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">X</a>
  <h4>Профили деятельности</h4>
</div>

<div class="modal-body">
	<ul>
		<?php 
		if(!empty($model->userInfo->goods))
		{
			if(GetName::getCabinetAttributes($model->id)->type == 3)
		echo empty($model->userInfo->profiles) ? "Не указано" : GetName::jsonToString($model->userInfo->profiles, MaterialBuy::model()->categoryList, "li"); 
		}
	?>
	</ul>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>

 <!-- Категории -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'category')); ?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">X</a>
  <h4>
  	<?php if(GetName::getCabinetAttributes($model->id)->type == 2)
				echo "Виды работ";
			?>
			<?php if(GetName::getCabinetAttributes($model->id)->type == 3)
				echo "Категории товаров";
			?>
		</h4>
</div>

<div class="modal-body">
	<ul>
		<?php 
		if(!empty($model->userInfo->goods))
		{
			if(GetName::getCabinetAttributes($model->id)->type == 3)
				echo GetName::jsonToString($model->userInfo->goods, GetName::getNames('MaterialList', 'name'), "li"); 
			if(GetName::getCabinetAttributes($model->id)->type == 2)
				echo GetName::jsonToString($model->userInfo->goods, GetName::getNames('WorkTypes', 'name'), "li"); 
		}
		else
			echo "Не указано";

		?>
	</ul>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>

<?php $this->endWidget(); ?>

<!-- Контактная форма -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'message')); ?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">X</a>
  <h4>Отправить сообщение</h4>
</div>

<div class="modal-body">
	<?php $this->widget('Contact', array('email'=>$model->email)); ?>
</div> 

<?php $this->endWidget(); ?>