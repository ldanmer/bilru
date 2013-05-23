<div class="event" id="event<?php echo $data->id?>">
	<div class="pull-right date">
			<?php echo CHtml::encode($data->date); ?>
	</div>	
  <div class="user-header clearfix">
		<div class="thumbnail user-image">
	  	<?php if(!empty($data->user->settings[0]->avatar)): ?>
	      <?php echo CHtml::image(Yii::app()->baseUrl.$data->user->settings[0]->avatar); ?>
	    <?php else: ?>
	      <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>
	    <?php endif; ?>
		</div>
		<p><strong>
			<?php echo CHtml::link(CHtml::encode($data->userName), array('user/profile', 'id'=>$data->user_id)); ?>
		</strong>
			<br />
			<small><?php echo CHtml::encode($data->title); ?></small>
		</p>	
	
  </div>

	<div class="event-preview">
		<?php echo Events::trimLongText($data->text); ?>
      <?php if($data->commentsCount > 0): ?>
      <div class="event-tools span6 pull-right">				
      	<?php 
					echo CHtml::ajaxLink('Показать все комментарии', Yii::app()->createUrl('events/like'),
				  	array(
							'type' => 'POST',
							'success'=>'function(data)
							{  		
								var json = $.parseJSON(data);
								$("#event"+json.id+" li.like span").text(json.count);					
							
							}',
  						'data' => array(
  							'event' => $data->id,
  							Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken)
  						)); 
				?>
			</div>
      <?php $this->widget('zii.widgets.CListView', array(
				'dataProvider'=>new CArrayDataProvider(array_reverse($data->comments)), 
				'itemView'=>'_comment',
				'template' => '{items}',
				'ajaxUpdate'=>true,
				'htmlOptions' => array('class' => 'comments-block span6 pull-right'),
			)); ?>
	 	<?php endif; ?>
	</div>

	<div class="event-tools clearfix">
		<ul>
			<li class="replay">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>'Комментировать',
				    'type'=>'link', 
				    'htmlOptions'=>array('class'=>'comment-show'),				    
				)); ?>
        <span class="comments-count"><?php echo $data->commentsCount; ?></span>	
			</li>
			<li class="like">
				<?php 
					echo CHtml::ajaxLink('Нравится', Yii::app()->createUrl('events/like'),
				  	array(
							'type' => 'POST',
							'success'=>'function(data)
							{  		
								var json = $.parseJSON(data);
								$("#event"+json.id+" li.like span").text(json.count);					
							
							}',
  						'data' => array(
  							'event' => $data->id,
  							Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken)
  						)); 
				?>
				<span><?php echo $data->likesCount ?></span>
			</li>
			<div class="pull-right">
<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div> 
			</div>
		</ul>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'htmlOptions' => array('class' => 'create-form comment-form'),
			'enableClientValidation'=>true,
			'enableAjaxValidation'=>true,
			)); ?>
	<legend>
		<span>Комментарий</span>
	</legend>
	<fieldset>
			<div class="span14 pull-right">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxSubmit',	
			'url'=>array('events/comment'),
			'type'=>'primary',
			'size'=>'small',
			'label'=> 'Сохранить',	
			'htmlOptions'=>array('class'=>'pull-right'),	
			'ajaxOptions'=>array(
					'type'=>'POST',					
					'success'=>'function(data){	
						var data = $.parseJSON(data);	
						var event = $("#event" + data.id);				
						if(!data.status)
						{    							
							event.find(".help-block").text(data.error);
							event.find(".help-block").show();         
						}
						else
						{
							event.find("form").fadeOut(300); 
							event.find("textarea").val(""); 
							event.find(".help-block").text(""); 
							event.find(".comments-count").text(data.count); 
						}
					}'
				),
		)); ?>



		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'size'=>'small',
			'label'=> 'Отмена',		
			'htmlOptions'=>array('class'=>'cencel'),		
		)); ?>
		</div>
		<?php echo $form->textAreaRow(new EventsComments, 'comment', array(
			'label'=>false, 
			'placeholder' => 'Комментировать...',
			'class'=>'span5',			
		)); ?>

		<?php echo $form->hiddenField($data, 'id'); ?>


</fieldset>
<?php $this->endWidget(); ?>

	</div>
</div>