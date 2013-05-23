<h3 class="block-title">Кабинет <?php echo $user->title; ?></h3>
  <div class="user-header clearfix">
		<div class="span1 thumbnail">
    	<?php if(!empty($user->avatar)): ?>
        <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$user->avatar), array('user/main')); ?>
      <?php else: ?>
        <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'), array('user/view')); ?>
      <?php endif; ?>
  	</div>
  	<h4><?php echo CHtml::link($user->name."<br />".$user->orgType, array('user/main')) ?></h4>
  </div>
  <div class="cabinetNav">
  	<ul>
  		<li>Регион <small class="pull-right"><?php echo $user->region ?></small></li>

  		<?php if(!empty($user->rating)): ?>
  			<li>Ваш рейтинг <small class="pull-right"><?php echo $user->rating ?></small></li>
  		<?php endif ?>

			<?php if(!empty($user->orders->total)): ?>
  		<li>Актуальных заказов 
  				<small class="pull-right"><?php echo $user->orders->total ?></small>
  		</li>
			<?php elseif(!empty($user->orders->fizlitsa)): ?>
			<li class="parent"><span>Поступило заказов</span>
  			<ul>
					<li>От частных лиц 
  					<small class="pull-right"><?php echo $user->orders->fizlitsa ?></small>
  				</li>
  				<li>От компаний 
  					<small class="pull-right"><?php echo $user->orders->company ?></small>
  				</li>
					<li>От бригад 
						<small class="pull-right"><?php echo $user->orders->gang ?></small>
					</li>
					<li>От рабочих 
						<small class="pull-right"><?php echo $user->orders->workers ?></small>
					</li>
  			</ul>
  		</li>		

			<?php endif ?>

  		<?php if(!empty($user->questions)): ?>
  			<li>Вопросов от заказчиков 
  				<small class="pull-right"><?php echo $user->questions ?></small>
  			</li>
  		<?php endif ?>

  		<li>Объектов <small class="pull-right"><?php echo $user->objects ?></small></li>

  		<?php if(!empty($user->equipment)): ?>
  			<li>Оборудование 
  				<small class="pull-right"><?php echo $user->equipment ?></small>
  			</li>
  		<?php endif ?>


  		
  		<?php if(!empty($user->offers)): ?>
  		<li class="parent"><span>Поступило предложений</span>
  			<ul>
  				<?php if(!empty($user->offers->company)): ?>
  				<li>От строительных компаний 
  					<small class="pull-right"><?php echo $user->offers->company ?></small>
  				</li>
  				<?php endif ?>
  				<?php if(!empty($user->offers->gang)): ?>
					<li>От бригад 
						<small class="pull-right"><?php echo $user->offers->gang ?></small>
					</li>
					<?php endif ?>
						<li>От рабочих 
							<small class="pull-right"><?php echo $user->offers->workers ?></small>
						</li>
  			</ul>
  		</li>
  		<?php endif ?>

  		<?php if(!empty($user->supply)): ?>
  		<li class="parent"><span>Предложений на поставку</span>
  			<ul>
  				<li>Строительных материалов 
  					<small class="pull-right"><?php echo $user->supply->materials ?></small>
  				</li>
					<li>Отделочных материалов 
						<small class="pull-right"><?php echo $user->supply->finish ?></small>
					</li>
						<li>Инженерного оборудования 
							<small class="pull-right"><?php echo $user->supply->engineer ?></small>
						</li>
  			</ul>
  		</li>
  		<?php endif; ?>

			<?php if(!empty($user->answers)): ?>
	  		<li>Ответов специалистов 
	  			<small class="pull-right"><?php echo $user->answers ?></small>
	  		</li>
  		<?php endif; ?>
  	</ul>

  </div>

<?php // $this->controller->renderPartial('/profile/menu/1/_left'); ?>