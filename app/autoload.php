<?php 
	header('Access-Control-Allow-Origin: *');
	session_start();

	spl_autoload_register(function($class) 
	{

		$class = ucfirst($class);

		$class = str_replace("\\", DIRECTORY_SEPARATOR, $class);


		$file = null;

		if(file_exists(APPROOT.DS.'core'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'core'.DS.$class.'.php';
		}
		
		else if (file_exists(APPROOT.DS.'controllers'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'controllers'.DS.$class.'.php';
		}
		else if (file_exists(APPROOT.DS.'models'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'models'.DS.$class.'.php';
		}
		else if (file_exists(APPROOT.DS.'libraries'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'libraries'.DS.$class.'.php';
		}

		else if (file_exists(APPROOT.DS.'helpers'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'helpers'.DS.$class.'.php';
		}
		else if (file_exists(APPROOT.DS.'classes'.DS.$class.'.php'))
		{
			$file = APPROOT.DS.'classes'.DS.$class.'.php';
		}


		if(!file_exists($file))
		{
			echo "$file";
		}
		require_once $file;
	});

	//** load your functions here *//

	require_once(APPROOT.DS.'functions'.DS.'url_helper.php');
	require_once(APPROOT.DS.'functions'.DS.'auth.php');
	require_once(APPROOT.DS.'functions'.DS.'token_generator.php');
	require_once(APPROOT.DS.'functions'.DS.'date_format.php');
	require_once(APPROOT.DS.'functions'.DS.'function.php');
	require_once(APPROOT.DS.'functions'.DS.'app_widget.php');
	require_once(APPROOT.DS.'functions'.DS.'render.php');
	require_once(APPROOT.DS.'functions'.DS.'arrays.php');
	require_once(APPROOT.DS.'functions'.DS.'user_interface.php');
	require_once(APPROOT.DS.'functions'.DS.'str_helper.php');
	require_once(APPROOT.DS.'functions'.DS.'device_control.php');
	require_once(APPROOT.DS.'functions'.DS.'short_models.php');
	require_once(APPROOT.DS.'functions'.DS.'module.php');
	require_once(APPROOT.DS.'functions'.DS.'user_info.php');
	require_once(APPROOT.DS.'functions'.DS.'algorithms.php');
	require_once(APPROOT.DS.'functions'.DS.'path.php');


