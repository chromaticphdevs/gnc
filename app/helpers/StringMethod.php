<?php 	

	class StringMethod
	{
		public function __construct(){}

		public function __clone(){}

		public static function _clean($string , $format = 'string')
		{	
			$validate_by;

			switch($format)
			{
				case 'string':
					$validate_by = FILTER_SANITIZE_STRING;
				break;

				case 'email':
					$validate_by = FILTER_SANITIZE_EMAIL;
				break;

				default:

				$validate_by = FILTER_SANITIZE_STRING;
			}
			return filter_var(preg_replace('/[^a-zA-Z0-9_ -]/s','',$string) , $validate_by);
		}


		public static function cleanArray($fields)
		{	
			$cleaned_array = array();

			foreach($fields as $key => $value)
			{
				$cleaned_array[$key] = StringMethod::removeTags($value);
			}

			return $cleaned_array;
		}

		public static function removeTags($value)
		{
			return strip_tags(str_replace('<script>', '', strtolower($value)));
		}
	}