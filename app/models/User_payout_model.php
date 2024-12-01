<?php

	class User_payout_model extends Base_model
	{
		public function getPayouts(int $user_id)
		{
			$this->db->query(
				"SELECT pc.id as pc_id , p.id as p_id , date_from , date_to , pc.amount as pc_amount , pc.status as pc_status 
				from payout_cheque as pc 
				left join payouts as p 
				on pc.payout_id = p.id

				where pc.user_id = :user_id and 

				date_from != '0000-00-00' and date_to != '0000-00-00' order by date_from"
			);

			$this->db->bind(':user_id' , $user_id);


			return $this->db->resultSet();
		}

		public function getPayoutUser($cheque_id)
		{
			$this->db->query(
				"SELECT pc.id as pc_id , date_from , date_to ,pc.user_id as user_id, pc.amount as pc_amount , pc.status as pc_status 
				from payout_cheque as pc 
				left join payouts as p 
				on pc.payout_id = p.id

				where pc.id = :cheque_id and 

				date_from != '0000-00-00' and date_to != '0000-00-00' order by date_from"
			);

			$this->db->bind(':cheque_id' , $cheque_id);


			return $this->db->single();
		}

		public function getPayoutId($payout_id , $user_id)
		{
			$res = $this->getPayoutUser($payout_id);
			if(empty($res))
			{
				return 0;	
			}else if($res->user_id != $user_id)
			{	
				Flash::set('trying to access unauthorized data');
				return false;
			}else{
				return $res;
			}
		}
	}