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
		<p class="header"> <?php echo $model->role_id == 1 ? "Заказчик" : "Поставщик услуг" ?>:</p> 
		
		<p class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo ($model->org_type_id == 1) ? CHtml::encode($model->personalData->first_name . ' ' .$model->personalData->middle_name . ' ' . $model->personalData->last_name) : CHtml::encode($model->organizationData->org_name) ?></p>
		<?php if($model->role_id != 1): ?>
		<div class="tarif light-blue light-blue-border clearfix">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Изменить',
			    'type'=>'info',
			     'size'=>'small',
			     'url'=>array('#'),
			    'htmlOptions' => array('class'=>'pull-right')
			)); ?>
		Тарифный план 
			<span class="big"><?php echo UserSettings::getThisTariff() == 1 ? "Базовый" : "Vip"; ?></span>
		</div>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
			<h4>Мой Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
		</div>			
		<div class="rating-title"><?php echo UserRating::model()->category[0] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->price ?></span>
		</div>
		<div class="rating-title"><?php echo  UserRating::model()->category[1] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->quality ?></span>
		</div>
		<div class="rating-title"><?php echo  UserRating::model()->category[2] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->delivery ?></span>
		</div>
		<div class="rating-title"><?php echo  UserRating::model()->category[3] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->personal ?></span>
		</div>
		<div class="rating-title"><?php echo  UserRating::model()->category[4] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->assortiment ?></span>
		</div>
		<div class="rating-title"><?php echo UserRating::model()->category[5] ?>:
			<span class="red pull-right"><?php echo GetName::getRating($model->id)->service ?></span>
		</div>
	</div>
<?php else: ?>
	<h4>
		<span class="red">
			<?php echo CHtml::encode($model->personalData->city->city_name) ?>				
		</span>
		<span><a href="#geography" role="button" data-toggle="modal"> и другие регионы</a></span>
	</h4>
	<?php if($model->org_type_id != 1): ?>
	<p><strong>Контактное лицо:</strong><?php echo CHtml::encode($model->personalData->first_name . ' ' .$model->personalData->middle_name . ' ' . $model->personalData->last_name) ?></p>
	<?php endif; ?>
	<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData->phone1 . '; ' . $model->personalData->phone2)  ?></p>
	<p><strong>Email: </strong><?php echo CHtml::mailto($model->email) ?></p>
</div>
<?php endif; ?>