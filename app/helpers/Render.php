<?php   

    class Render
    {
		static $buildInstance = 0;

		static $builds = [];
		static $variables = [];


		public static function addBuild($varName)
		{
			$buildInstance = self::$buildInstance;

			self::$variables[$buildInstance] = $varName;
		}

		public static function build($build)
		{
			/** GET BUILD NUMBER INSTANCE */
			$buildInstance = self::$buildInstance;
			/** GET BUILD NAME FOR THAT INSTANCE */
			$buildName = self::$variables[$buildInstance];
			/** STORE THE BUILD TO THE NAME */
			self::$builds[$buildName] = $build;
		}
		
		public static function show($buildName)
		{
			echo self::$builds[$buildName] ?? '';
		}
    }