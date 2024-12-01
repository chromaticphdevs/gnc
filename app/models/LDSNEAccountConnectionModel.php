<?php 	

	class LDSNEAccountConnectionModel extends Base_model
	{

		public function get_account_on_sne($dbbid)
		{
			$this->db->query(
				"SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users where dbbi_id = '$dbbid'"
			);
			
			return $this->db->single();
		}
	}