<?php 	

	class Referral_model extends Base_model
	{
		public function get_unactivated_list($userid)
		{
			return $this->get_list( " WHERE direct_sponsor = '$userid' and is_activated = false and status != 'pre-activated'");
		}


		public function get_activated_list($userid)
		{

			$this->db->query(
				"SELECT * , concat(firstname , ' ', lastname) as fullname,
					(SELECT username from users where id = mu.upline ) as  uplinename FROM users as mu where direct_sponsor = '$userid' and is_activated = true"
			);

			return $this->db->resultSet();

			// return $this->get_list( " WHERE direct_sponsor = '$userid' and is_activated = true");
		}

		public function get_list($params)
		{
			$this->db->query(
				"SELECT *  , concat(firstname , ' ' , lastname) as fullname 
						FROM users $params"
			);

			return $this->db->resultSet();
		}


		public function get_preactivated_list($userid)
		{
			return $this->get_list( " WHERE direct_sponsor = '$userid' and is_activated = false and status = 'pre-activated'");
		}
		
		public function create_account($account)
		{
			$result = array();
			$errors = array();

			extract($account);
			//check if username exists
			$u_exists = $this->username_exists($username);
			$e_exists = $this->email_exists($email);



			if($u_exists === TRUE)
			{

				$errors['username'] = 'Username' . " '$username' ". ' already exists ';
			}

			if($e_exists === TRUE){
				$errors['email']    = 'Email' . " '$email' " . ' already exists ';
			}

			if(!empty($this->name_exists($firstname , $lastname))){
				$errors['name'] = 'This person already has an account';
			}

			if(!empty($errors)){

				return [
					'status' => FALSE ,
					'errors' => $errors,
					'fields' => $account
				];
			}

			else{
				// $this->db->query("SELECT * FROM users where username = '{$account['username']}'");

				$password = password_hash($password, PASSWORD_DEFAULT);

				// $this->db->query(
				// 	"INSERT INTO users(user_type , firstname , lastname , username ,password , direct_sponsor , upline , 
				//  L_R , email , selfie)

				//  	VALUES('2' , '{$firstname}' , '{$lastname}','{$username}','{$password}' , '{$direct_sponsor}' , 
				//  	'{$upline}' , '{$binary_position}' , '{$email}' , 'null')"
				// );


				$this->db->query(
					"INSERT INTO users(user_type , firstname , lastname , username ,password , direct_sponsor , upline , 
				 L_R , email , selfie , branchId)

				 	VALUES('2' , '{$firstname}' , '{$lastname}','{$username}','{$password}' , '{$direct_sponsor}' , 
				 	'0' , '{$binary_position}' , '{$email}' , 'null' , '{$branchId}')"
				);
				
				if($this->db->execute())
				{	
					return [
						'status' => TRUE ,
						'fields' => $account
					];

				}else{

					return [
						'status' => FALSE ,
						'errors' => 'Database Error',
						'fields' => $account
					];
				}
			}
		}

		private function username_exists($username)
		{
			$this->db->query("SELECT username from users where username = '{$username}'");

			if($this->db->rowCount())
				return TRUE;
			return FALSE;
		}

		private function email_exists($email)
		{			
			$this->db->query("SELECT email from users where email = '{$email}'");

			if($this->db->rowCount())
				return TRUE;
			return FALSE;
		}

		private function name_exists($firstname , $lastname)
		{
			$this->db->query(
				"SELECT firstname , lastname from users where firstname = '$firstname' and lastname = '$lastname'"
			);

			return $this->db->single();
		}
	}