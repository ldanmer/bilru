<div class="comment-block">
	<div class="user-header clearfix">
		<div class="thumbnail user-image">
		<?php if(!empty($data->comment->user->settings[0]->avatar)): ?>
		  <?php echo CHtml::image(Yii::app()->baseUrl.$data->comment->user->settings[0]->avatar); ?>
		<?php else: ?>
		  <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
		<?php endif; ?>
	</div>
	<p>
		<strong>
			<?php echo CHtml::link(CHtml::encode($data->user->organizationData[0]->org_name), array('user/profile', 'id'=>$data->user_id)); ?>
		</strong>
	</p>	
		<?php echo CHtml::encode($data->comment); ?>
</div>



</div>
