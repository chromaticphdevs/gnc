<?php 	

	class FaceRecognitionModel extends Base_model
	{

		private $table_name = 'face_recognitions';

		public function register($photo , $userInfo) 
		{
			//render photo;
			$registration_face = $this->renderPhoto($photo);

			extract($userInfo);


			$this->db->query(
				"INSERT INTO $this->table_name(
				fullname , age , gender , registration_face
				)VALUES('$fullname' , '$age' , '$gender' , '$registration_face')"
			);

			try
			{

				$userid = $this->db->insert();

				$photo = substr($photo, 22);//remove unwanted strings

				$result = $this->register_face($photo , $userid);

				if(!empty($result)) {
					return true;
				}

				return false;

			}catch(Exeption $e) {

				die($e->getMessage());
			}
		}


		public function register_face($photo , $userid)
		{
			
			$data = [
				'id'  => $userid,
				'image' => $photo
			];


			$requestoURl = $this->make_request($this->get_url('register') ,$data );


			return $requestoURl;
		}

		public function login($photo)
		{	
			$photo = substr($photo, 22);//remove unwanted strings

			$data = [
				'id'  => '1',
				'image' => $photo
			];

			$requestoURl = $this->make_request($this->get_url('verify') ,$data );

			$requestResult = json_decode($requestoURl);

			if($requestResult->result == 'Face Not Found') {
				return '';
			}else{
				$userinfo = $this->get_user($requestResult->result);

				if(!empty($userinfo)) {
					$userinfo->imageWithPath = URL.DS.'public/assets/'.$userinfo->registration_face;

					return $userinfo;
				}else{
					return 'user not found';
				}
				
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

		private function get_user($userid)
		{
			$this->db->query(
				"SELECT * FROM face_recognitions where id = '$userid'"
			);

			return $this->db->single();
		}

		private function make_request($url , array $postValues)
		{

			$payload = json_encode($postValues);

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
				'result'    => $result ,
				'curlInfo'  => curl_getinfo($ch)
			];

			return $result;
		}

		private function get_url($type)
		{

			$url = 'https://facenet-pytorch-api.onrender.com';

			// $url = 'http://192.168.0.22:8000';

			if($type == 'register') {
				return "{$url}/api/register";
			}

			if($type == 'verify') {
				return "{$url}/api/verify";
			}
			
		}
	}
