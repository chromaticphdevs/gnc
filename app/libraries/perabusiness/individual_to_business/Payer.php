<?php 	
	namespace PeraE\Checkout\IndividualToBusiness;
	
	use PeraE\Checkout\IndividualToBusiness\Core;

	require_once __DIR__.'/Core.php';

	class Payer extends Core
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
				return 60000;
				//get user

				// $this->restPostCall('api/user');
			}
		}
	}