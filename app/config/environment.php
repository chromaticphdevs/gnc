<?php
	$env = 'local';
	//environment details
	switch($env){
		case 'local' :

			define('URL' , 'http://dev.bk_mlm');

			define('DBVENDOR' , 'mysql');
			define('DBHOST' , 'localhost');
			define('DBUSER' , 'root');
			define('DBPASS' , '');
			define('DBNAME' , 'bk_ca');
			//select your environment
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);

		break;

		case 'dev' :
			define('URL' , 'https://www.risingbonuscorp.com');
			define('DBVENDOR' , 'mysql');
			define('DBHOST' , 'localhost');
			define('DBUSER' , 'risildhm_dev');
			define('DBPASS' , 'Z{Ohp1gA?B]C');
			define('DBNAME' , 'risildhm_ecommerce');

			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		break;

		case 'prod':
			define('URL' , 'https://breakthrough-e.com');
			define('DBVENDOR' , 'mysql');
			define('DBHOST' , 'localhost');
			define('DBUSER' , 'breaqidb_dev');
			define('DBPASS' , 'z;1t6^[J7{yb');
			define('DBNAME' , 'breaqidb_ecommerce');

			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		break;

		default:

		die("Invalid Environment");

	}