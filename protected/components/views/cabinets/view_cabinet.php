<?php if($model): ?>
<h3 class="block-title">Кабинет <?php echo GetName::getCabinetAttributes()->title; ?></h3>
  <div class="user-header clearfix">
		<div class="span1 avatar">
    	<?php if(!empty($model->settings->avatar)): 
				$avatar = json_decode($model->settings->avatar);

			?>
      <?php $this->widget('ext.SAImageDisplayer', array(
          'image' => str_replace('/images/originals/', '', $avatar[0]),
          'size' => 'thumb',
          'defaultImage' => 'avatar_placeholder.png',
      )); ?>
      <?php endif; ?>
      
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  'action' => array('user/main'),
  'htmlOptions' => array('enctype' => 'multipart/form-data')
  )); 
      $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Изменить',
        'type'=>'link',
        'size'=>'mini', 
        'block'=>true,
        'htmlOptions' => array(
          'class'=>'pull-right upload',
          'data-target'=>'avatar',
          'title'=>'Разрешенные типы файлов: jpeg|jpg|gif|png',
          'style'=>'margin-top:5px',
          ),
      )); 
      $this->widget('CMultiFileUpload', array(
        'name' => 'avatar',
        'accept' => 'jpeg|jpg|gif|png',
        'duplicate' => 'Дупликат!', 
        'denied' => 'Неверный тип файла',
      ));

      $this->endWidget(); ?> 
  	</div>
  	<h4><?php echo CHtml::link(GetName::getUserTitles($model->id)->orgType, array('user/main')); ?>
      <br>
    <?php echo ($model->org_type_id == 1) ? CHtml::link(CHtml::encode($model->personalData->first_name . ' ' .$model->personalData->middle_name . ' ' . $model->personalData->last_name), array('user/main')) : CHtml::link(CHtml::encode($model->organizationData->org_name), array('user/main')) ?>
    </h4>
  </div>
  <div class="cabinetNav">
  	<ul>
  		<li>Регион <span class="pull-right red"><?php echo CHtml::encode($model->personalData->city->city_name) ?></span></li>
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
<?php else: ?>
  <h3 class="block-title">Гостевой доступ</h3>
  <div class="user-header clearfix">
    <div class="span1 avatar">
      <?php echo CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'); ?>     
    </div>
    <h4>Гость</h4>
  </div> 
  <br>
<?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Регистрация',
        'type'=>'primary', 
        'block'=>true,
        'url'=>Yii::app()->user->registrationUrl,
      )); 
      $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Войти',
        'type'=>'primary', 
        'block'=>true,
        'url'=>Yii::app()->user->loginUrl,
      ));  
    ?> 
<?php endif; ?>

