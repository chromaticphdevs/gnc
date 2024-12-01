<?php 	

	class SystemDataFixerModel extends Base_model
	{

		public function remove_duplicate()
		{
			$this->db->query(
				"SELECT firstname, lastname, username , COUNT(id) FROM `users` 
				 WHERE username != 'duplicate' and username != 'Breakthrough' 
				 GROUP by username, firstname,lastname 
				 HAVING `COUNT(id)` > 1 
				 ORDER BY `COUNT(id)` 
				 DESC LIMIT 500"
			);
			
			$users = $this->db->resultSet();

			foreach ($users as $key => $value) 
			{
				$this->db->query(
					"SELECT * FROM `users` 
					 WHERE `firstname` = '$value->firstname' AND `lastname` = '$value->lastname' AND `username` = '$value->username' 
					 ORDER BY `id` ASC"
				);

				$duplicate_users = $this->db->resultSet();

				foreach ($duplicate_users as $key2 => $data) {
		
					$new_firstname = "duplicate_".$data->firstname;
					$new_lastname = "duplicate_".$data->lastname;

					if($key2 > 0)
					{
						$this->db->query(
							"UPDATE `users` SET `firstname`='$new_firstname',`lastname`='$new_lastname',`username`='duplicate' WHERE id = $data->id"
						);
						$this->db->execute();
					}		
				}

			}
			
		}


		public function search_direct($username)
		{
			$this->db->query(
				"SELECT * FROM `users` WHERE `username`='$username'"
			);
			
			$result = $this->db->single();

			$direct_sponsor = $result->direct_sponsor;

			while(!empty($direct_sponsor))
			{
			    $this->db->query(
					"SELECT * FROM `users` WHERE `id`='$direct_sponsor'"
				);
				
				$data = $this->db->single();

				$direct_sponsor = $data->direct_sponsor;

				echo $data->id." - ".$data->firstname." ".$data->lastname." : ".$data->username."<br>";
			}
		}


		public function search_upline($username)
		{
			$this->db->query(
				"SELECT * FROM `users` WHERE `username`='$username'"
			);
			
			$result = $this->db->single();

			$uplineID = $result->upline;

			while(!empty($uplineID))
			{
			    $this->db->query(
					"SELECT * FROM `users` WHERE `id`='$uplineID'"
				);
				
				$data = $this->db->single();

				$uplineID = $data->upline;

				echo $data->id." - ".$data->firstname." ".$data->lastname." : ".$data->username."<br>";
			}

		}


		public function delete_test_account_loan($data)
		{
		 
		    $this->db->query(
				"SELECT * FROM `users` WHERE `firstname` LIKE '$data%' AND `lastname` LIKE '$data%' AND `username` LIKE '$data%' ORDER BY `id` ASC"
			);
			
			$data = $this->db->resultSet();

			foreach ($data as $key => $value) {
				
				echo $value->id." - ".$value->firstname." ".$value->lastname." : ".$value->username."<br>";

				$this->db->query(
					"DELETE FROM `fn_product_release` WHERE `userid` = '$value->id' AND `status` = 'Approved'"
				);


				$this->db->execute();		
			
			}
		}

	}