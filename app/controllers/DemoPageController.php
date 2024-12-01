<?php

	class DemoPageController extends Controller
	{
		public function index()
		{
			//disable page
			if(SITE_NAME === 'SIGN-UP PH') {
				die(" You are not supposed to be here");
			}

			$view = $_GET['view'] ?? 'landing';

			if( $view == 'landing') {
				return $this->landingPage();
			}else{
				return $this->loginPage();
			}
		}
		public function landingPage()
		{
			return $this->view('templates/demo/landing');
		}

		public function loginPage()
		{
			return $this->view('templates/demo/login');
		}
	}
