<?php
	$this->pageTitle=Yii::app()->name . ' - Регистрация';
	$this->breadcrumbs=array(
		'Регистрация'
	);
?>

<?php 
// Успешная регистрация
if(Yii::app()->user->hasFlash('success')):
	 $this->widget('bootstrap.widgets.TbAlert', array(
	  'block'=>true, 
	  'fade'=>true, 
	  'closeText'=>'&times;', 
	  'alerts'=>array( 
	      'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
	  ),
	)); 
	
// Вывод 1й формы
elseif (empty($roleAttributes)):
	$this->renderPartial('_step1');

// Вывод 2й формы 
else:
?>
<div class="user-form row" id="registration-form2">
<div class="span8">
	<h3 class="form-title">Регистрация <?php echo $roleAttributes->title; ?></h3>
	<p class="small">Заполните поля</p>
</div>

<div class="span3">
	<h3 class="jur-status"><?php echo $roleAttributes->jur; ?></h3>

</div>
<div class="clearfix"></div>

	<?php if($roleAttributes->jur == "Частное лицо"): ?>

		<?php echo $this->renderPartial('_step2',array(
						'model'=>$model, 
						'userData' => $userData,
						'roleAttributes'=>$roleAttributes,
						'regionNames' => $regionNames,
						'cityNames' => $cityNames,
			)); ?>

	<?php else: ?>
		<?php echo $this->renderPartial('_step3',array(
						'model'=>$model, 
						'userData' => $userData,
						'roleAttributes'=>$roleAttributes,
						'regionNames' => $regionNames,
						'cityNames' => $cityNames,
						'orgTypes' => $orgTypes,
						'orgData' => $orgData,
			)); ?>

	<?php endif; ?>
</div>
<?php endif; ?>
