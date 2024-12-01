<?php 	
	namespace PeraE\Checkout\IndividualToBusiness;

	
	class TransactionBody
	{
		
		private $amountBreakdown;
		private $referenceId;
		private $links;
		private $domain;
		private $origin;

		private $payer;
		private $payee;

		/*
		*Amount Breakdown
		*Array
		*/
		public function setAmountBreakdown( $amountBreakdown )
		{
			$this->amountBreakdown = $amountBreakdown;
			return $this;
		}

		public function getAmountBreakdown()
		{
			return $this->amountBreakdown;
		}

		public function setReferenceId( $referenceId )
		{
			$this->referenceId = $referenceId;
			return $this;
		}

		public function getReferenceId()
		{
			return $this->referenceId;
		}

		public function setLinks( $links )
		{
			$this->links = $links;
			return $this;
		}

		public function getLinks()
		{
			return $this->links;
		}

		public function setDomain($domain)
		{
			$this->domain = $domain;
			return $this;
		}

		public function getDomain($domain)
		{
			return $this->domain;
		}

		public function setOrigin($origin)
		{
			$this->origin = $origin;
			return $this;
		}

		public function getOrigin($origin)
		{
			return $this->origin;
		}

		public function setPayer($payer)
		{
			$this->payer = $payer;
			return $this;
		}

		public function getPayer($origin)
		{
			return $this->payer;
		}

		public function setPayee($payee)
		{
			$this->payee = $payee;
			return $this;
		}

		public function getPayee()
		{
			return $this->payee;
		}

		public function payloads()
		{
			return [
				'amountBreakdown' => $this->amountBreakdown,
				'referenceId'     => $this->referenceId,
				'links'           => $this->links,
				'domain'          => $this->domain,
				'origin'          => $this->origin,
				'payer'           => $this->payer,
				'payee'           => $this->payee
			];
		}
	}