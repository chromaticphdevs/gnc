<?php 	
	
	class API_RegistrationSignup2 extends Controller 
	{

		public function __construct()
		{
			$this->register = $this->model('API_RegistrationSignupModel2');
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

			/*$personExists = $this->register->checkPersonExists($firstname , $lastname);

			if($personExists) {
				$errors[] = "First and lastname exists , Person already have an account with us";
			}*/

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
					'status' => 'ok'
				]);
			}
		}
		public function store()
		{
			$result = $_POST;
			
		
			if(isset($result['refferal_ID'] , $result['position'] , 
				$result['upline'] , $result['first_name'] , 
				$result['middle_name'] , $result['last_name'] ,
				$result['cp_number'] , $result['email'] ,
				$result['username'] , $result['religion_id'] ,
				$result['branch']))
			{

				$personExists = $this->register->checkPersonExists($result['first_name'], $result['middle_name'], $result['last_name']);
	
				if($personExists) 
				{
					$result = $this->register->update_user_info($_POST,$personExists->id);

					if(!empty($result)) 
					{
						echo json_encode([
							'test_result' => $result,
							'status' => 'ok'
						]);
					}else{
						echo json_encode([
							'status' => 'failed'
						]);
					}

				}else
				{
					$result = $this->register->pre_register_geneology($_POST);

					if($result) 
					{
						echo json_encode([
							'status' => 'ok'
						]);
					}else{
						echo json_encode([
							'status' => 'failed'
						]);
					}

				}
			
			}else{
				echo json_encode("INCORRECT QUERY");
			}

			
		}


	}