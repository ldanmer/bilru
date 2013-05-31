<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('dzRaty', dirname(__FILE__).'/../extensions/DzRaty');

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
		'dzRaty.*',
	),
	'modules'=>array(
		'auth',
		'parser',		
		'backup',
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
		'authManager' => array(
				'behaviors' => array(
        	'auth.components.AuthBehavior',
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
		// uncomment the following to enable URLs in path-format
		
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
		// this is used in contact page
		'adminEmail'=>'admin@bilru.com',
	),
);