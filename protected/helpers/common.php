<?php
function param($name, $default = null) {
	if (isset(Yii::app()->params[$name])) {
		return Yii::app()->params[$name];
	} else {
		return $default;
	}
}

function tc($message) {
	return Yii::t(TranslateMessage::DEFAULT_CATEGORY, $message);
}
?>