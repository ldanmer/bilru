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
		<span class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?></span></p> 
		<p class="big"><?php echo ($model->org_type_id == 1 && $model->role_id == 1 ) ? CHtml::encode($model->personalData[0]->first_name . ' ' .$model->personalData[0]->middle_name . ' ' . $model->personalData[0]->last_name) : CHtml::encode($model->organizationData[0]->org_name) ?></p>
		<?php if($model->role_id == 4): ?>
			<p class="header">Бригадир/Прораб:  
			<span class="big"><?php echo CHtml::encode($model->personalData[0]->first_name) ?> <?php echo CHtml::encode($model->personalData[0]->last_name) ?></span></p>
		<?php endif; ?>
		<?php if($model->role_id == 5): ?>			 
			<p class="big"><?php echo CHtml::encode($model->personalData[0]->first_name . ' ' .$model->personalData[0]->middle_name . ' ' . $model->personalData[0]->last_name) ?></p>
		<?php endif; ?>
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
<?php else: ?>
	<h4>
		<span class="red">
			<?php echo CHtml::encode($model->personalData[0]->region->region_name) ?>				
		</span>
		<span><a href="#geography" role="button" data-toggle="modal"> и другие регионы</a></span>
	</h4>
	<?php if($model->org_type_id != 1): ?>
	<p><strong>Контактное лицо:</strong><?php echo CHtml::encode($model->personalData[0]->first_name . ' ' .$model->personalData[0]->middle_name . ' ' . $model->personalData[0]->last_name) ?></p>
	<?php endif; ?>
	<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData[0]->phone1 . '; ' . $model->personalData[0]->phone2)  ?></p>
	<p><strong>Email: </strong><?php echo CHtml::mailto($model->email) ?></p>
</div>
<?php endif; ?>