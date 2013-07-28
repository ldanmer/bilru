<?php
/**********************************************************************************************
*                            CMS Open Real Estate
*                              -----------------
*	version				:	1.5.0
*	copyright			:	(c) 2013 Monoray
*	website				:	http://www.monoray.ru/
*	contact us			:	http://www.monoray.ru/contact
*
* This file is part of CMS Open Real Estate
*
* Open Real Estate is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Real Estate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/

/* draw gallery with control buttons, inputs for comments */
class AdminViewImagesWidget extends CWidget {

	public $objectId;
	public $images;
	public $withMain = true;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.images.views');
	}

	public function run() {
		if(!$this->images){
			$sql = 'SELECT id, file_name, comment, id_object, file_name_modified, is_main FROM {{images}} WHERE id_object=:id ORDER BY sorter';
			$this->images = Images::model()->findAllBySql($sql, array(':id' => $this->objectId));
		}

		$this->render('widgetAdminViewImages', array(
			'images' => $this->images,
		));
	}
}