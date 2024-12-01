<?php 	

	/*PENDING CLASS*/

	class Router
	{
		private static $routes = [];

		public static function define($routes)
		{
			$this->routes[] = $routes;
		}

		public function route()
		{
			
		}
	}
?>