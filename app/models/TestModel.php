<?php 	
	class TestModel extends Base_model 
	{

		public function get_duplicate_users1()
		{	
			$UserList = [];

			$userid_to_update = [];
			$this->db->query(
				"SELECT username, COUNT(username) as total,created_at 
				  FROM users 
				  WHERE username != 'breakthrough' AND  username != 'duplicate' GROUP BY username 
				  HAVING COUNT(username) > 1 
				  ORDER BY created_at DESC"
			);
			$result =  $this->db->resultSet();

			foreach ($result as $key => $value) {
				

				$this->db->query(
				"SELECT * FROM `users` WHERE `username` LIKE '$value->username'"
				);
				$data =  $this->db->resultSet();
	
				foreach ($data as $key2 => $info) {
					
					if($key2 == 0)
					{
						
						$UserList [] =  (object)  $info;

					}else{

						$userid_to_update [] = (object)
						[
							'id' =>$info->id,
							'username' => $info->username,
							'firstname' => $info->firstname,
							'lastname' => $info->lastname,
							'status' => $info->status

						];
					}

				}

			}
			//dump($userid_to_update);
			foreach ($userid_to_update as $key => $value) {


				$this->db->query("UPDATE users 
								  SET username='duplicate', firstname = 'duplicate_$value->firstname' 
								  , lastname = 'duplicate_$value->lastname' 
								  WHERE id = '$value->id'
								  ");
				$this->db->execute();
			}
		}

		// move dublicate to do not fallow up new user
		public function move_duplicate1()
		{

			$this->db->query(
				"SELECT *
				  FROM users 
				  WHERE  username = 'duplicate'"
			);
			$result =  $this->db->resultSet();

			foreach ($result as $key => $value) 
			{
				$this->db->query("INSERT INTO `new_user_follow_ups`(`user_id`, `level`, `approved_by`, `tagged_as`, `csr_note`) 
								  VALUES ('$value->id','1','60','dont-follow-up','duplicate account')");
				$this->db->execute();
				
				$this->db->query("INSERT INTO `new_user_follow_up_logs`( `user_id`, `remarks`, `approved_by`, `csr_note`)
								  VALUES ('$value->id','User {$value->firstname} {$value->lastname} has been tagged as <strong> dont-follow-up </strong> ', '60' ,'duplicate account')");
				$this->db->execute();
			}

		}


	
	}


