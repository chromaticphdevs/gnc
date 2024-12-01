<?php 	

	class MentorCommissionModel extends Base_model
	{

		public function __construct()
		{
			$this->db  = Database::getInstance();
		}

		public function make_commission($orderid ,$fromuserid , $commissionerid , $amount , $origin = null)
		{
			if(is_null($origin)) 
			{
				$origin = 'untag';
			}
			/*get 10 percent of the amount*/
			$amount = $this->cut_amount($amount);


			$commissionerid = $this->get_mentor($commissionerid);

			try{
				
				$this->insert_into_commission_transactions($commissionerid , $fromuserid , $amount , $origin);
				Debugger::log("{$commissionerid} has been given a MENTOR");

				return true;
			}catch(Exception $e) {
				
				die($e->getMessage());

				return false;
			}
		}


		private function insert_into_commission_transactions($userid , $purchaserid, $amount , $origin)
		{
			$date = date('Y-m-d');

			$this->db->query(
				"INSERT INTO commission_transactions(userid , purchaserid , type , amount , date , origin)
				VALUES('$userid' ,'$purchaserid' ,'MENTOR' , '$amount' , '$date' , '$origin')"
			);

			try{

				$this->db->execute();

				return true;
			}catch(Exception $e) 
			{
				die($e->getMessage());

				return false;
			}
		}
		private function cut_amount($amount)
		{
			$percentage = 0.1;

			if($amount <= 0)
				return 0;
			return $percentage * $amount;
		}

		private function get_mentor($userid)
		{
			$this->db->query(
				"SELECT direct_sponsor from users where id = '$userid'"
			);

			$res = $this->db->single();


			if($res) {
				return $res->direct_sponsor;
			}return 0;
		}
	}