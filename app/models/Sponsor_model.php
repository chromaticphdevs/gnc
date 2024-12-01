<?php

	class Sponsor_model extends Base_model
	{

		public function get_drc($user_id)
		{
			$this->db->query("SELECT * FROM commissions where c_id = :user_id and type = 'DRC'");
			$this->db->bind('user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function get_unilvl($user_id)
		{
			$this->db->query("SELECT * FROM commissions where c_id = :user_id and type = 'UNILVL'");
			$this->db->bind('user_id' , $user_id);

			return $this->db->resultSet();
		}

		public function getCommission($start , $end , $user_id)
		{
			return array(
				'drc' => $this->getDrcByDate($start , $end , $user_id), 
				'unilvl' => $this->getUnilvlByDate($start , $end , $user_id)
			); 
		}

		private function getDrcByDate($start , $end , $user_id)
		{
			$this->db->query("SELECT * FROM commissions where c_id = :user_id and type = 'DRC'
				and date(dt) between '$start' and '$end'");
			$this->db->bind('user_id' , $user_id);

			return $this->db->resultSet();
		}

		private function getUnilvlByDate($start , $end , $user_id)
		{
			$this->db->query("SELECT com.* ,o.track_no as trackno, u.username as username 
				FROM commissions  as com
				left join orders as o 
				on o.id = com.order_id 
				left join users as u 
				on u.id = o.user_id
				where c_id = :user_id and type = 'UNILVL'
				and date(com.dt) between '$start' and '$end'");
			$this->db->bind('user_id' , $user_id);

			return $this->db->resultSet();
		}
	}