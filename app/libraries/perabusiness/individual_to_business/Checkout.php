<?php
	namespace PeraE\Checkout\IndividualToBusiness;

	use PeraE\Checkout\IndividualToBusiness\Core;
	use PeraE\Checkout\IndividualToBusiness\Payee;
	use PeraE\Checkout\IndividualToBusiness\Payer;
	use PeraE\Checkout\IndividualToBusiness\TransactionBody;
	use PeraE\Checkout\IndividualToBusiness\AmountValidator;
	use PeraE\Checkout\IndividualToBusiness\Authenticator;

	require_once __DIR__.'/Core.php';
	require_once __DIR__.'/Payee.php';
	require_once __DIR__.'/Payer.php';
	require_once __DIR__.'/TransactionBody.php';
	require_once __DIR__.'/AmountValidator.php';
	require_once __DIR__.'/Authenticator.php';

	class Checkout extends Core
	{
		protected $payee;

		protected $payer;

		protected $transactionBody;

		private $amountValidator;

		public $message = '';

		public $response;

		public function __construct()
		{
			$this->payer = new Payer();
			$this->payee = new Payee();
			$this->transactionBody = new TransactionBody();
			$this->amountValidator = new AmountValidator();
		}

		public function setPayee($auth)
		{	

			$this->payee->auth = $auth;

			$this->payee->authenticator->authenticate([
				'key' => $this->payee->auth['key'],
				'secret' => $this->payee->auth['secret'],
				'type'  => 'business'
			]);
		}


		public function getPayee()
		{
			return $this->payee->auth;
		}

		public function setPayer($auth)
		{
			//individual
			$this->payer->auth = $auth;

			$this->payer->authenticator->authenticate([
				'key' => $this->payer->auth['key'],
				'secret' => $this->payer->auth['secret'],
				'type'  => 'individual'
			]);
		}

		public function getPayer()
		{
			return $this->payer->auth;
		}


		public function setBody($params)
		{
			$this->transactionBody->setAmountBreakdown($params['amountBreakdown'])
			->setReferenceId($params['referenceId'])
			->setLinks( $params['links'] )
			->setDomain( $params['domain'] )
			->setOrigin( $params['origin'] );
		}


		public function send()
		{
			//do checks

			//authentication checking

			$isIndividualAuth = $this->payer->authenticator->isAuthenticated();

			$isBusinessAuth = $this->payer->authenticator->isAuthenticated();

			if($isIndividualAuth && $isBusinessAuth)
			{
				$amountBreakdown = $this->transactionBody->getAmountBreakDown();
				
				/*
				*Payer check balance this check is not needed
				*for what use?
				*/
				// $res = $this->amountValidator->setComparable( $this->payer->getBalance() , 
				// 	$amountBreakdown['amount'] );

				// if(!$res) {
				// 	$this->addError( implode(',', $this->amountValidator->errors) );
				// }

				if( empty($this->getErrors())) 
				{

					$this->transactionBody->setPayer($this->payer->auth)
					->setPayee($this->payee->auth);


					$payloads = $this->transactionBody->payloads();

					$res = $this->restPostCall(
						'api/IndividualToBusiness/send' , [
							'payload' => json_encode($payloads)
						]
					);

					$this->response = $res;
					$this->message = " Payment sent !";
					return true;
					
				}else{
					return false;
				}
			}
		}
	}