<?php
/* @var $this EventsController */
/* @var $data Events */
?>

<div class="event">
	<div class="pull-right date">
		<?php echo date('d.m.Y',strtotime($data->date)); ?>
	</div>
	<div class="clearfix"></div>

	<div class="subtitle span1 pull-right">
		<h4>Оценка: 
			<span class="red">
				<?php echo GetName::getThisRating($data->id)->rating ?>
			</span>
		</h4>
	</div>
  <div class="user-header clearfix">
		<div class="thumbnail user-image">
		<?php if(!empty($data->user->settings[0]->avatar)): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$data->user->settings[0]->avatar); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
		<?php endif; ?>
		</div>
		<p>
			<?php echo CHtml::encode($data->user->role->role_name); ?>
			<strong> <?php echo CHtml::link(CHtml::encode($data->user->organizationData[0]->org_name), array('user/profile', 'id'=>$data->user_id)); ?>
		</strong>
		</p>		
  </div>

	<div class="event-preview">
		<?php echo CHtml::encode($data->review); ?>
	</div>
	<div class="event-tools">
		<ul>
			<li>
				<?php echo CHtml::link(CHtml::encode('Пожаловаться на отзыв'), array('#')); ?>
			</li>
			<div class="pull-right">
<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div> 

			</div>
		</ul>	
	</div>
</div>