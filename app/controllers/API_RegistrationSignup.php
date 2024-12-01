<?php 	
	
	class API_RegistrationSignup extends Controller 
	{

		public function __construct()
		{
			$this->register = $this->model('API_RegistrationSignupModel');
		}


		public function send_text_verification() 
		{
			$mobileNumber = $_POST['cp_number'];

			$code         = $_POST['code'];

			$res  = $this->register->saveTextCode($mobileNumber , $code);

			echo json_encode($res);
		}

		public function verify_registration()
		{
			$errors = [];

			$result = $_POST;

			//check if person exists
			$firstname = $result['first_name'];
			$middle_name = $result['middle_name'];
			$lastname = $result['last_name'];
			

			$username = $result['username'];
			$email = $result['email'];
			$cp_number = $result['cp_number'];

			//check if $firstname, $middle_name, $lastname and mobile is match for account updating 
			//, $cp_number
			$user_check = $this->register->new_validation($firstname, $middle_name, $lastname);

			if($user_check)
			{
				echo json_encode([
						'status' => 'ok',
						'for'	 => 'update',
						'userid' => $user_check->id
					]);
			}
			else{
				$personExists = $this->register->checkPersonExists($firstname, $middle_name, $lastname);

				if($personExists) {
					$errors[] = "First and lastname exists , Person already have an account with us";
				}

				if($this->register->checkFieldExists('username' , $username)) {
					$errors[] = " Username already exists";
				}

				if($this->register->checkFieldExists('mobile' , $cp_number)) {
					$errors[] = " Mobile phone already exists ";
				}
				if($this->register->checkFieldExists('email' , $email)) {
					$errors[] = " Email already exists";
				}

				if(!empty($errors)) 
				{
					echo json_encode([
						'status' => 'failed',
						'err'    => $errors
					]);
				}else{
					echo json_encode([
						'status' => 'ok',
						'for'    => 'register'
					]);
				}
			}

			
		}

		public function check_device_state()
		{
			echo json_encode([
					'status' => 'ok',
					'state' => registration_sms()
			]);
		}

		public function store()
		{
			$result = $_POST;
			
			
			/*if(isset($result['refferal_ID'] , $result['position'] , 
				$result['upline'] , $result['first_name'] , 
				$result['middle_name'] , $result['last_name'] ,
				$result['cp_number'] , $result['email'] ,
				$result['username'] , $result['religion_id'] ,
				$result['branch']))*/
			if(isset($result['refferal_ID'] , $result['position'] , 
				$result['upline'] , $result['first_name'] , 
				$result['middle_name'] , $result['last_name'] ,
				$result['cp_number'],$result['username'] , $result['email'] ,
				$result['branch']))	
			{

				$result = $this->register->pre_register_geneology($_POST);

				if($result) 
				{	
					$data = $this->register->get_total_registration_today();

					echo json_encode([
						'status' => 'ok',
						'user_number_today' => $data->total_today
					]);
				}else{
					echo json_encode([
						'status' => 'failed'
					]);
				}

			}else{
				echo json_encode("INCORRECT QUERY");
			}

			
		}


		public function update_account()
		{
			$result = $_POST;
			
			if(isset($result['refferal_ID'] , $result['position'] , 
				$result['upline'], $result['username'] , $result['password'] , $result['userid']))	
			{

				$result = $this->register->new_update_user_info($_POST);

				if($result) 
				{	
					$data = $this->register->get_total_registration_today();

					echo json_encode([
						'status' => 'ok',
						'user_number_today' => $data->total_today
					]);
				}else{
					echo json_encode([
						'status' => 'failed'
					]);
				}

			}else{
				echo json_encode("INCORRECT QUERY");
			}

			
		}



	}