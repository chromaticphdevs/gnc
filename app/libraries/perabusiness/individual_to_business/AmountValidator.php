<?php  	
	namespace PeraE\Checkout\IndividualToBusiness;

	class AmountValidator
	{
		public $errors = [];
		
		public function setComparable($balance , $amountToSend)
		{
			//balance and amount to send must be valid number
			if( !is_numeric($balance))
				$this->errors[] = " Balance must be a valid number ";

			if( !is_numeric($amountToSend)){
				$this->errors[] = " Amount to send must be a valid number";
			}else{
				if($amountToSend <= 0)
					$this->errors[] = "Amount to pay must not be 0.00 or less";
			}
				

			if(!empty($errors))
				return false;

			return $this->compare( $balance , $amountToSend);
		}


		//compare amount

		private function compare($balance , $amountToSend)
		{
			if( $balance >= $amountToSend)
				return true;

			$this->errors[] = "Insufficient balance";
			return false;
		}
	}