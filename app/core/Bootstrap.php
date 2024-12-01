<?php

	class Bootstrap{

		private $current_controller = BASECONTROLLER;
		private $current_method = BASEMETHOD;
		private $params = []; //parameters of the request to be passed on the functions

		public function __construct()
		{


			$url = $this->getURL();

			if( $url !== FALSE ) {
				//check for controller
				if(isset($url[0])){
					if(file_exists( '../app/controllers/'.ucwords($url[0]).'.php' )){

						$this->current_controller = ucwords($url[0]);
						unset($url[0]);
					}


					require_once('../app/controllers/'.$this->current_controller.'.php');

					$this->current_controller = new $this->current_controller;
				}

				if(isset($url[1])){

					if(method_exists($this->current_controller, strtolower($url[1])))
					{
						$this->current_method = $url[1];
						unset($url[1]);
					}
				}

				//check if there is still remaining url parameters
				$this->params = $url ? array_values($url) : [];

				call_user_func_array([$this->current_controller , $this->current_method] , $this->params); 
			}
			//if URL IS NOT SET THEN THE base controller and the base action will be thrown
			else{	
				require_once('../app/controllers/'.$this->current_controller.'.php');
				
				$this->current_controller = new $this->current_controller;

				$this->current_method = $this->current_method;

				call_user_func_array([$this->current_controller , $this->current_method] , $this->params);
			}
		}

		private function getURL(){

			if(isset($_GET['url'])){

				$url = $_GET['url']; $url = rtrim($url , '/');

	            $url = filter_var($url , FILTER_SANITIZE_URL); 
	            $url = explode('/',$url);

	            return $url;
			}

			else{
				return FALSE;
			}
		}
	}