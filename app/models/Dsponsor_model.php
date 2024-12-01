<?php

	class Dsponsor_model extends Base_model
	{

		public function get_current_commissions($user_id)
		{
			$drc    = $this->get_total_drc($user_id , TRUE);
			$unilvl = $this->get_total_unilvl($user_id , TRUE);

			return ($drc + $unilvl);
		}

		public function get_total_earnings($user_id)
		{
			$drc    = $this->get_total_drc($user_id);
			$unilvl = $this->get_total_unilvl($user_id);

			return ($drc + $unilvl);
		}

		public function get_total_mentor($user_id)
		{
			$sql = "SELECT sum(amount) as total from commissions where c_id = '$user_id'
			and type = 'MENTOR'";

			$this->db->query($sql);

			$row = $this->db->single();

			if(empty($row))
				return 0;
			return $row->total;
		}
		public function get_total_drc($user_id , $cur = false)
		{
			$this->db->query("SELECT sum(amount) as total from commissions where c_id = '$user_id' and type = 'DRC'");

			$res = $this->db->single();

			if($this->db->rowCount())
				if($res == false)
					return $this->total;
				return $res->total - $this->sumDrc_deduct($user_id);
			return 0;
		}

		public function sumDeduction($user_id)
		{
			$this->db->query("SELECT sum(amount) as total from comission_deductions 
				where user_id = '$user_id'");

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->total;
			return 0;
		}

		public function sumDrc_deduct($user_id)
		{
			$this->db->query("SELECT sum(amount) as total from comission_deductions 
				where user_id = '$user_id' and com_type = 'DRC'");

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->total;
			return 0;
		}

		public function sumUnilvl_deduct($user_id)
		{
			$this->db->query("SELECT sum(amount) as total from comission_deductions 
				where user_id = '$user_id' and com_type = 'UNILVL'");

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->total;
			return 0;
		}
		public function get_total_unilvl($user_id , $cur = false)
		{
			$this->db->query("SELECT sum(amount) as total from commissions where c_id = '$user_id' and type = 'UNILVL'");

			$res = $this->db->single();

			if($this->db->rowCount())
				if($cur == false)
					return $res->total;
				return $res->total - $this->sumUnilvl_deduct($user_id);
				
			return 0;
		}
	}