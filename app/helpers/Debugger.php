<?php 	


	class Debugger 
	{

		private static $logs = [];

		public  static function log($logs)
		{
			self::$logs [] = $logs;

			if(Session::check('Debugger')) {

				$debugSession = Session::get('Debugger');

				$debugSession[] = $logs;

				Session::set('Debugger' , $debugSession);
			}
		}

		public  static function show_logs()
		{	
			$html = '';

			$logs = self::$logs;

			if(!empty($logs)) {

				foreach($logs as $key => $log) {

					$html .= "<p style='padding:10px; border-bottom:1px solid #000; font-weight:bold ; margin-bottom:1px'>({$key}.) {$log}</p>";
				}

				$html .= "<h1> Total of ".sizeof($logs)." Reports</h1>";
			}else
			{

				if(Session::check('Debugger')) {

					$logs = Session::get('Debugger');

					foreach($logs as $key => $row) {
						$html .= "<p style='padding:10px; border-bottom:1px solid #000; font-weight:bold ; margin-bottom:1px'>({$key}.) {$row}</p>";
					}

					$html .= "<h1> Total of ".sizeof($logs)." Reports</h1>";
				}
			}

			echo empty($logs) ? '<h1> No - Reports </h1>' : $html;

			die();
			
		}

		public static function debug($data)
		{	
			echo '<pre>';
				die(var_dump($data));
			echo '</pre>';
		}
	}