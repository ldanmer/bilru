<?php 
	$count = Goszakaz::model()->count() + Orders::model()->count();
	$total = Goszakaz::model()->totalPrice();
	$mainPage = Yii::app()->checkSpecifiedPage('homepage') ? 'mainpage' : '';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />   

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
	<?php 
	 	$baseUrl = Yii::app()->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  $cs->registerCssFile($baseUrl.'/css/styles.css');
	  $cs->registerScriptFile($baseUrl.'/js/jquery.carousel.js');
	  $cs->registerScriptFile($baseUrl.'/js/custom.js');
 ?>
</head>

<body>
	<div id="header">
		<div id="header-wrap" class="container">		
	      <div id="base-count" class="pull-right redback">
					<table>
			      <tbody>
			      	<tr>
			      		<td>
			      			<h4>База <br /> заказов</h4>
			      		</td>     		
			      		<td>
			      			<ul>
			      				<li>Количество: <?php echo $count ?></li>
			      				<li>На сумму: <?php echo number_format($total, 2, ',', '\'') ?> Рублей</li>
			      			</ul>
		      			</td>
			    		</tr>
			  		</tbody>
		    	</table>		    	
				</div>
				<div class="pull-right clearfix">
					<?php $this->widget('bootstrap.widgets.TbMenu', array(
				    'type'=>'pills',
				    'items'=>array(
				        array('label'=>'О проекте', 'url'=>array('/site/page', 'view'=>'about')),
				        array('label'=>'Помощь', 'url'=>array('/site/page', 'view'=>'help')),
				        array('label'=>'Правила', 'url'=>array('/site/page', 'view'=>'rules')),
				    ),
					)); ?>
				</div>

			<div id="logo">
				<a href="<?php echo $baseUrl; ?>"><img src="<?php echo $baseUrl?>/img/logo.png"></a>
			</div>
		</div>
	</div>

<div id="main-wrap" class="<?php echo $mainPage; ?>">
	<div class="container" id="page">

	<?php $this->widget('bootstrap.widgets.TbNavbar',array(
		'type'=>'inverse',
		'brand'=>false,
		'fixed' => false,
    'items'=>array(
      array(
	      'class'=>'bootstrap.widgets.TbMenu',
	      'items'=>array(
          array('label'=>'Заказчику', 'url'=>array('/site/page', 'view'=>'customer')),
          array('label'=>'Строителю', 'url'=>array('/site/page', 'view'=>'builder')),
          array('label'=>'Поставщику', 'url'=>array('/site/page', 'view'=>'supplier')), 
          array('label'=>'Выход', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),                
	      ),
      ),

    ),
)); ?>

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<div class="row">
		<?php
      $flashMessages = Yii::app()->user->getFlashes();
      if ($flashMessages) 
      {
        foreach($flashMessages as $key => $message)
        	echo '<div class="alert alert-' . $key . '"><button type="button" class="close" data-dismiss="alert">X</button>' . $message . "</div>\n";         
      }
   	?>
		<?php echo $content; ?>
	</div>

	<div class="clearfix"></div>
	</div><!-- page -->

	<div id="footer">
		<div class="container">
			&copy; <?php echo date('Y'); ?> "БилРу". Все права.
		</div>
	</div><!-- footer -->
</div>

</body>
</html>
