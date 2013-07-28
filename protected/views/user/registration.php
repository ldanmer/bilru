<?php	$this->pageTitle=Yii::app()->name . ' - Регистрация'; ?>
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
<div class="user-form register-form">
<div class="span6">
	<h3 class="form-title">Регистрация <?php echo $roleAttributes->title; ?></h3>
</div>
<div class="span3">
	<h3 class="jur-status"><?php echo $roleAttributes->jur; ?></h3>
</div>
<div class="clearfix"></div>
	<p class="muted text-center">Заполните поля</p>

	<?php if($roleAttributes->jur == "Частное лицо"): ?>

		<?php echo $this->renderPartial('_step2',array(
						'model'=>$model, 
						'userData' => $userData,
						'roleAttributes'=>$roleAttributes,
			)); ?>

	<?php else: ?>
		<?php echo $this->renderPartial('_step3',array(
						'model'=>$model, 
						'userData' => $userData,
						'roleAttributes'=>$roleAttributes,
						'orgTypes' => $orgTypes,
						'orgData' => $orgData,
			)); ?>

	<?php endif; ?>
</div>
<?php  endif; ?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'agreement')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">X</a>
    <h4>Позовательское соглашение</h4>
</div>
 
<div class="modal-body">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Suspendisse nisi. Vestibulum vitae enim a nulla suscipit tincidunt. Suspendisse potenti. Phasellus pulvinar. Donec suscipit dui at nisi. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </p>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
    </p>
</div>
 
<div class="modal-footer">
  <?php $this->widget('bootstrap.widgets.TbButton', array(
      'label'=>'Принять',
      'type'=>'primary',
      'htmlOptions'=>array('data-dismiss'=>'modal', 'id'=>'accept'),
  )); ?>
  <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Закрыть',
    'type'=>'danger',
    'htmlOptions'=>array('data-dismiss'=>'modal'),
  )); ?>
</div>
 
<?php $this->endWidget(); ?>
