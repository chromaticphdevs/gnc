<?php 	

	class UserAccountModel extends Base_model
	{

		public function search_by_name_and_email($firstname, $lastname, $email, $userID) 
		{
			$this->db->query(
				"SELECT username, id FROM users 
				where (firstname = '$firstname' and lastname = '$lastname') and 
				email = '$email' and id != '$userID'  "
			);

			
			return $this->db->resultSet();
		}

		public function search_by_name($firstname, $lastname, $userID) 
		{
			$this->db->query(
				"SELECT username, id FROM users where firstname = '$firstname' and lastname = '$lastname' and id != '$userID'  "
			);

			return $this->db->resultSet();
		}

		public function search_by_email($email, $userID) 
		{
			$this->db->query(
				"SELECT username, id FROM users where email = '$email' and id != '$userID' "
			);

			return $this->db->resultSet();
		}

		public function search_by_email_all($email, $userID) 
		{
			$this->db->query(
				"SELECT username, id, 
				 CONCAT(firstname,' ', lastname ) as fullname 
				 FROM users where email = '$email' "
			);

			return $this->db->resultSet();
		}

		public function account_details($userID)
		{

			$this->db->query(
				" SELECT * FROM users where id = '$userID' "
			);

			return $this->db->single();	
		}
		public function account_details_username($username)
		{

			$this->db->query(
				" SELECT * FROM users where username = '$username' "
			);

			return $this->db->single();	
		}

		public function createAccount($username , $password , $userid)
		{
			$userModel = new User_model();

			$usernameExists = $userModel->get_user_by_username($username);

			if($usernameExists) {
				Flash::set("Username '{$username}' already exists");
				return false;
			}

			$password = password_hash($password, PASSWORD_DEFAULT);

			$this->db->query(
				"INSERT INTO users(firstname , lastname , direct_sponsor  , user_type , 
				email , address , mobile , status , max_pair , branchid , username , password, account_tag) 

				(SELECT firstname , lastname , '$userid' ,  user_type , 
				email , address , mobile , 'pre-activated' , 0 , branchid ,'$username' , '$password' , 'sub_account'
				from users where id = '$userid')"
			);

			try{

				$this->db->execute();

				/*get user*/

				$user = $userModel->get_user($userid);
				$data = [
					'by_name'  => $this->search_by_name($user->firstname , $user->lastname , $userid), 
					'by_email' => $this->search_by_email($user->email , $userid)
				];

				Session::set('MY_ACCOUNTS' , $data);
				return true;

			}catch(Exception $e) {
				die(var_dump($e->getMessage()));

				return false;
			}
		}


		public function createAccount_to_binary($username, $password, $userid, $uplineid, $position)
		{
			$userModel = new User_model();

			$usernameExists = $userModel->get_user_by_username($username);

			if($usernameExists) {
				Flash::set("Username '{$username}' already exists");
				return false;
			}


			$userNotActivated = $userModel->check_user_activation($userid);

			if(!empty($userNotActivated)) {
				Flash::set("Activate your Account to use this feature");
				return false;
				
			}

			$uplineNotActivated = $userModel->check_user_activation($uplineid);

			if(!empty($uplineNotActivated)) {
				Flash::set("UPLINE should be activated to use this feature");
				return false;
				
			}
		
			$password = password_hash($password, PASSWORD_DEFAULT);

			$this->db->query(
				"INSERT INTO users(firstname , lastname , direct_sponsor  , user_type , 
				email , address , mobile , status , max_pair , branchid , username , password, account_tag, upline, L_R) 

				(SELECT firstname , lastname , '$userid' ,  user_type , 
				email , address , mobile , 'pre-activated' , 0 , branchid ,
				'$username' , '$password' , 'sub_account' , '$uplineid' , '$position'
				from users where id = '$userid')"
			);

			try{

				$this->db->execute();

				/*get user*/

				$user = $userModel->get_user($userid);
				$data = [
					'by_name'  => $this->search_by_name($user->firstname , $user->lastname , $userid), 
					'by_email' => $this->search_by_email($user->email , $userid)
				];

				Session::set('MY_ACCOUNTS' , $data);
				return true;

			}catch(Exception $e) {
				die(var_dump($e->getMessage()));

				return false;
			}
		}

	}