<?php

/* draw area with gallery (with control buttons, inputs for comments) and uploader */
class AdminImagesWidget extends CWidget {

	public $objectId;
	public $images;
	public $withMain = true;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.images.views');
	}

	public function run() {
		$this->registerAssets();

		if(!$this->images){
			$sql = 'SELECT id, file_name, comment, id_object, file_name_modified, is_main FROM {{images}} WHERE id_object=:id ORDER BY sorter';
			$this->images = Images::model()->findAllBySql($sql, array(':id' => $this->objectId));
		}

		$this->render('widgetAdminImages', array(
			'images' => $this->images,
		));
	}

	public function registerAssets(){
		$assets = dirname(__FILE__).'/../assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);

		if(is_dir($assets)){
			Yii::app()->clientScript->registerCssFile($baseUrl . '/styles.css');
		} else {
			throw new Exception('Image - Error: Couldn\'t find assets folder to publish.');
		}
	}
}