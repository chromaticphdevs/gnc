<?php 	

	class LDCashloanObj
	{
		public $id , $userid , $groupid,
		$amount , $total_payment , $date, $time , $approved_by , 
		$status , $notes , $created_on;

		public function get_principal()
		{
			$amount = $this->amount;

			return $amount / 25;
		}


		public function get_interest()
		{
			$amount = $this->amount;

			return ($amount * 0.05) / 4;
		}

		public function get_total()
		{
			$principal = $this->get_principal();
			$interest  = $this->get_interest();


			return $principal + $interest;
		}

		public function get_balance()
		{
			$amount = $this->amount; 
			$total_payment = $this->total_payment;

			return $amount - $total_payment;
		}
	}