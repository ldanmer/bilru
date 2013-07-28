<div class="comment-block">
	<div class="user-header clearfix">
		<div class="user-image">
		
		<?php if(!empty($data->user->settings->avatar)): 		
					$avatar = json_decode($data->user->settings->avatar);
		?>
		  <?php echo CHtml::image(Yii::app()->baseUrl.$avatar[0]); ?>
		<?php else: ?>
		  <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
		<?php endif; ?>
	</div>
	<p>
		<strong>
			<?php echo CHtml::link(CHtml::encode($data->user->organizationData->org_name), array('user/profile', 'id'=>$data->user_id)); ?>
		</strong>
	</p>	
		<?php echo CHtml::encode($data->comment);?>
</div>



</div>
