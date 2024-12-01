<?php 	

	class UserMaxpairModel extends Base_model
	{
		private $table_name = 'users';

		public function update_pair($userid , $pair) 
		{
			$this->db->query(
				"UPDATE $this->table_name set max_pair = (max_pair + $pair) 
				where id = '$userid'"
			);

			return $this->db->execute();
		}

		private function get_pair($userid)
		{
			$this->db->query(
				"SELECT max_pair from users where id = '$userid'"
			);
			return $this->db->single()->max_pair;
		}
	}