<?php 	

	class AccountsDbbiModel extends Base_model 
	{

		public function get_list()
		{
			$this->db->query(
				"SELECT * FROM users where dbbi_id != ''"
			);

			return $this->db->resultSet();
		}
	}