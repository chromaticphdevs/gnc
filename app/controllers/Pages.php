<?php

	class Pages extends Controller
	{
		public function howToHaveAnAccount()
		{
			$this->view('pages/howToHaveAnAccount');
		}

		public function index()
		{
			//disable page
			if(SITE_NAME === 'SIGN-UP PH') {
				die(" You are not supposed to be here");
			}

			return $this->landingPage();
		}
		public function landingPage()
		{
			// return $this->view('templates/base/base');
			return $this->view('pages/landing');
		}
	}
