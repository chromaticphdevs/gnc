<?php 	
	namespace PeraE\Checkout\IndividualToBusiness;

	use PeraE\Checkout\IndividualToBusiness\Core;

	require_once __DIR__.'/Core.php';

	class Authenticator extends Core
	{

		private $error;

		private $isAuthenticated = false;

		public function authenticate($auth = [])
		{
			$key = $auth['key'];
			$secret = $auth['secret'];

			if(strtolower($auth['type']) == 'business')
			{
				//authenticate business

				$response = $this->restPostCall('api/BusinessAccount/authenticate' , [
					"key" => $key,
					"secret" => $secret
				]);

				if(!$response){
					$this->addError("Payee Authentication failed");
					return false;
				}

				$this->isAuthenticated = true;

				return true;
			}

			if( strtolower($auth['type']) == 'individual')
			{
				$response = $this->restPostCall('api/UserMeta/authenticate' , [
					"key" => $key,
					"secret" => $secret
				]);

				if(!$response){
					$this->addError("Payer Authentication Failed");
					return false;
				}

			 $this->isAuthenticated = true;

				return true;
			}
		}

		/*
		*keys allowed
		*[individual , business]
		*/
		public function isAuthenticated()
		{
			return $this->isAuthenticated;
		}
	}