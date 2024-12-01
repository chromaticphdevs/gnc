<?php 	

	class UserNumberModel extends Base_model
	{

	
		public function getMobile($mobile)
		{
			$data = [
				'users' ,
				[
					'mobile'
				] ,
				" mobile = '{$mobile}'"
			];

			return $this->dbHelper->single(...$data);
		}

	

		public function update_number($number, $userid, $old_address) 
		{	

			$this->db->query(
				"UPDATE `users` SET `mobile`='$number' WHERE id = '$userid'"
			);
			if($this->db->execute()){

				if($old_address != 'not set'){

					$this->db->query(
						"INSERT INTO `users_old_number`(`userid`, `old_number`) VALUES ('$userid','$old_address')"
					);
					$this->db->execute();
				}
				return true;

			}else{
				return false;
			}	
		}

		public function update_main_number($number_id, $userid)
		{	
			//get to swap address
			$this->db->query(
				"SELECT * from user_numbers 
				 where id = '$number_id'"
			);
			$to_swap = $this->db->single();

			// get main address of user
			$this->db->query(
				"SELECT * from users 
				 where id = '$userid'"
			);
			$main = $this->db->single();

			$this->db->query(
				"UPDATE `user_numbers` SET `number`='$main->mobile' WHERE id='$number_id'"
			);
			$this->db->execute();

			$this->db->query(
				"UPDATE `users` SET `mobile`='$to_swap->number' WHERE id = '$userid'"
			);
			return $this->db->execute();


		}

		public function remove_number($id) 
		{	

			$this->db->query(
				"UPDATE `user_numbers` SET `status`='deleted' WHERE id='$id'"
			);
			return $this->db->execute();
		}

		public function add_number($userid, $number)
		{
			$this->db->query(
				"INSERT INTO `user_numbers`(`userid`, `number`) VALUES ('$userid','$number')"
			);
			return $this->db->execute();
		}

		public function check_number($number)
		{

			$this->db->query(
				"SELECT * FROM `users` WHERE `mobile`='$number'"
			);
			$result = $this->db->single();
			
			if(empty($result))
			{
				$this->db->query(
					"SELECT * from user_numbers 
					 where number = '$number' AND status ='active'"
				);
				$result = $this->db->single();
			}
			
			return $result;
		}

		public function get_numbers($userid)
		{
			$this->db->query(
				"SELECT * from user_numbers 
				 where userid = '$userid' AND `status` !='deleted' "
			);

			return 	
				$this->db->resultSet();
		}

		public function verify($id)
		{
			$this->db->query(
				"UPDATE `user_numbers` 
				 SET `verified`= '1'
				 WHERE id = '$id'"
			);
			return $this->db->execute();
		}



	}