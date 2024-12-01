<?php 	

	class PayoutchequeModel extends Base_model 
	{

		public function getList($userid)
		{
			$this->db->query(
				"SELECT payout_cheque.*  , date_from , date_to 
				
				FROM payout_cheque 

				left join payouts on payouts.id = payout_cheque.payout_id

				where user_id = '$userid'"
			);

			return $this->db->resultSet();
		}


		public function getCheque($chequeid)
		{
			$this->db->query(
				"SELECT * FROM payout_cheque where id = '$chequeid'"
			);

			
			return $this->db->single();
		}
	}