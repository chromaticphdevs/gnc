<?php 	

	class LDTransferAccountModel extends Base_model
	{

		public function transfer_account($accountInfo)
		{
			extract($accountInfo);

			$errors  = [];

			$password  = password_hash($lastname, PASSWORD_DEFAULT);
			$user_type = 'customer';

			//check if firstname or lastname exists
			$name_search_hit = $this->name_search_hit($firstname , $lastname);
			
			if($name_search_hit) {
				$errors[] = "Person {$firstname} {$lastname} is already on the record";
			}
			//check email and mobile
			$mobile_search_hit = $this->search_hit('phone' , $mobile);

			if($mobile_search_hit){
				$errors[] = "Mobile Number already used {$mobile}";
			}

			$email_search_hit = $this->search_hit('email' , $email);

			if($email_search_hit){
				$errors[] = "Email already used {$email}";
			}


			if(!empty($errors))
			{
				$html = '';
				foreach($errors as $err) {
					$html .= '<p>' . $err . '</p>';
				}

				Flash::set($html, 'danger');
				return false;
			}


			//check if mobile and email exists
			$this->db->query(
				"INSERT INTO ld_users(firstname , lastname , email, phone,
				password , user_type , branch_id , referral_id , middlename , address)

				VALUES('$firstname' ,'$lastname' , '$email' , '$mobile' ,'$password' , '$user_type' , 
				'$branch' , '$referral' , '', '')"
			);

			try
			{
				$this->db->execute();
				return true;
			}catch(Exception $e) 
			{
				Flash::set($e->getMessage() , 'danger');
				return false;
			}
		}

		private function name_search_hit($firstname , $lastname)
		{
			$this->db->query(
				"SELECT * FROM ld_users where firstname = '$firstname' and lastname = '$lastname'"
			);

			return $this->db->single();
		}
		private function search_hit($field , $value)
		{
			$this->db->query(
				"SELECT * FROM ld_users where $field = '$value'"
			);

			return $this->db->single();
		}
	}