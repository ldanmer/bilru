<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.printElement.min.js') ?>
<a onclick="$('#print').printElement({
            leaveOpen:true,
            printMode:'popup',
            overrideElementCSS:['<?php echo Yii::app()->baseUrl?>/css/bootstrap.min.css',{ href:'<?php echo Yii::app()->baseUrl?>/css/styles.css',media:'print'}]
            })" class="span3 nonprint btn btn-primary">Печать</a>
<?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'url'=>array('bill/pdf'),
            'type'=>'primary',
            'label'=>'Сохранить',  
            'htmlOptions'=>array('class'=>'span3 nonprint pull-right'),         
          ));
 ?>
<br><br>
 <?php $this->renderPartial('bill-template',array('bill'=>$bill)); ?>