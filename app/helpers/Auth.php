<?php 	
	/*
	* This will return user information using session
	*/
	class Auth
	{	
		// static $is_logged_in = Session::check('USERSESSION') ? TRUE : FALSE ;

		static $is_logged_in = NULL;

		public static function get_instance()
		{
			if(is_null(self::$is_logged_in))
			{
				self::$is_logged_in = is_logged_in();
			}
			else{
				self::$is_logged_in = is_logged_in();
			}
		}
		public function __construct()
		{
			if(self::$is_logged_in)
			{
				// echo "OK";
			}
			else{
				// echo "FALSE";
			}
		}
		public static function user_position() : string
		{
			if(Auth::$is_logged_in)
				return Session::get('USERSESSION')['type'];
			return '';
		}
		public static function user_id() : int
		{
			if(Auth::$is_logged_in)
				return Session::get('USERSESSION')['id'];
			return '';
		}


		public static function get()
		{
			return Session::get('USERSESSION');
		}
	}