<?php 	
	namespace Business;

	use Business\Connect;
	use Business\AmountValidator;
	
	require_once __DIR__.'/Connect.php';
	require_once __DIR__.'/AmountValidator.php';

	class Business extends Connect
	{
		private $intent = 'BUSINESS_TO_INDIVIDUAL_TRANSFER';

		private $auth = [];

		private $meta = [];

		private $origin = [
			'senderDomain'   => 'sender tmp',
			'recieverDomain' => 'reciever tmp'
		];

		private $recipient = [];

		private $amount = 0;

		private $amountValidator;


		public function __construct()
		{
			$this->amountValidator = new AmountValidator();
		}

		public function send()
		{
			$dataStructure = [
				'intent' => $this->intent,

				'auth'   => $this->auth,

				'meta' => $this->meta,

				'origin' => $this->origin,

				'recipient' => $this->recipient,
				
				'amount' => $this->amount
  			];	  
			//validate entry;
			$isValid = $this->authenticate( $this->auth['key'] , $this->auth['secret']);


			if(!$isValid){
				return die( var_dump( $this->getErrors() ) );
			}

			$isValidAmount = $this->amountValidator->validate( $this->amount );


			if(! $isValidAmount ) {
				return die( var_dump( $this->amountValidator->getErrors() ) );
			}

			$response = $this->restPostCall('api/BusinessToIndividual/send' , [
				'data' => json_encode($dataStructure)
			]);

			$responseData = json_decode($response->data);

			if($response->status) 
			{
				$this->addMessage( $responseData->message );
				return true;
			}else{
				$this->addError( implode(',', $responseData->errors) );
				return false;
			}
		}

		public function setAmount($amount)
		{
			$this->amount = $amount;
		}

		public function setMeta($params)
		{
			$this->meta = [
				'description' => $params['description'],
				'controlNumber' => $params['controlNumber']
			];
		}

		public function setOrigin($params)
		{
			$this->origin = [
				'senderDomain'   => 'BREAKTHROUGH-E.com',
				'recieverDomain' => 'PERA-E.com'
			];
		}
		public function setRecipient($params)
		{
			$this->recipient = [
				'mobileNumber' => $params['mobileNumber'],
				'firstname'    => $params['firstname'],
				'lastname'     => $params['lastname']
			];
		}

		public function init($params)
		{
			$this->auth = [
				'key' => $params['key'],
				'secret' => $params['secret']
			];
		}


		public function isAuthenticated()
		{
			$isValid = $this->authenticate( $this->auth['key'] , $this->auth['secret']);
			return $isValid;
		}

	}