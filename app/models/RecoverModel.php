<?php 	

	class RecoverModel extends Base_model
	{
		private $table_name = 'change_pwd_sessions';

		public function sendNewPassoword($email , $userid)
		{
			$mailer = new Mailer();
			$userid  = unserialize(base64_decode($userid));
			$password = $this->generatePassword();
			$link = $this->setChangePasswordSession(['password'=>$password , 'userid' =>$userid , 'email'=>$email]);

			$message = $this->message($link , $password);
			if(_mail($email , "Forgot Password request " . SITE_NAME , $message)) {
				Flash::set("Password change confirmation has been sent to your email '{$email}', check spam and junk folders");
				redirect('users/login');
			}
		}

		#####OLD PROCESS ####
		// public function sendNewPassoword($email , $userid)
		// {
		// 	if($user = $this->getUserWithId($userid))
		// 	{

		// 		$mailer = new Mailer();

		// 		$password = $this->generatePassword();

		// 		$link = $this->setChangePasswordSession(['password'=>$password , 'userid' =>$userid , 'email'=>$email]);

		// 		$message = $this->message($link , $password);

		// 		$mailer->setFrom('socialnetworkecommerce@gmail.com','Social Network')
		// 		->setTo($email , 'Beloved User')
		// 		->setSubject('Forgot Password')
		// 		->setBody($message);


		// 		if($mailer->send())
		// 		{
		// 			Flash::set("Password change confirmation has been sent to your email '{$email}'");
		// 			redirect('users/login');
		// 		}
		// 	}else
		// 	{
		// 		Flash::set(" No found user with email '$email'" , 'warning');
		// 		redirect('recover/initiate');
		// 	}
		// }
		#####OLD PROCESS ####
		private function userWithEmail($email)
		{
			$this->db->query("SELECT id , username from users where email = '$email'");

			return $this->db->single();
		}


		private function getUserWithId($userid)
		{
			$this->db->query("SELECT id , username from users where email = '$userid'");

			return $this->db->single();
		}
		private function setChangePasswordSession($pwdSession)
		{
			extract($pwdSession);

			$status = 'open';
			$token  = random_gen();

			$newpassword = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO $this->table_name(userid , email , newpassword , token , status)";

			$sql .= "VALUES('$userid' , '$email' , '$newpassword' , '$token' , '$status')";

			$this->db->query($sql);

			$lastID = $this->db->insert();

			$createlink = URL.DS.'recover/changePassword'.'?sessionid='.$lastID.'&token='.$token;

			return $createlink;
		}

		private function generatePassword()
		{
			$tmpPassword = '';

			for($i = 0 ; $i < 4 ; $i++)
			{
				$tmpPassword.= rand(0,9);
			}
			return $tmpPassword; 
		}

		public function changePassword($requestDetails)
		{
			extract($requestDetails);

			//search for sessionid
			$sql = "SELECT * FROM $this->table_name where id = '$sessionid'";

			$this->db->query($sql);
			$userid;
			if($row = $this->db->single())
			{
				if($row->token == $token)
				{
					//change passwword
					$userid = $row->userid ;
					$changePass = $this->applyChangePassword($row->id , $row->userid , $row->newpassword);

					if($changePass === true)
					{

						Flash::set('Password changed, you can change your password on your profile.');
						return redirect('users/login');
					}else
					{
						Flash::set(mimplode(',', $this->db->errors() ), 'danger');
						redirect('users/login');
					}
				}else
				{
					Flash::set('Session Unmatched');
					redirect('users/login');
				}
			}else
			{
				Flash::set('No session found' , 'danger');
				redirect('users/login');
			}
		}

		private function applyChangePassword($sessionid , $userid , $newpassword)
		{
			$this->db->query("UPDATE users set password  = '$newpassword' where id = '$userid'");

			if($this->db->execute())
			{
				//update password session to close
				$sql = "UPDATE $this->table_name set status = 'closed' where id = '$sessionid'";

				$this->db->query($sql);

				if($this->db->execute())
					return true;
				return false;
			}
			return false;
		}
		private function message($link , $password)
		{
			$url = COMPANY_NAME;

			return "
			<div style='width:450px'>
					<h2>Forget Password</h2>
					<h3><b>We recieved a request of forget password on our site '{$url}' using this email,</b></h3>
					<a href='{$link}'>Click here to confirm change password</a>
					<p>Your Temporary Password upon confirming is :</p>
					<h2  style='color: green; text-transform: uppercase; text-align: center;  border: 1px solid black;'>$password</h2>

					<br>
					Furthermore you can change your password on your accounts profile to setup your desired password.
					<br/>
				<p>If you did not request any change password please ignore this email.</p>
			</div>" ; 
		}



	}