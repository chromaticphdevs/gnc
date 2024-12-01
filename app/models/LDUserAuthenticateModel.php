<?php 	

	class LDUserAuthenticateModel extends Base_model
	{

		public function email_phone_login($email , $phone)
		{
			$this->db->query(
				"SELECT * FROM ld_users where email = '{$email}' and phone = '$phone'"
			);

			return $this->db->single();
		}
	}