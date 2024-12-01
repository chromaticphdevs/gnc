<?php


	class ActivationFormModel extends Base_model
	{


		public function __construct()
		{
			parent::__construct();

		}

		

		public function pre_register_login($loginInfo){

		extract($loginInfo);


		$this->db->query(
			"SELECT `username`, `password` FROM `users` WHERE `username`='$username'"
		);

		$result2=$this->db->single();
			
		if(!empty($result2))
		{

			$this->db->query(
			"SELECT * FROM `users` WHERE username='$username' and is_activated='0'"
			);

			$account_stat=$this->db->single();

			if(!empty($account_stat)){

					if(password_verify($password, $result2->password))
					{

						$this->db->query(
						"SELECT  `id`,`dbbi_id`, `firstname`, `lastname`, `username`, `password`, `direct_sponsor` AS direct_sponsor, `upline`, `L_R`, `new_upline`, `user_type`, `selfie`, `email`, `address`, `mobile`, `created_at`, `status`, concat(firstname , ' ' , lastname) as fullname FROM `users` WHERE `username`='$username' AND `password`='$result2->password'"
						);
						
						$result = $this->db->single();
						Session::set('USER_INFO' , $result);

						Flash::set($result->fullname, 'positive');
			    	 	redirect('LDActivation/activate_code_pre_register');	
			    

					}else{
						Flash::set('Incorrect Password' , 'negative');
						redirect('ActivationForm');	
					}

			}else{

				Flash::set('Account Already Activated');
				redirect('ActivationForm');	

			}
		
		}else{
			Flash::set('Account does not exists');
			redirect('ActivationForm');	
		}
		
		
      }

      public function pre_register($customerInfo)
	  {
			extract($customerInfo);

			$check_error_value = 0;

			$this->db->query(
				"SELECT  `username` FROM `users` WHERE  `username`='$username'"
			);

			//check duplicated username
			$result=$this->db->resultSet();

			if($result==null)
			{	

				$this->db->query(
				"SELECT  `email` FROM `users` WHERE  `email`='$email'"
				);
				//check duplicated email
				$email_result=$this->db->resultSet();

				if($email_result!=null)
				{

					echo '2';
					$check_error_value = 2;
					//Flash::set('Email already exist');			
					return false;
				}


				$this->db->query(
					"SELECT  `mobile` FROM `users` WHERE  `mobile`='$cp_number'"
				);
				//check duplicated number
				$result=$this->db->resultSet();

				if($result!=null)
				{	

					echo '3';
					$check_error_value = 3;
					//Flash::set('Mobile Number already exist');
					return false;
				}

	
				if(strlen($cp_number) >= 13){

					echo '4';
					$check_error_value = 4;
					//Flash::set('Phone Number is too long ','negative');
					return false;
				}

				//check duplicated firstname and lastname
				$this->db->query(
					"SELECT  `firstname`,`lastname` FROM `users` 
					WHERE  `firstname` = '$first_name' AND `lastname` = '$last_name'"
				);
				
				$name_result=$this->db->resultSet();

				if($name_result != null)
				{
					echo '5';
					$check_error_value = 5;
					
					return false;	
				}

				if($check_error_value == 0)
				{

					date_default_timezone_set("Asia/Manila");

					$password="123456";
					
					//$groupId=date("N", strtotime(date("l")))-1;
				
					//$address = $house_st.", ".$brgy.", ".$city.", ".$province.", ".$region;

					$this->db->query("INSERT INTO pre_register_users( `firstname`, `middlename`, `lastname`, `phone`, `address`, `email`, `username`, `password`, `referral_id`, `note`, `religion_id`)
					VALUES ('$first_name','$middle_name','$last_name','$cp_number','','$email','$username','$password','$refer','pre-registration for Social Refferal', '$religion_id')");
					$this->db->execute();
				

					$upline = $this->binaryModel->outDownline( $refer, $position);	
						//insert to social	
						$props  = [
								//'dbbi_id'        => $lastid,
								'firstname'      => $first_name , 
								'lastname'       => $last_name,
								'username'       => $username,
								'password'       => password_hash($password, PASSWORD_DEFAULT),
								'direct_sponsor' => $refer,
								'upline'         => $upline,
								'L_R'            => $position,
								'new_upline'     => $refer,
								'user_type'      => '2',
								'email'          => $email,
								//'address'        => $address,
								'mobile'         => $cp_number,
								'branchId'         => $branch,
								'religion_id'         => $religion_id,
								'mobile_verify'         => 'verified',
								'account_tag'         => 'main_account'
						];

						$this->insert_user_to_socialnetwork($props);
						echo 'OKOK';
						//redirect("/ActivationForm/?refferal_ID={$refer}&username={$username}");

				}
				

		
			}else{

				
					echo '1';
					$check_error_value = 1;
					//Flash::set('Username already exist');
					return false;
			}	
		
		}

	  public function check_send_text_code($customerInfo)
	  {
			extract($customerInfo);

			$check_error_value = 0;

			$this->db->query(
				"SELECT  `username` FROM `users` WHERE  `username`='$username'"
			);

			//check duplicated username
			$result=$this->db->resultSet();

			if($result==null)
			{	

				$this->db->query(
				"SELECT  `email` FROM `users` WHERE  `email`='$email'"
				);
				//check duplicated email
				$email_result=$this->db->resultSet();

				if($email_result!=null)
				{

					echo '2';
					$check_error_value = 2;
					//Flash::set('Email already exist');			
					return false;
				}


				$this->db->query(
					"SELECT  `mobile` FROM `users` WHERE  `mobile`='$cp_number'"
				);
				//check duplicated number
				$result=$this->db->resultSet();

				if($result!=null)
				{	

					echo '3';
					$check_error_value = 3;
					//Flash::set('Mobile Number already exist');
					return false;
				}

	
				if(strlen($cp_number) >= 13){

					echo '4';
					$check_error_value = 4;
					//Flash::set('Phone Number is too long ','negative');
					return false;
				}

				//check duplicated firstname and lastname
				$this->db->query(
					"SELECT  `firstname`,`lastname` FROM `users` 
					WHERE  `firstname` = '$first_name' AND `lastname` = '$last_name'"
				);
				
				$name_result=$this->db->resultSet();

				if($name_result != null)
				{
					echo '5';
					$check_error_value = 5;
					
					return false;	
				}

				if($check_error_value == 0)
				{	

				$code1=random_number();
					$code2=random_number();
					$code3=random_number();
					$registration_code=substr($code1,0,2).''.substr($code2,0,2);

					$number = $cp_number;

					/*$message = "Hi, your verification code is ".$registration_code."\n\n Breakthrough E-COM \n\n";
					itexmo($number,$message , ITEXMO,ITEXMO_PASS);*/
					
					$this->db->query(

					   "INSERT INTO `text_confirmation_code`(`number`, `code`) 
					   	VALUES ('$cp_number','$registration_code')"
					);

					$this->db->execute();

					


					echo $registration_code;
					
				}
				

		
			}else{

				
					echo '1';
					$check_error_value = 1;
					//Flash::set('Username already exist');
					return false;
			}	
		
		}




		private function insert_user_to_socialnetwork($props) 
		{

			$keys = array_keys($props);

			$values = array_values($props);

			$this->db->query("
					INSERT INTO users(".implode(' , ', $keys).") 
						VALUES('".implode("','", $values)."')");
			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				die($e->getMessage());
			}
	
		}


		 public function check_send_email_code($customerInfo)
	  {
			extract($customerInfo);

			$check_error_value = 0;

			$this->db->query(
				"SELECT  `username` FROM `users` WHERE  `username`='$username'"
			);

			//check duplicated username
			$result=$this->db->resultSet();

			if($result==null)
			{	

				$this->db->query(
				"SELECT  `email` FROM `users` WHERE  `email`='$email'"
				);
				//check duplicated email
				$email_result=$this->db->resultSet();

				if($email_result!=null)
				{

					echo '2';
					$check_error_value = 2;
					//Flash::set('Email already exist');			
					return false;
				}


				$this->db->query(
					"SELECT  `mobile` FROM `users` WHERE  `mobile`='$cp_number'"
				);
				//check duplicated number
				$result=$this->db->resultSet();

				if($result!=null)
				{	

					echo '3';
					$check_error_value = 3;
					//Flash::set('Mobile Number already exist');
					return false;
				}

	
				if(strlen($cp_number) >= 13){

					echo '4';
					$check_error_value = 4;
					//Flash::set('Phone Number is too long ','negative');
					return false;
				}

				//check duplicated firstname and lastname
				$this->db->query(
					"SELECT  `firstname`,`lastname` FROM `users` 
					WHERE  `firstname` = '$first_name' AND `lastname` = '$last_name'"
				);
				
				$name_result=$this->db->resultSet();

				if($name_result != null)
				{
					echo '5';
					$check_error_value = 5;
					
					return false;	
				}

				if($check_error_value == 0)
				{	

					$code1=random_number();
					$code2=random_number();
					$code3=random_number();
					$registration_code=substr($code1,0,2).''.substr($code2,0,2);

					$mailer = new Mailer();

					$message = $this->message($registration_code);

					$mailer->setFrom('socialnetworkecommerce@gmail.com','Social Network')
					->setTo($email , 'Beloved User')
					->setSubject('Registration Code')
					->setBody($message);


					if($mailer->send())
					{
						echo $registration_code;
					}


					
					
				}
				

		
			}else{

				
					echo '1';
					$check_error_value = 1;
					//Flash::set('Username already exist');
					return false;
			}	
		
		}


		private function message($code)
		{
			return "<p>
				<h2>Registration Code</h2>
				We recieved a registration request in our site 'www.socialnetwork-e.com',
				<br>
				Your Confirmation Code: 
				<h2  style='color: red; text-transform: uppercase; text-align: center;  border: 5px solid black;'>$code</h2>
				<br>
				Please Enter this Confirmation Code in the form so that we can process your  Registration.
			</p>" ; 
		}


  }

?>
