<?php 	

	class RFID_User_UID_Modal extends Base_model
	{

		public function record_user_UID($UID_code)
		{
			extract($UID_code);


			$this->db->query(
				" SELECT UID FROM rfid_users where UID = '$UID_code' "
			);

			$result = $this->db->single();	

		
			if(empty($result))
			{	
				
					$this->db->query(
						" SELECT userId FROM rfid_users where userId = '$refer' "
					);

					$result = $this->db->single();	

				
					if(empty($result))
					{	

						$this->db->query(
							"INSERT INTO `rfid_users`(`UID`, `userId`) VALUES ('$UID_code', '$refer')"
						);

						
						$this->db->execute();

						Flash::set("Users RFID Recorded");
						redirect('RFID_Register');

					}else
					{

						Flash::set("User has Already Have an RFID");
						redirect('RFID_Register');

					}	

			}else
			{

				Flash::set("RFID Already Used");
				redirect('RFID_Register');

			}	

		}

	}