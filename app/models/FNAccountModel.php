<?php 	

	class FNAccountModel extends Base_model
	{
		private $table_name = 'fn_accounts';

		public $table = 'fn_accounts';
		
		public function make_account($accountinfo)
		{
			extract($accountinfo);
			
			$password = password_hash($password, PASSWORD_DEFAULT);

			$data = [
				$this->table_name,

				[
					'branchid' => $branchid,
					'name' => $fullname,
					'username' => $username,
					'password' => $password,
					'type'     => $type
				]
			];

			return 	
				$this->dbHelper->insert(...$data);
		}


		public function request_staff($accountinfo, $requester)
		{
			extract($accountinfo);
		
			$data = [
				'fn_accounts_temp',

				[	
					'requester' => $requester,
					'branchid' => '8',
					'name' => $fullname,
					'username' => $username
				]
			];

			return 	
				$this->dbHelper->insert(...$data);
		}

		public function get_list()
		{
			$this->db->query(
				"SELECT ac.* , branch.name as branch_name from 
					$this->table_name as ac 
					LEFT JOIN fn_branches as branch 
					on branch.id = ac.branchid"
			);

			return 	
				$this->db->resultSet();
		}
		

		public function get_account($accountid)
		{
			$data = [
				$this->table_name , 
				'*',
				" id  = '$accountid'"
			]; 

			return 	
				$this->dbHelper->single(...$data);
		}

		public function get_by_username($username)
		{
			$data = [
				$this->table_name,
				'*',
				"username = '$username'"
			];

			return 	
				$this->dbHelper->single(...$data);
		}


		public function update_account($accountinfo)
		{
			extract($accountinfo);

			$data = [
				$this->table_name ,
				[
					'name' => $name , 
					'username' => $username , 
					'type'  => $type
				],
				" id = '$accountid'"
			];

			return
				$this->dbHelper->update(...$data);
		}
		public function update_password($accountid, $password )
		{
			$password = password_hash($password, PASSWORD_DEFAULT);

			$data = [
				$this->table_name ,
				[
					'password' => $password 
				],

				" id = '$accountid'"
			];

			return 	
				$this->dbHelper->update(...$data);
		}

		public function get_request_info($id, $type)
		{	
			$sql = "";
			if($type == "userid")
			{
				$sql = "AND temp.requester = '$id'";

			}elseif($type == "fn_id")
			{
				$sql = "AND temp.id = '$id'";
			}
			

			$this->db->query(
				"SELECT *,temp.username as fn_username,
				temp.status as fn_status,
				temp.id as fn_id, temp.branchid as fn_branchid
				 FROM `fn_accounts_temp` as temp 
				 INNER JOIN users as u 
				 WHERE u.id = temp.requester 
				 AND temp.status != 'cancel' {$sql} "
			);

			return 	
				$this->db->resultSet();

		}

		public function change_request_status($id, $status)
		{
			$this->db->query(
				"UPDATE `fn_accounts_temp` 
				 SET `status`= '$status'
				 WHERE ID = '$id'"
			);

			return 	
				$this->db->execute();
		}

		public function approved_staff($username, $name, $branchid)
		{
			
			
			$password = password_hash('123456', PASSWORD_DEFAULT);

			$data = [
				$this->table_name,

				[
					'branchid' => $branchid,
					'name' => $name,
					'username' => $username,
					'password' => $password,
					'type'     => 'staff'
				]
			];

			return 	
				$this->dbHelper->insert(...$data);
		}
	}