<?php
/* @var $this EventsController */
/* @var $data Events */
?>

<div class="event">
	<div class="pull-right date">
			<?php echo CHtml::encode($data->date); ?>
	</div>	
  <div class="user-header clearfix">
		<div class="thumbnail user-image">
	  	<img src="http://placekitten.com/40/40" alt="">
		</div>
		<p><strong>
			<?php echo CHtml::link(CHtml::encode($data->userName), array('user/view', 'id'=>$data->user_id)); ?>
		</strong>
			<br />
			<small><?php echo CHtml::encode($data->title); ?></small>
		</p>	
	
  </div>

	<div class="event-preview">
		<?php echo CHtml::encode($data->text); ?>
	</div>
	<div class="event-tools">
		<ul>
			<li class="">
				<?php echo CHtml::link(CHtml::encode('Комментировать'), array('#')); ?>
			</li>
			<li class="like">
				<?php echo CHtml::link(CHtml::encode('Нравится'), array('#')); ?>
			</li>
			<div class="pull-right">
<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div> 

			</div>
		</ul>	
	</div>
</div>