<?php 
	$count = Goszakaz::model()->count() + Orders::model()->count() + MaterialBuy::model()->count();
	$total = Goszakaz::model()->totalPrice();
	$baseUrl = Yii::app()->baseUrl; 
	$mainPage = (
			Yii::app()->checkSpecifiedPage('homepage') 
			|| Yii::app()->checkSpecifiedPage('login') 
			|| Yii::app()->checkSpecifiedPage('register')
			|| Yii::app()->checkSpecifiedPage('recovery')
		) ? 'mainpage' : '';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />   
	<link rel="shortcut icon" href="<?php echo $baseUrl; ?>/img/favicon.ico" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
	<?php 
	 
	  $cs = Yii::app()->getClientScript();
	  $cs->registerCssFile($baseUrl.'/css/styles.css');
	  $cs->registerScriptFile($baseUrl.'/js/jquery.carousel.js');
	  $cs->registerScriptFile($baseUrl.'/js/multiselect.js');
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
			      				<li>Количество: <strong><?php echo $count ?></strong></li>
			      				<li>На сумму: <strong><?php echo number_format($total, 2, ',', ' ') ?></strong> руб.</li>
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
				        array('label'=>'Контакты', 'url'=>array('/site/contact')),
				    ),
					)); ?>
				</div>

			<div id="logo">
				<?php echo CHtml::link(CHtml::image($baseUrl."/img/logo.png"), array((!Yii::app()->user->isGuest) ? 'events/index' :'site/index')) ?>
			</div>
		</div>
	</div>
		<div id="grey-top"></div>
		<?php $this->widget('bootstrap.widgets.TbNavbar',array(
		'type'=>'inverse',
		'brand'=>false,
		'fixed' => false,
    'items'=>array(
      array(
	      'class'=>'bootstrap.widgets.TbMenu',
	      'items'=>array(
	      	array('label'=>'Главная', 'url'=>array('/site/index'), 'visible'=>!Yii::app()->checkSpecifiedPage('homepage')),
          array('label'=>'Заказчику', 'url'=>array('/site/page', 'view'=>'customer'), 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Строителю', 'url'=>array('/site/page', 'view'=>'builder'), 'visible'=>Yii::app()->user->isGuest),
          array('label'=>'Поставщику', 'url'=>array('/site/page', 'view'=>'supplier'), 'visible'=>Yii::app()->user->isGuest), 
          array('label'=>'Мои объекты', 'url'=>array('/objects/index'), 'visible'=>!Yii::app()->user->isGuest),
          array('label'=>'Мой профиль', 'url'=>array('/user/main'), 'visible'=>!Yii::app()->user->isGuest),
          array('label'=>'Выход', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),                
	      ),
      ),
    ),
    'htmlOptions'=>array('class'=>'container'),
)); ?>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'htmlOptions'=>array('id'=>'bread', 'class'=>'container'),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

<div id="main-wrap" class="<?php echo $mainPage; ?>">
	<div class="container" id="page">
	
	<div class="row">	
	<?php echo Yii::app()->checkSpecifiedPage('homepage') ? CHtml::image($baseUrl."/img/objava.png", '', array('style'=>'position:fixed; margin-left:22.5%')) : ""; ?>
		<?php echo $content; ?>
	</div>

	<div class="clearfix"></div>
	</div><!-- page -->

	<div id="footer">
		<div class="container">
			&copy; <?php echo date('Y'); ?> "БилРу". Все права защищены.
		</div>
	</div><!-- footer -->
</div>
<!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter21493792 = new Ya.Metrika({id:21493792, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/21493792" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->

</body>
</html>
