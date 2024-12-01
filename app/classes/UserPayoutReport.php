<?php 	

	class UserPayoutReport
	{

		public function __construct($userid)
		{
			$this->userid = $userid;

			$this->db = new Database();
		}

		public function getTotalPayout()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0) as total from payout_cheque where user_id = '$userid'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}
	}