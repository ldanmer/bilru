<?php 
class FileController extends CController
{	
	public function actionUpload()
	{		
		$uploadDir = '/files/docs_upload/'.Yii::app()->user->id.'/';
		GetName::makeDir($uploadDir);
		$absoluteDir = Yii::getPathOfAlias('webroot') . $uploadDir;

		$file=CUploadedFile::getInstanceByName('file');
		if($file)
		{
			$fileName = GetName::translit($file->name);
			$file->saveAs($absoluteDir.$fileName);
		}

		$array = array('filelink' => Yii::app()->baseUrl.$uploadDir.$fileName);
		echo stripslashes(CJSON::encode($array));
	}

	public function actionList()
	{
		$uploadDir = '/files/docs_upload/'.Yii::app()->user->id.'/';
		$absoluteDir = Yii::getPathOfAlias('webroot') . $uploadDir;
		$files = CFileHelper::findFiles($absoluteDir,array('fileTypes'=>array('gif','png','jpg','jpeg')));
		$data=array();
		if ($files) {
			foreach($files as $file) {
				$data[]=array(
					'thumb'=>Yii::app()->baseUrl.$uploadDir.basename($file),
					'image'=>Yii::app()->baseUrl.$uploadDir.basename($file),
				);
			}
		}
		echo CJSON::encode($data);
	}
}



 ?>