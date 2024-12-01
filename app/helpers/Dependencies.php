<?php 	

	class Dependencies
	{
		
		private static $depencies = [];

		public static function set($key , $values)
		{
			self::$depencies[$key] = $values;
		}


		public static function get($key)
		{
			$depencies = self::$depencies;

			if(array_key_exists($key, $depencies)) {
				return $depencies[$key];
			}
			return [];
		}
		
	}