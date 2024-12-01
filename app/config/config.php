<?php

	$allowedSites = ['signup-e.com' , 'breakthrough-e.com' , 'champion-innovation.com'];
	
	define('DS', DIRECTORY_SEPARATOR);
	//application root
	define('APPROOT' , dirname(dirname(__FILE__)));
	define('PUBLIC_ROOT' , dirname(dirname(dirname(__FILE__))).'/public');
	define('BASE_DIR', dirname(dirname(dirname(__FILE__))));
	//core root
	define('CORE' , APPROOT.DS.'core');
	//models
	define('MODELS' , APPROOT.DS.'models');
	//views
	define('VIEWS' , APPROOT.DS.'views');
	//controllers
	define('CNTLRS' , APPROOT.DS.'controllers');
	//helpers root
	define('HELPERS', APPROOT.DS.'helpers');
	//library
	define('LIBS' , APPROOT.DS.'libraries');
	//funtions
	define('FNCTNS' ,  APPROOT.DS.'functions');

	define('CLASSES' ,  APPROOT.DS.'classes');
	//base controller

	define('BASECONTROLLER' , 'Pages');
	define('BASEMETHOD' , 'index');

	//set timezone

	date_default_timezone_set("Asia/Manila");

	// ITEXMO API for 100 text a Day
	//ST-BREAK884834_7FXX1


	// ITEXMO API for 300 text a Day
	//ST-BREAK884834_9B23N
	//old api
	//define('ITEXMO', 'ST-BREAK884834_9B23N');
	//define('ITEXMO_PASS', '5!(&edet6b');

	// ITEXMO API for 300 text a Day this is for 1 month
	//ST-BREAK884834_MERSX
	define('CSR_TYPE' , 'customer-service-representative');
	define('STOCK_MANAGER_TYPE' , 'stock-manager');
	