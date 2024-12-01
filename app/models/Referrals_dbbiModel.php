<?php 	

	class Referrals_dbbiModel extends Base_model
	{
		public function __construct()
		{		
			parent::__construct();
		}
		public function list($userID)
		{
			$this->db->query(
				"SELECT * FROM pre_register_users  WHERE referral_id='$userID' ORDER BY `pre_register_users`.`created_at` DESC"
			);

			return $this->db->resultSet();
		}

	}