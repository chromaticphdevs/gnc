<?php 	

	class Transaction_model extends Base_model{

		private $tbl_binary_pv = 'binary_pvs';

		//set limit to get recent transactions
		public function get_bv_commissions(int $user_id , $limit = null)
		{	
			//get commisioner
			$sql;
			if($limit !== null)
			{
				$sql = "SELECT * FROM $this->tbl_binary_pv where c_id = :user_id order by id desc limit :limiter";

				$this->db->bind(':user_id' , $user_id);
				$this->db->bind(':limiter' , $limit);
			}else{

				$this->db->query("
					SELECT * FROM $this->tbl_binary_pv 
					where c_id = :user_id"
				);

				$this->db->bind(':user_id' , $user_id);

			}
			
			return $this->db->resultSet();
		}
		//set limit to get recent direcsponsrs
		public function get_ds_commissions(int $user_id , $limit = null)
		{

			$sql;

			if($limit !== null)
			{
				$this->db->query("SELECT * FROM commissions 
					where c_id = :user_id order by id desc limit :limiter"
				);
				$this->db->bind(':user_id' , $user_id);
				$this->db->bind(':limiter' , $limit);
			}else{

				$this->db->query("SELECT * FROM commissions 
					where c_id = :user_id"
				);

				$this->db->bind(':user_id' , $user_id);

			}
			
			return $this->db->resultSet();
		}

		public function get_recent_transactions($user_id , $limit = null)
		{	

			$transactions = [];

			if($limit != null)
			{

				$transactions['bv_commissions'] = $this->get_bv_commissions($user_id , $limit);

				$transactions['ds_commissions'] = $this->get_ds_commissions($user_id , $limit);
			}else{

				$transactions['bv_commissions'] = $this->get_bv_commissions($user_id);

				$transactions['ds_commissions'] = $this->get_ds_commissions($user_id);
			}

			return $transactions;
		}
	}