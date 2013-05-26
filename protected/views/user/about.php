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
<?php 
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'create-form'),
		'id'=>'upload',
		'enableClientValidation'=>true,
			)); ?>
<legend><span>О компании</span></legend>
<fieldset>
	<div class="span1">
  	<?php if(!empty($model->settings[0]->avatar)): ?>
      <?php echo CHtml::image(Yii::app()->baseUrl.$model->settings[0]->avatar); ?>
    <?php else: ?>
      <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
    <?php endif; ?>
		<div class="upload">
			<span class="btn btn-primary btn-mini btn-block">Изменить</span>
				<?php 
				echo $form->fileFieldRow($model->settings[0], 'avatar',  array('label'=>false,'onchange'=>'this.form.submit()') ); ?>
		</div>
	</div>

	<div id="maininfo" class="span4">
		<span class="header"> <?php echo CHtml::encode($model->role->role_name) ?></span>
		<p class="big"><?php echo GetName::getUserTitles($model->id)->orgType ?> <?php echo CHtml::encode($model->organizationData[0]->org_name) ?></p>
		<p class="red"><?php echo CHtml::encode($model->personalData[0]->region->region_name) ?></p>
	<?php if($model->role_id != 1): ?>
	</div>
	<div class="span13 pull-right">
		<div class="subtitle">
		<h4>Мой Рейтинг: <span class="red"><?php echo GetName::getRating($model->id)->averageRating ?></span></h4>
		</div>	
	</div>
	<?php else: ?>
		<p><strong>Контактное лицо:</strong><?php echo CHtml::encode($model->personalData[0]->first_name)?> <?php echo CHtml::encode($model->personalData[0]->middle_name) ?> <?php echo CHtml::encode($model->personalData[0]->last_name) ?></p>
		<p><strong>Телефон: </strong><?php echo CHtml::encode($model->personalData[0]->phone1) . '; ' . CHtml::encode($model->personalData[0]->phone2)  ?></p>
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
			<?php echo !empty($model->organizationData[0]->description) ? CHtml::encode($model->organizationData[0]->description) : "Описание компании. Заполняется поставщиком."; ?>
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
		<ul>
			<?php echo $geography; ?>
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
		<ul>
			<?php echo $goods; ?>
		</ul>
	</div>
	<div class="clearfix">
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
			<?php $this->widget('CMultiFileUpload', array(
        'name' => 'portfolio',
        'accept' => 'jpeg|jpg|gif|png',
        'duplicate' => 'Дупликат!', 
        'denied' => 'Неверный тип файла',
      ));
    ?>   
	</div>
	<div class="clearfix">	
		<h4 class="subtitle" align="center">Лицензии, сертификаты, дипломы</h4>
		<?php if(!is_null($model->userInfo[0]->license)): ?>
			<ol class="doc-list"><?php echo GetName::getDocsList($model->userInfo[0]->license)->list ?></ol>	
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
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
		'htmlOptions' => array('name' => 'save', 'class'=>'pull-right'),			
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
<div class="modal-body">
	<?php echo $form->checkBoxListRow($model->userInfo[0], 'regions', GetName::getNames('Region', 'region_name'), array(
		'label'=>false, 
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

<!-- Редактирование профиля деятельности -->
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'profile')); ?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body">
	<?php
	if(GetName::getCabinetAttributes($model->id)->type == 2)
	 	echo $form->checkBoxListRow($model->userInfo[0], 'profiles', Orders::model()->categoryList, array(
		'label'=>false, 
	)); 
	if(GetName::getCabinetAttributes($model->id)->type == 3)
	 	echo $form->checkBoxListRow($model->userInfo[0], 'profiles', MaterialBuy::model()->categoryList, array(
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
		'htmlOptions' => array('class' => 'create-form'),
		'enableAjaxValidation'=>false,
	)); ?>
<div class="modal-body">
	<?php 
	if(GetName::getCabinetAttributes($model->id)->type == 2)
		echo $form->checkBoxListRow($model->userInfo[0], 'goods', GetName::getNames('WorkTypes', 'name'), array(
			'label'=>false, 
		)); 
	if(GetName::getCabinetAttributes($model->id)->type == 3)
		echo $form->checkBoxListRow($model->userInfo[0], 'goods', GetName::getNames('MaterialList', 'name'), array(
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
	<?php echo $form->textAreaRow($model->userInfo[0],'description',array(
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