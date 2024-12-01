<?php namespace Bank;

	use Bank\IBank;

	require_once CLASSES.DS.'banks/IBank.php';

	class Pera implements IBank
	{

		public $error = '';
		
		protected $response;

		// protected $endPoint = 'http://dev.pera';
		// protected $endPoint = 'https://staging.pera-e.com';

		protected $endPoint = 'https://pera-e.com';

		public function connectAuth($key , $secret)
		{
			$endPoint = $this->endPoint.'/api/ConnectAccount/connect';

			$dataParam = [
				'apiKey' => $key,
				'apiSecret' => $secret
			];

			$response = api_call('POST' , $endPoint, $dataParam);

			$responseData = json_decode($response);

			if($responseData->status){
				$this->apiKey = $key;
				$this->apiSecret = $secret;
			}else{
				$this->error = $responseData->data;
			}

			return $responseData->status;
		}

		public function registerAuth($key , $secret)
		{
			$endPoint = $this->endPoint.'/api/ConnectAccount/connect';

			$dataParam = [
				'apiKey' => $key,
				'apiSecret' => $secret
			];

			$response = api_call('POST' , $endPoint, $dataParam);

			if($response) 
			{
				$this->response = json_decode($response);

				if(! $this->response->status) {
					$this->error = $this->response->data;
				}
			}else{
				$this->response = false;
				$this->error = "Something went wrong with the connection";
			}
			
		}

		public function response()
		{
			return $this->response;
		}

		/*
		*@params
		*amount
		*description
		*control_number <- use for tracing back
		*/
		public function sendMoney($amount , $controlNumber , $description)
		{
			try
			{	
				$endPoint = $this->endPoint.'/api/Wallet/save';


				$transferData = [
					'amount'        => $amount,
					'controlNumber' => $controlNumber,
					'description'   => $description,
					'domain'        => 'Breakthrough-e',
					'apiKey'        => $this->apiKey,
					'apiSecret'     => $this->apiSecret,
					'endpoint'      => $endPoint
				];
				
				$walletStored = api_call('POST' , $endPoint , $transferData);
				
				if(!$walletStored) {
					$this->error = " Something wen't wrong to the third party";
					return false;
				}else{
					return true;
				}

			}catch(Exception $e)
			{
				$this->error = $e->getMesage();
				return false;
			}
		}

		public function deductMoney($amount , $controlNumber , $description)
		{
			try
			{	
				$endPoint = $this->endPoint.'/api/Wallet/payment';


				$transferData = [
					'amount'        => $amount,
					'controlNumber' => $controlNumber,
					'description'   => $description,
					'domain'        => 'Breakthrough-e',
					'apiKey'        => $this->apiKey,
					'apiSecret'     => $this->apiSecret,
					'endpoint'      => $endPoint
				];
				
				$walletStored = api_call('POST' , $endPoint , $transferData);
			
				return $walletStored;
				

			}catch(Exception $e)
			{
				$this->error = $e->getMesage();
				return false;
			}
		}
	}