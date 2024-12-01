<?php 	
	namespace PeraE\Checkout\IndividualToBusiness;

	use PeraE\Checkout\IndividualToBusiness\Core;

	class Payee extends Core
	{
		public $auth;
		public $authenticator;


		public function __construct()
		{
			$this->authenticator = new Authenticator();
		}


		public function getBalance()
		{
			if( $this->authenticator->isAuthenticated() )
			{
				return 600000;
				//get user

				// $this->restPostCall('api/user');
			}
		}
	}