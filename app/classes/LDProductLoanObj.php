<?php 	

	class LDProductLoanObj
	{

		public $id , $userid , $amount ,  $total_payment , $created_on , $date;


		public function get_balance()
		{
			$amount = $this->amount; 
			
			$total_payment = $this->total_payment;

			return $amount - $total_payment;
		}
	}

?>