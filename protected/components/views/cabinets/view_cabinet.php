<h3 class="block-title">Кабинет <?php echo $userAttributes->title; ?></h3>
  <div class="user-header clearfix">
		<div class="span1 thumbnail">
    	<img src="http://placekitten.com/80/80" alt="">
  	</div>
  	<h4><?php echo $userAttributes->name ?></h4>
  	<small><?php echo $userAttributes->orgType ?></small>
  </div>
  <div class="cabinetNav">
  	<ul>
  		<li>Регион <small class="pull-right"><?php echo $userAttributes->region ?></small></li>

  		<?php if(!empty($userAttributes->rating)): ?>
  			<li>Ваш рейтинг <small class="pull-right"><?php echo $userAttributes->rating ?></small></li>
  		<?php endif ?>

			<?php if(!empty($userAttributes->orders->total)): ?>
  		<li>Актуальных заказов 
  				<small class="pull-right"><?php echo $userAttributes->orders->total ?></small>
  		</li>
			<?php elseif(!empty($userAttributes->orders->fizlitsa)): ?>
			<li class="parent"><span>Поступило заказов</span>
  			<ul>
					<li>От частных лиц 
  					<small class="pull-right"><?php echo $userAttributes->orders->fizlitsa ?></small>
  				</li>
  				<li>От компаний 
  					<small class="pull-right"><?php echo $userAttributes->orders->company ?></small>
  				</li>
					<li>От бригад 
						<small class="pull-right"><?php echo $userAttributes->orders->gang ?></small>
					</li>
					<li>От рабочих 
						<small class="pull-right"><?php echo $userAttributes->orders->workers ?></small>
					</li>
  			</ul>
  		</li>		

			<?php endif ?>

  		<?php if(!empty($userAttributes->questions)): ?>
  			<li>Вопросов от заказчиков 
  				<small class="pull-right"><?php echo $userAttributes->questions ?></small>
  			</li>
  		<?php endif ?>

  		<li>Объектов <small class="pull-right"><?php echo $userAttributes->objects ?></small></li>

  		<?php if(!empty($userAttributes->equipment)): ?>
  			<li>Оборудование 
  				<small class="pull-right"><?php echo $userAttributes->equipment ?></small>
  			</li>
  		<?php endif ?>


  		
  		<?php if(!empty($userAttributes->offers)): ?>
  		<li class="parent"><span>Поступило предложений</span>
  			<ul>
  				<?php if(!empty($userAttributes->offers->company)): ?>
  				<li>От строительных компаний 
  					<small class="pull-right"><?php echo $userAttributes->offers->company ?></small>
  				</li>
  				<?php endif ?>
  				<?php if(!empty($userAttributes->offers->gang)): ?>
					<li>От бригад 
						<small class="pull-right"><?php echo $userAttributes->offers->gang ?></small>
					</li>
					<?php endif ?>
						<li>От рабочих 
							<small class="pull-right"><?php echo $userAttributes->offers->workers ?></small>
						</li>
  			</ul>
  		</li>
  		<?php endif ?>

  		<?php if(!empty($userAttributes->supply)): ?>
  		<li class="parent"><span>Предложений на поставку</span>
  			<ul>
  				<li>Строительных материалов 
  					<small class="pull-right"><?php echo $userAttributes->supply->materials ?></small>
  				</li>
					<li>Отделочных материалов 
						<small class="pull-right"><?php echo $userAttributes->supply->finish ?></small>
					</li>
						<li>Инженерного оборудования 
							<small class="pull-right"><?php echo $userAttributes->supply->engineer ?></small>
						</li>
  			</ul>
  		</li>
  		<?php endif; ?>

			<?php if(!empty($userAttributes->answers)): ?>
	  		<li>Ответов специалистов 
	  			<small class="pull-right"><?php echo $userAttributes->answers ?></small>
	  		</li>
  		<?php endif; ?>
  	</ul>

  </div>

<?php // $this->controller->renderPartial('/profile/menu/1/_left'); ?>