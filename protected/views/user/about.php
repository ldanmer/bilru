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
	        array('label'=>'Кабинет', 'url'=>array('user/payment'),'visible' =>!($model->role_id == 1 && $model->org_type_id == 1))

	    ),
	)); ?>
</div>
<?php 
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'create-form'),
		'id'=>'upload',
		'enableClientValidation'=>true,
			)); ?>
<legend><span>О компании</span></legend>
<fieldset>
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

	<div id="maininfo" class="span4">
		<span class="header"> <?php echo CHtml::encode($model->role->role_name) ?></span>
		<p class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo CHtml::encode($model->organizationData->org_name) ?></p>
		<p class="red"><?php echo CHtml::encode($model->personalData->city->city_name) ?></p>
	<?php if($model->role_id != 1): ?>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
		<h4>Мой Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
		</div>	
	</div>
	<?php else: ?>
		<p><strong>Контактное лицо:</strong><?php echo CHtml::encode($model->personalData->first_name)?> <?php echo CHtml::encode($model->personalData->middle_name) ?> <?php echo CHtml::encode($model->personalData->last_name) ?></p>
		<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData->phone1) . '; ' . CHtml::encode($model->personalData->phone2)  ?></p>
		<p><strong>Email: </strong><?php echo CHtml::mailto($model->email) ?></p>
	</div>
	<?php endif; ?>
		<div class="clearfix">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Изменить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change',
		    	'data-toggle'=>'modal',
				  'data-target'=>'#description'
				  ),
			)); ?>

		<div class="subtitle"><h4>Краткое описание компании</h4></div>	
		<p class="comment">
			<?php echo !empty($model->userInfo->description) ? CHtml::encode($model->userInfo->description) : "С Вами быстрее начнут работать если будут о Вас знать."; ?>
		</p>
	</div>
	<div class="clearfix">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Изменить',
    'type'=>'primary',
    'size'=>'mini',		     
    'htmlOptions' => array(
    	'class'=>'pull-right change',
    	'data-toggle'=>'modal',
		  'data-target'=>'#geography'
		  ),
		)); ?>
		<div class="subtitle">
			<h4>География деятельности</h4>
		</div>
		<ul class="double-col">
			<?php if(count($geography) > 0)
						{
							foreach ($geography as $value) 
								echo "<li>$value</li>";
						}

			 ?>
		</ul>
	</div>
	<?php if($model->role_id != 1): ?>
	<div class="clearfix">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Изменить',
    'type'=>'primary',
    'size'=>'mini',		     
    'htmlOptions' => array(
    	'class'=>'pull-right change',
    	'data-toggle'=>'modal',
		  'data-target'=>'#profile'
		  ),
	)); ?>
		<div class="subtitle">
			<h4>Профиль деятельности</h4>
		</div>
		<ul>
			<?php echo $profile; ?>
		</ul>
	</div>
	<div class="clearfix">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Изменить',
    'type'=>'primary',
    'size'=>'mini',		     
    'htmlOptions' => array(
    	'class'=>'pull-right change',
    	'data-toggle'=>'modal',
		  'data-target'=>'#goods'
		  ),
	)); ?>
		<div class="subtitle">
			<h4>  	
				<?php if(GetName::getCabinetAttributes($model->id)->type == 2)
					echo "Виды работ";
				?>
				<?php if(GetName::getCabinetAttributes($model->id)->type == 3)
					echo "Категории товаров";
			?>
		</h4>
		</div>
		<ul class="double-col">
			<?php echo $goods; ?>
		</ul>
	</div>
	<div class="clearfix">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'portfolio',
		    	'title'=>'Разрешенные типы файлов: jpeg|jpg|gif|png',
					'style'=>'margin-top:5px;',
				  ),
			)); ?>
		<h4 class="subtitle" align="center">Галерея</h4>
		<?php if($gallery): ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($gallery as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				} ?>
			</div>			
		</div>
		<?php else: ?>
		<div>
			<em>Покажите заказчику Ваши работы, ему будет легче выбрать именно Вас!</em>
		</div>
		<?php endif; ?>
			<?php $this->widget('CMultiFileUpload', array(
        'name' => 'portfolio',
        'accept' => 'jpeg|jpg|gif|png',
        'duplicate' => 'Дупликат!', 
        'denied' => 'Неверный тип файла',
      ));
    ?>   
	</div>
	<div class="clearfix">	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'license',
		    	'title'=>'Разрешенные типы файлов: jpeg|jpg|gif|png',
					'style'=>'margin-top:5px;',
				  ),
			)); ?>
		<h4 class="subtitle" align="center">Лицензии, сертификаты, дипломы</h4>
		<?php if(!is_null($model->userInfo->license)): ?>
			<ol class="doc-list"><?php echo GetName::getDocsList($model->userInfo->license)->list ?></ol>	
		<?php else: ?>
		<div>
			<em>Эти документы покажут Заказчику Ваш профессионализм</em>
		</div>
		<?php endif; ?> 
		<?php $this->widget('CMultiFileUpload', array(
        'name' => 'license',
        'accept' => 'jpeg|jpg|gif|png|doc|docx|pdf',
        'duplicate' => 'Дупликат!', 
        'denied' => 'Неверный тип файла',
      ));
    ?>
	</div>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('class'=>'pull-right'),			
	)); ?>
	<?php endif; ?>
</fieldset>
<?php $this->endWidget(); ?>


<!-- Модальные окна -->
<!-- Редактирование географии -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'geography')); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body" id="<?php echo UserSettings::getThisTariff() == 1 ? "tarifbase" : ""; ?>">

	<div class="accordion" id="accordion">
		<?php 
			$regions = Region::model()->findAll();
			foreach ($regions as $region): 
			?>
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#col<?php echo $region->id ?>">
	        <i class="icon-chevron-right"></i> <?php echo $region->region_name ?>
	      </a>
	    </div>
	    <div id="col<?php echo $region->id ?>" class="accordion-body collapse">
	      <div class="accordion-inner">
	      	<label class="checkbox">
	      		<input class="selectall" type="checkbox">
	      		<label class="pull-right selectall">Выбрать весь регион</label>
	      	</label>

	        <?php echo $form->checkBoxListRow($model->userInfo, 'regions', CHtml::listData(City::model()->findAll('region_id='.$region->id), 'id', 'city_name'), array('label'=>false,'uncheckValue'=>null)) ?>
	      </div>
	    </div>
	  </div>
		<?php endforeach; ?>
	</div>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('name' => 'save'),			
	)); ?>
</div>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<!-- Редактирование профиля деятельности -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'profile')); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body">
	<?php
	if(GetName::getCabinetAttributes($model->id)->type == 2)
	 	echo $form->checkBoxListRow($model->userInfo, 'profiles', Orders::model()->categoryList, array(
		'label'=>false, 
	)); 
	if(GetName::getCabinetAttributes($model->id)->type == 3)
	 	echo $form->checkBoxListRow($model->userInfo, 'profiles', MaterialBuy::model()->categoryList, array(
		'label'=>false, 
	));
	?>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('name' => 'save'),			
	)); ?>
</div>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<!-- Редактирование категорий продаж -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'goods')); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form', 'style'=>'height:100%'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body">
	<?php 
	if(GetName::getCabinetAttributes($model->id)->type == 2):	?>
	<div class="accordion" id="accordion2">
		<?php 
			$works = WorkTypes::model()->findAll(array('order'=>'id'));
			foreach ($works as $work): 
			?>
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#coll<?php echo $work->id ?>">
	        <i class="icon-chevron-right"></i>  <?php echo $work->name ?>
	      </a>
	    </div>
	    <div id="coll<?php echo $work->id ?>" class="accordion-body collapse">
	      <div class="accordion-inner">
	        <?php echo $form->checkBoxListRow($model->userInfo, 'goods', CHtml::listData(WorkTypesList::model()->findAll('parent='.$work->id), 'id', 'name'), array('label'=>false,'uncheckValue'=>null)) ?>
	      </div>
	    </div>
	  </div>
		<?php endforeach; ?>
	</div>
	
	<?php endif;	?>
	<?php if(GetName::getCabinetAttributes($model->id)->type == 3)
		echo $form->checkBoxListRow($model->userInfo, 'goods', GetName::getNames('MaterialList', 'name'), array(
			'label'=>false, 
		)); 

	?>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('name' => 'save'),			
	)); ?>
</div>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<?php
$this->widget('ext.fancybox.EFancyBox', array(
    'target'=>'a[rel=fancybox]',
    'config'=>array(),
    ));	
 ?>

 <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'description')); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body">
	<?php echo $form->textAreaRow($model->userInfo,'description',array(
		'rows'=>6, 
		'cols'=>50,
		'label'=>false,
		'placeholder' => 'Описание компании',
		'class' => 'span5',
	)); ?>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=> 'Сохранить',
		'htmlOptions' => array('name' => 'save'),			
	)); ?>
</div>
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>