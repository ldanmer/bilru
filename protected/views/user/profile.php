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
		<h4>
			<span class="red">
				<?php echo CHtml::encode($model->personalData[0]->region->region_name) ?>				
			</span>
			<span><a href="#geography" role="button" data-toggle="modal"> и другие регионы</a></span>
		</h4>
		<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData[0]->phone1) . '; ' . CHtml::encode($model->personalData[0]->phone2)  ?></p>
		<p><strong>Email: </strong><?php echo CHtml::mailto($model->email) ?></p>
		<p class="green margin-top">
			<img src="<?php echo Yii::app()->baseUrl ?>/img/finger-up.png" class="pull-left" />
		Эту компанию рекомендовало 
			<span class="red"><?php echo GetName::getRating($model->id)->count ?></span>
			пользователей</p>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
			<h4>Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
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
		<h4 class="subtitle" align="center">Галерея</h4>
		<?php if($gallery): ?>
		<div class="image_carousel">
			<div id="photos" class="carusel">
				<?php foreach ($gallery as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				} ?>
			</div>
			<div class="pagination" id="photos_pag"></div>
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif ?>
		<div class="clearfix"></div>
		<h4 class="subtitle" align="center">Лицензии, сертификаты, дипломы</h4>
		<?php if(!is_null($model->userInfo[0]->license)): ?>
			<ol class="doc-list"><?php echo GetName::getDocsList($model->userInfo[0]->license)->list ?></ol>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
		<div class="clearfix"></div>
		<!--
		<div class="subtitle">
			<h4>Цены на товары и услуги</h4>
		</div>
		<?php if($model->userInfo[0]->price): ?>
			<ol class="doc-list">
				<?php echo GetName::getDocsList($model->userInfo[0]->price)->list ?>
			</ol>	
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
	-->
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
			<span class="red pull-right"><?php echo !empty($model->userInfo[0]->license) ? count(json_decode($model->userInfo[0]->license)) : "0"; ?></span>
		</div>
		<div class="rating-title">
			<a href="#geography" role="button" data-toggle="modal">Регионов деятельности</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo[0]->regions) ? count(json_decode($model->userInfo[0]->regions)) + 1 : "1"; ?></span>
		</div>		
		<div class="rating-title"><a href="#profile" role="button" data-toggle="modal">Профилей деятельности</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo[0]->profiles) ? count(json_decode($model->userInfo[0]->profiles)) : "0"; ?></span>
		</div>		
		<div class="rating-title"><a href="#category" role="button" data-toggle="modal">
			<?php if(GetName::getCabinetAttributes($model->id)->type == 2)
				echo "Видов работ";
			?>
			<?php if(GetName::getCabinetAttributes($model->id)->type == 3)
				echo "Категорий товаров";
			?>
		</a>:
			<span class="red pull-right"><?php echo !empty($model->userInfo[0]->goods) ? count(json_decode($model->userInfo[0]->goods)) : "0"; ?></span>
		</div>
		<div class="rating-title">Опыт компании (лет):
			<span class="red pull-right"><?php echo !empty($model->userInfo[0]->age) ? $model->userInfo[0]->age : "0"; ?></span>
		</div>
		<div class="subtitle"><h4>Краткое описание компании</h4></div>	
		<p class="comment">
			<?php echo !empty($model->organizationData[0]->description) ? CHtml::encode($model->organizationData[0]->description) : "Пользователь не оставил описания."; ?>
		</p>

	</div>
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
		<li><strong>Основной: <?php echo CHtml::encode($model->personalData[0]->region->region_name) ?></strong></li>
		<?php echo GetName::jsonToString($model->userInfo[0]->regions, GetName::getNames('Region', 'region_name'), "li"); ?>
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
		if(!empty($model->userInfo[0]->goods))
		{
			if(GetName::getCabinetAttributes($model->id)->type == 3)
		echo empty($model->userInfo[0]->profiles) ? "Не указано" : GetName::jsonToString($model->userInfo[0]->profiles, MaterialBuy::model()->categoryList, "li"); 
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
		if(!empty($model->userInfo[0]->goods))
		{
			if(GetName::getCabinetAttributes($model->id)->type == 3)
				echo GetName::jsonToString($model->userInfo[0]->goods, GetName::getNames('MaterialList', 'name'), "li"); 
			if(GetName::getCabinetAttributes($model->id)->type == 2)
				echo GetName::jsonToString($model->userInfo[0]->goods, GetName::getNames('WorkTypes', 'name'), "li"); 
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