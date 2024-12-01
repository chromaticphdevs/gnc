<?php 
	class Request{


		public static function get(){

			if( strtoupper($_SERVER['REQUEST_METHOD']) === 'POST') {

				return 'POST';
			}
			else{
				return 'GET';
			}
		}
	}
?>