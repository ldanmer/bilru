<?php

	echo '<div class="images-area-admin">';
	if($this->images){
		$this->widget('application.modules.images.components.AdminViewImagesWidget', array(
			'objectId' => $this->objectId,
			'images' => $this->images,
			'withMain' => $this->withMain,
		));
	} else {
		echo '<strong>Фото галерея пуста</strong>';
	}
	echo '</div>';



	$this->widget('ext.EAjaxUpload.EAjaxUpload',
	array(
		'id'=>'uploadFile',
		'config'=>array(
			'action' => Yii::app()->createUrl('/images/main/upload', array('id' => $this->objectId)),
			'allowedExtensions'=> param('allowedImgExtensions', array('jpg', 'jpeg', 'gif', 'png')),
			//'sizeLimit' => param('maxImgFileSize', 8 * 1024 * 1024),
			'sizeLimit' => Images::getMaxSizeLimit(),
			'minSizeLimit' => param('minImgFileSize', 5*1024),
			'multiple' => true,

			'onComplete'=>"js:function(id, fileName, responseJSON){ reloadImagesArea(); }",
			/*'onSubmit' => 'js:function(id, fileName){  }',*/
			'messages'=>array(
				'typeError'=>"{file} имеет некорректное расширение. Допустимы только следующие расщирения: {extensions}",
				'sizeError'=>"{file} слишком велик. Максимальный допустимый размер файла: {sizeLimit}.",
				'minSizeError'=>'{file} слишком мал. Минимальный допустимый размер файла: {minSizeLimit}',
				'emptyError'=>'Файл {file} пустой. Пожалуйста, повторите выбор без этого файла.',
				'onLeave'=>'В данный момент происходит загрузка файлов. Если вы сейчас покините страницу, то загрузка будет прервана.',
			),
			//'showMessage'=>"js:function(message){ alert(message); }"
		)
	));

	$this->widget('ext.charcounter.CharCounter', array(
		'target' => '.image-comment-input > textarea',
		'count' => 255,
		'config' => array(
			'container' => '<div></div>',
			'format' => CJavaScript::quote('символов осталось').': %1',
		),
	));

	Yii::app()->clientScript->registerScript('images-reloader', '
		function reInitJs(){
			$(".images-area-admin .fancy").fancybox();
			$(".image-comment-input > textarea").charCounter(255, {
				container: "<div></div>",
				format: "'.CJavaScript::quote('символов осталось').': %1"
			});
			if($(".images-area").find(".image-item").length == 0){
				$(".images-area-admin").html("'.CJavaScript::quote('Галерея пуста').'");
			}
		}

		$(".setAsMainLink").live("click", function(){
			var id = $(this).closest(".setAsMain").attr("link-id");
			$.ajax({
				url: "'.Yii::app()->controller->createUrl('/images/main/setMainImage').'?id="+id,
				success: function(data){
					$(".setAsMain", ".images-area").html("<a class=\"setAsMainLink\" href=\"#\">главное фото</a>");
					$(".setAsMain[link-id=\'" + id + "\']").html("'.CJavaScript::quote('Главное фото').'");
				}
			});
			return false;
		});

		$(".deleteImageLink").live("click", function(){
			var id = $(this).attr("link-id");
			$.ajax({
				url: "'.Yii::app()->controller->createUrl('/images/main/deleteImage').'?id="+id,
				success: function(result){
					$("#image_"+id).remove();
					if(result){
						$(".setAsMain[link-id=\'" + result + "\']").html("'.CJavaScript::quote('Главное фото').'");
					}
					reInitJs();
				}
			});
			return false;
		});

		function reloadImagesArea(){
			$.ajax({
				url: "'.Yii::app()->controller->createUrl('/images/main/getImagesForAdmin', array('id' => $this->objectId)).'",
				success: function(data){
					$(".image-comment-input > textarea", data).each(function(){
						var name;
						name = $(this).attr("name");

						if($(".images-area").find("textarea[name=\'" + name + "\']").length == 0){
							var toAdd = $(this).closest(".image-item");
							if($(".images-area > .clear").length){
								$(".images-area > .clear").before(toAdd);
							} else {
								$(".images-area-admin").empty();
								$(".images-area-admin").append("<div class=\"images-area\"></div>");
								$(".images-area").append(toAdd);
								$(".images-area").append("<div class=\"clear\"></div>");
							}
						}
					});
					reInitJs();
				}
			});
		}
	', CClientScript::POS_END);

	Yii::app()->clientScript->registerCoreScript('jquery.ui');
	Yii::app()->clientScript->registerScript('sortable', '
			$(".images-area-admin").sortable({
				forcePlaceholderSize: true,
				forceHelperSize: true,
				items: ".image-item",
				handle: ".image-drag-area",
				placeholder: "ui-sortable-placeholder",
				update : function () {
					serial = $(".images-area-admin").sortable("serialize", {key: "image[]", attribute: "id"});
					$.ajax({
						"url": "'. Yii::app()->controller->createUrl('/images/main/sort', array('id' => $this->objectId)).'",
						"type": "post",
						"data": serial,
						"success": function(data){

						},
					});
				}
			}).find(".image-item-drag").disableSelection();
			$(".image-item-drag").disableSelection();
		');

