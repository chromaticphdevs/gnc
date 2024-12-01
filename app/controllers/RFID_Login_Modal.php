<?php 	

	class RFID_Login_Modal extends Base_model
	{
		
		public function account_details($UID)
		{
			extract($UID);

			$this->db->query(
				" SELECT userId FROM rfid_users where UID = '$UID' "
			);

			$result = $this->db->single();	
		
			if(!empty($result)){
			
				$this->db->query(
					" SELECT * FROM users where id = '$result->userId' "
				);

				return $this->db->single();

			}else{

				return false;
			}
				

		}

		public function take_pic($userInfo){

			extract($userInfo);


			$renderedImage = $this->renderPhoto($faceimage);

			$this->db->query(
				"INSERT INTO `rfid_login_logger`( `userId`, `image`) VALUES ('$userId', '$renderedImage')"
			);

			$this->db->execute();

		}

		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/RFID_login/';
		  
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