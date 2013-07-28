<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('dzRaty', dirname(__FILE__).'/../extensions/DzRaty');
require_once(dirname(__FILE__) . '/../helpers/common.php');
require_once(dirname(__FILE__) . '/../helpers/strings.php');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	//'theme'=>'bootstrap', 
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Bilru.com',
	'language'          =>'ru',

	// preloading 'log' component
	'preload'=>array('log'),	
	'behaviors' => array(
    'pageChecker' => array(
      'class' => 'application.components.PageChecker',
    )
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'application.extensions.*',
		'dzRaty.*',
		'ext.EchMultiselect.*',
		'ext.galleryManager.*',
		'ext.galleryManager.models.*',
		'ext.yii-mail.YiiMailMessage',		
		'application.modules.images.models.*',
		'application.modules.images.components.*',
		'application.modules.translateMessage.models.TranslateMessage',
	),
	'aliases' => array(
    'xupload' => 'ext.xupload'
	),
	'modules'=>array(
		'auth',
		'parser',	
		'images',
		'sendmail',
		'translateMessage',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),			
			'ipFilters'=>array('127.0.0.1','::1'),
		),
    'importcsv'=>array(
      'path'=>'files/importCsv/'
		),
	),

	// application components
	'components'=>array(
		'mail' => array(
 			'class' => 'ext.yii-mail.YiiMail',
 			'transportType' => 'php',
 			'viewPath' => 'application.views.mail',
 			'logging' => true,
 			'dryRun' => false
 		),
		'authManager' => array(
				'behaviors' => array(
        	'auth.components.AuthBehavior',
      	),      	
			),
		'widgetFactory'=>array(
      'widgets'=>array(             
        'SAImageDisplayer'=>array(
          'baseDir' => 'images',
          'originalFolderName'=> 'originals',
          'sizes' =>array(
            'tiny' => array('width' => 40, 'height' => 40),
            'thumb' => array('width' => 60, 'height' => 45),
            'middle' => array('width' => 120, 'height' => 100),
          ),
        ),
      ),
    ),
		'ePdf' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf'     => array(
                'librarySourcePath' => 'application.vendors.mpdf.*',
                'constants'         => array(
                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                ),
                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
            ),
            'HTML2PDF' => array(
                'librarySourcePath' => 'application.vendors.html2pdf.*',
                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap                
            )
        ),
    ),
    'request'=>array(
      'class' => 'application.components.EHttpRequest',
    ),
    'contentCompactor' => array(
	    'class' => 'ext.contentCompactor.ContentCompactor',
	    'options' => array(
	        '',
		    ),
		),
		'user'=>array(
        // enable cookie-based authentication
        'class' => 'auth.components.AuthWebUser',
        'allowAutoLogin'=>true,
        'admins'=>array('admin@bilru.com'),
        'loginUrl'=>array('site/login'),
        'registrationUrl'=>array('user/register'),
        'returnUrl' => array('events/index'),
        'rememberMeTime' => 2592000,
        ),
		'bootstrap'=>array(
        'class'=>'bootstrap.components.Bootstrap',
      ),  
		'image'=>array(
	    'class'=>'application.extensions.image.CImageComponent',	      
	      'driver'=>'GD',
			),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=> false, 
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bilru',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'bl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*array(
					'class'=>'CWebLogRoute',
				),*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'adminEmail'=>'admin@bilru.com',
	),
);