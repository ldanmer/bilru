<h3 class="block-title">Кабинет <?php echo GetName::getCabinetAttributes()->title; ?></h3>
  <div class="user-header clearfix">
		<div class="span1 avatar">
    	<?php if(!empty($model->settings[0]->avatar)): ?>
        <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$model->settings[0]->avatar), array('user/main')); ?>
      <?php else: ?>
        <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'), array('user/view')); ?>
      <?php endif; ?>
  	</div>
  	<h4><?php echo CHtml::link(GetName::getUserTitles($model->id)->orgType, array('user/main')); ?>
      <br>
    <?php echo ($model->org_type_id == 1) ? CHtml::link(CHtml::encode($model->personalData[0]->first_name . ' ' .$model->personalData[0]->middle_name . ' ' . $model->personalData[0]->last_name), array('user/main')) : CHtml::link(CHtml::encode($model->organizationData[0]->org_name), array('user/main')) ?>
    </h4>
  </div>
  <div class="cabinetNav">
  	<ul>
  		<li>Регион <span class="pull-right red"><?php echo CHtml::encode($model->personalData[0]->region->region_name) ?></span></li>
  		<?php if(!empty(GetName::getRating($model->id)->averageRating)): ?>
			<li>Ваш рейтинг <span class="pull-right red"><?php echo GetName::getRating($model->id)->averageRating ?></span></li>
  		<?php endif ?>
  		<li>Актуальных заказов 
				<span class="pull-right red"><?php echo User::ordersCount($model->id, 1) + $model->materialsCountActual ?></span>
  		</li>
      <li>Объектов 
        <span class="pull-right red"><?php echo $model->objectCount ?></span>
      </li>      
  		<li class="parent"><span>Поступило предложений</span>
  			<ul>
  				<li>От строительных компаний 
  					<span class="pull-right red"><?php echo User::userOrdersInfo($model->id)->offersToMe->builders ?></span>
  				</li>
					<li>От бригад 
						<span class="pull-right red"><?php echo User::userOrdersInfo($model->id)->offersToMe->gangs ?></span>
					</li>
					<li>От рабочих 
						<span class="pull-right red"><?php echo User::userOrdersInfo($model->id)->offersToMe->masters ?></span>
					</li>
  			</ul>
  		</li>
  		<li class="parent"><span>Предложений на поставку</span>
  			<ul>
  				<li>Строительных материалов 
  					<span class="pull-right red"><?php echo User::offersToBuy($model->id, 1) ?></span>
  				</li>
					<li>Отделочных материалов 
						<span class="pull-right red"><?php echo User::offersToBuy($model->id, 2) ?></span>
					</li>
						<li>Инженерного оборудования 
							<span class="pull-right red"><?php echo User::offersToBuy($model->id, 3) ?></span>
						</li>
  			</ul>
  		</li>
  	</ul>
  </div>

