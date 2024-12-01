<?php 	

	class SNEFacialRecognitionModel extends Base_model
	{

		private $table_name = 'sne_face_recognitions';

		public function get_user($userid) 
		{
			return $this->userModel->get_user($userid);
		}


		public function get_auth_detail($userid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name where userid = '$userid'"
			);

			return $this->db->single();
		}

		public function activate($userid , $faceImage , $userAgent)
		{
			$result = $this->request_faceauth_service_register($userid , $faceImage);

			$requestResult = json_decode($result['values']);

			/*IF FACE IS RECOGNIZE*/
			if($requestResult->result == 'Face Added Successfuly') 
			{
				$result = $this->save_face_auth($userid , $faceImage , $userAgent);

				if($result) {
					return true;
				}
			}else{


				die(var_dump($result['curlInfo']));
			}
		}

		public function login($faceImage)
		{
			$userVerify = $this->request_faceauth_service_login($faceImage);

			$verifyResult = json_decode($userVerify['values']);

			if(isset($verifyResult->result)) {

				$userid = $verifyResult->result;

				$user = $this->get_auth_detail($userid);


				if(!$user) 
				{
					$account = $this->userModel->get_user($verifyResult->result);

					$accountInfo = "{$account->fullname} {$account->username} ID: {$verifyResult->result}";

					Flash::set("Face found but account is not yet registered Account: {$accountInfo}");

					return false;
				}else{

					$user = $this->userModel->get_user($verifyResult->result);

					Session::set('FaceRecogUserSession' , $user);

					$user_session = [
						'id'              => $user->id ,
						'type'            => $user->user_type,
						'selfie'          => $user->selfie,
						'firstname'       => $user->firstname,
						'lastname'        => $user->lastname,
						'username'        => $user->username,
						'status'          => $user->status,
						'is_activated'    => $user->is_activated
					];

					//get user accounts and put in session
					$user_account_list = [];

					$user_account_list["by_name"] = $this->User_Account_Model->search_by_name($user->firstname, 
						$user->lastname, $user->id);

					$user_account_list["by_email"] = $this->User_Account_Model->search_by_email($user->email, $user->id);

					Session::set('USERSESSION' , $user_session);
					Session::set('MY_ACCOUNTS' , $user_account_list);
					set_logged_in();//set user login

					return true;
				}
				
			}else{

				return $userVerify;
			}

		}

		/*type is register and verify*/
		private function make_request_faceauth_service($payload , $type)
		{
			if(!in_array($type,['register' , 'verify'])) {
				die('Micro service request error');
			}

			$url = 'https://facenet-pytorch-api.onrender.com';

			if($type == 'register')
			{
				$url .= '/api/register';
			}

			if($type == 'verify') {
				$url .= '/api/verify';
			}

			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
			 
			// Set HTTP Header for POST request 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/json',
			    'Content-Length: ' . strlen($payload))
			);

			// Submit the POST request
			$result = curl_exec($ch);

			$data = [
				'values'    => $result ,
				'curlInfo'  => curl_getinfo($ch)
			];

			return $data;
		}

		private function request_faceauth_service_register($userid , $faceImage)
		{
			$faceImage = substr($faceImage, 22);//remove unwanted strings

			$postValues = [
				'id'    => $userid , 
				'image' => $faceImage
			];

			$payload = json_encode($postValues);


			$result = $this->make_request_faceauth_service($payload , 'register');

			return $result;
		}

		private function request_faceauth_service_login($faceImage)
		{
			$faceImage = substr($faceImage, 22);//remove unwanted strings

			$postValues = [
				'id'    => '1' , 
				'image' => $faceImage
			];

			$payload = json_encode($postValues);


			$result = $this->make_request_faceauth_service($payload , 'verify');

			return $result;
		}

		private function save_face_auth($userid , $faceImage , $userAgent)
		{

			$photo = $this->renderPhoto($faceImage);

			$this->db->query(
				"INSERT INTO $this->table_name(userid , face_image , user_agent)
				VALUES('$userid' , '$photo' , '$userAgent')"
			);

			try{

				$this->db->execute();

				return true;
			}catch(Expception $e) 
			{
				die($e->getMessage());
			}
		}

		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath . $fileName;

		    file_put_contents($file, $image_base64);

		    return $fileName;
		}

	}