<?php 	

	class ManagerModel extends Base_model
	{
		private $table_name = 'manager_accounts';


		public function login($username , $password)
		{

			$result = $this->get_user_by_username($username);


			if(!empty($result)) {

				if(!password_verify($password, $result->password)) {

					Flash::set("Incorrect Password");
					return false;
				}
			}else{

				Flash::set("User {$username} does not exists" , 'warning');
			}

			return $result;
		}


		public function get_by_user($username)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name 
					WHERE username = '$username' AND password = '$password'"
			);

			$result = $this->db->single();
		}

		public function create_account($managerInformations)
		{
			extract($managerInformations);


			$getUsername = $this->get_user_by_username($username);

			if($getUsername){

				Flash::set("Username already exists" , 'info');
				return false;
			}

			$status = 'active';


			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$this->db->query(
				"INSERT INTO $this->table_name(type , fullname , username , password , branchid , status)
				VALUES('$type' , '$fullname' , '$username' , '$password' , '$branch' , '$status')"
			);

			return
				$this->db->execute();
		}

		public function get_list()
		{
			$this->db->query(
				"SELECT ma.* , branch_name 
				FROM $this->table_name as ma 
				left join ld_branch on 
				ma.branchid = ld_branch.id"
			);

			return $this->db->resultSet();
		}

		public function get_branch_accounts($branchid)
		{
			$this->db->query(
				"SELECT ma.* , branch_name 
				FROM $this->table_name as ma 
				left join ld_branch on 
				ma.branchid = ld_branch.id

				WHERE ma.branchid = '$branchid'"
			);

			return $this->db->resultSet();
		}
		private function get_user_by_username($username)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name
					WHERE username = '{$username}'"
			);

			return $this->db->single();
		}
	}