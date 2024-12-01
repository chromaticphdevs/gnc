<?php 	

	class AccountModel extends Base_model
	{

		public function activate($userid = null, $upline = null , $position = null)
		{

			if(is_null($userid) || is_null($upline) || is_null($position)) {

				Flash::set("Something went wrong" , 'danger');
				return false;
			}

			$this->db->query(
				"UPDATE users set upline = '$upline' , L_R = '$position'
					WHERE id = '$userid'"
			);
			
			try{

				$this->db->execute();

				$newupline = $this->get_user($upline);

				
				Flash::set("Account has been activated your upline {$newupline->username} on position '$position'");

				return true;

			}catch(Exception $e) {

				Flash::set($e->getMessage() , 'danger');
				return false;
			}
		}

		public function select_cop($id,$type,$userid) 
		{
			if($type == "main")
			{
				$this->db->query(
					"UPDATE `user_addresses` SET `is_show`='no' WHERE userid='$userid'"
				);
				return $this->db->execute();
			}else
			{
				$this->db->query(
					"UPDATE `user_addresses` SET `is_show`='yes' WHERE id='$id'"
				);
				return $this->db->execute();
			}	
		}

		public function get_active_address($userid)
		{
			$this->User_model = model('User_model');
			$userAddress = model('UserAddressesModel');

 			$check_cop =  $userAddress->getCOP($userid);
 			$userDetails =  $this->User_model->getPublic($userid);

 			$active_cop = ""; 
			if(!empty($check_cop))
            {
                $active_cop =  $check_cop->address;
            }else
            {
               $active_cop=  $userDetails->address;
            }

            return $active_cop;    
		}


		public function get_user($userid) 
		{
			$this->db->query(
				"SELECT * FROM users where id = '$userid'"
			);

			return $this->db->single();
		}

		public function getUsername($username)
		{
			$data = [
				'users' ,
				[
					'username'
				] ,
				" username = '{$username}'"
			];

			return $this->dbHelper->single(...$data);
		}

		public function getEmail($email)
		{
			$data = [
				'users' ,
				[
					'email'
				] ,
				" email = '{$email}'"
			];

			return $this->dbHelper->single(...$data);
		}

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

		/** DO NOT DELETE USED ON ACCOUNT PROFILE */
		public function update_contact($contact)
		{
			extract($contact);

			$data = [
				'users' , 
				[
					'email' => $email ,
					'mobile' => $mobile,
					'address' => $address
				],
				" id = '$userid'"
			];

			return $this->dbHelper->update(...$data);
		}

		public function update_email($userid, $email)
		{
		
			$data = [
				'users' , 
				[
					'email' => $email ,
				],
				" id = '$userid'"
			];

			return $this->dbHelper->update(...$data);
		}

		public function update_password($userid , $password) 
		{
			$password = password_hash($password , PASSWORD_DEFAULT);

			$data = [
				'users' , 
				[
					'password' => $password
				] ,
				"id = '$userid'"
			];

			return $this->dbHelper->update(...$data);
		}


		public function update_address($address, $userid, $old_address) 
		{	

			$this->db->query(
				"UPDATE `users` SET `address`='$address' WHERE id = '$userid'"
			);
			if($this->db->execute()){

				if($old_address != 'not set'){

					$this->db->query(
						"INSERT INTO `users_old_address`(`userid`, `old_address`) VALUES ('$userid','$old_address')"
					);
					$this->db->execute();
				}
				return true;

			}else{
				return false;
			}	
		}

		public function update_main_address($address_id, $userid)
		{
			//get to swap address
			$this->db->query(
				"SELECT * from user_addresses 
				 where id = '$address_id'"
			);
			$to_swap = $this->db->single();

			// get main address of user
			$this->db->query(
				"SELECT * from users 
				 where id = '$userid'"
			);
			$main = $this->db->single();

			$this->db->query(
				"UPDATE `user_addresses` SET `address`='$main->address' WHERE id='$address_id'"
			);
			$this->db->execute();

			$this->db->query(
				"UPDATE `users` SET `address`='$to_swap->address' WHERE id = '$userid'"
			);
			return $this->db->execute();


		}

		public function remove_address($id) 
		{	

			$this->db->query(
				"UPDATE `user_addresses` SET `status`='deleted' WHERE id='$id'"
			);
			return $this->db->execute();
		}

		public function add_address($userid, $address)
		{
			$this->db->query(
				"INSERT INTO `user_addresses`(`userid`, `address`) VALUES ('$userid','$address')"
			);
			return $this->db->execute();
		}

		public function add_cop($userid, $address)
		{
			$this->db->query(
				"INSERT INTO `user_addresses`(`userid`, `address`, `type`) VALUES ('$userid','$address','COP')"
			);
			return $this->db->execute();
		}

		public function get_addresses($userid)
		{
			$this->db->query(
				"SELECT * from user_addresses 
				 where userid = '$userid' AND `status` !='deleted' "
			);

			return 	
				$this->db->resultSet();
		}


		public function get_heir_list($userid)
		{
			$this->db->query(
				"SELECT * from users_heir where userid = '$userid' AND `status`='ok' "
			);

			return 	
				$this->db->resultSet();
		}

		public function add_heir($firstname,$middlename,$lastname, $userid) 
		{	

			$this->db->query(
				"INSERT INTO `users_heir`(`userid`, `firstname`, `middlename`, `lastname`) VALUES ('$userid','$firstname','$middlename','$lastname')"
			);
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}	
		}

		
		public function edit_heir($firstname,$middlename,$lastname, $id, $userid) 
		{	

			
			$this->db->query(
				"UPDATE `users_heir` SET `firstname`='$firstname',`middlename`='$middlename',`lastname`='$lastname' WHERE `id` = '$id' "
			);
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}	
		}

		public function delete_heir($id) 
		{	

			$this->db->query(
				"UPDATE `users_heir` SET `status`='deleted' WHERE `id` = '$id' "
			);
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}	
		}


		public function update_profile($userid , $image) 
		{
			$data = [
				'users' , 
				[
					'selfie' => $image
				] ,
				"id = '$userid'"
			];

			$updateResult = $this->dbHelper->update(...$data);

			if(!isset($this->userModel)) {
				$this->userModel = model('User_model');
			}
			$this->userModel->sessionUpdate($userid);
			return $updateResult;

		}

		public function get_users_for_deactivation()
		{
			$this->db->query(
				"SELECT * FROM users  
				 WHERE DATEDIFF('2020-09-01', 
				 DATE(created_at)) > 30 AND status ='pre-activated' 
				 AND account_tag = 'main_account' AND username != 'breakthrough'"
			);

			return $this->db->resultSet();
		}

	
		public function deactivate_account()
		{
			$this->db->query(
				"SELECT * FROM users  
				 WHERE DATEDIFF('2020-09-01', 
				 DATE(created_at)) > 30 AND status ='pre-activated' 
				 AND account_tag = 'main_account' AND username != 'breakthrough'"
			);

			$users = $this->db->resultSet();

			foreach ($users as $key => $value) 
			{
				$this->db->query(
					""
				);	
					$props  = [
						'userid'       => $value->id,
						'dbbi_id'      =>$value->dbbi_id ,
						'firstname'    => $value->firstname,
						'lastname'     => $value->lastname,
						'username'     => $value->username,
						'password'	   => $value->password,
						'direct_sponsor' => $value->direct_sponsor,
						'upline'       =>$value->upline,
						'L_R'          => $value->L_R,
						'new_upline'   => $value->new_upline,
						'branchId'     => $value->branchId,
						'user_type'    => $value->user_type,
						'selfie'       => $value->selfie,
						'email'        => $value->email,
						'religion_id'  => $value->religion_id,
						'address' 	   => $value->address,
						'mobile'       => $value->mobile,
						'mobile_verify'  => $value->mobile_verify,
						'created_at'   => $value->created_at,
						'status'       => $value->status,
						'max_pair'     => $value->max_pair,
						'is_activated' => $value->is_activated,
						'account_tag'  => $value->account_tag,
						'activated_by' => $value->activated_by,
						'oldid'    	   => $value->oldid,
						'is_online'    => $value->is_online,
						'middlename'   => $value->middlename
					];

					$this->insert_old_user_data($props);

					$password = '$2y$10$50/NfjyCQurKWoMSUMH/QuVrbq57PmRnYIGpUEoBpgtbZ6rXOET3O' ;
					$text = 'Breakthrough';
					$this->db->query("UPDATE `users` 
						  SET `username`='$text',`password`='$password',
						      `email`='$text',`address`='$text',
						      `mobile`='0000',`mobile_verify`='unverified',`account_tag`='sub_account',
						      `firstname`='$text',`lastname`='$text',`middlename`='$text'
						  WHERE id='$value->id'");

					$this->db->execute();
			}


			return $users;

		}



		private function insert_old_user_data($props)
		{

			$keys = array_keys($props);

			$values = array_values($props);

			$this->db->query("
					INSERT INTO users_previous_data(".implode(' , ', $keys).")
						VALUES('".implode("','", $values)."')");
			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				die($e->getMessage());
			}
		
		}

		public function get_user_staff()
		{	
			$this->db->query(
				"SELECT * FROM users  
				 WHERE is_staff = '1'"
			);

			return $this->db->resultSet();
		}

		public function change_staff_status($userid,$status)
		{
			$this->db->query("UPDATE `users` 
						  SET `is_staff`='$status'
						  WHERE id='$userid'");

			return $this->db->execute();
		}

	}