<?php 	

	class GsmArduinoModel extends Base_model
	{

		public function get_pre_activated($days)
		{

			$this->db->query(
				"SELECT * FROM `users` 
				WHERE DATEDIFF('2021-04-28', DATE(created_at)) >= {$days} 
				AND username != 'breakthrough' AND username != 'duplicate' 
				AND `status` = 'pre-activated' GROUP BY mobile 
				ORDER BY `id` DESC"
			);

		
			return $this->db->resultSet();
		
		}

		public function sent_links($userid, $number)
		{
			$this->db->query(
			   "INSERT INTO `sent_links_temp`( `userid`, `number`) 
			    VALUES ('$userid','$number')"
			);

			$this->db->execute();
		}

		public function already_sent($userid)
		{
			$this->db->query(
				"SELECT * FROM `sent_links_temp` 
				WHERE `userid` = {$userid} "
			);
			return $this->db->single();
		}

		public function create_data($msg)
		{
			$this->db->query(
						   "TRUNCATE breaqidb_ecommerce.mass_sms"
						);
			$this->db->execute();

			$this->db->query(
				"SELECT id,mobile FROM `users`"
			);

			$result = $this->db->resultSet();

			if(!empty($result))
			{

				foreach ($result as $key => $value) {

						if(is_numeric($value->mobile) == 1){


							if(strlen($value->mobile) == 11)
							{
								if(substr($value->mobile, 0, 2) == "09"){
									$this->db->query(
									   "INSERT INTO `mass_sms`( `userid`, `number`, `msg`) VALUES ('$value->id','$value->mobile','$msg')"
									);

									$this->db->execute();

								}
							}


						}

				}

				Flash::set("Mass SMS is Starting!");
				redirect('/GsmArduino/mass_sms');
			}
						
		}

		public function updateStatus_mass_sms($number)
		{

			$this->db->query(

			   "UPDATE `mass_sms` 
				SET `status` = 'sent' 
				WHERE `mass_sms`.`number` = '$number';"
			);

			$this->db->execute();


		}

		public function get_numbers_mass_sms($client_id)
		{

			$this->db->query(
				"SELECT id,number,code,category FROM `text_codes` 
				 WHERE status='on progress' AND client_id='$client_id' 
				 ORDER BY `id` ASC"
			);

		
			$result = $this->db->single();
			if(!empty($result))
			{

			$data = [	
						'id' => $result->id,
 						'number' => $result->number ,
						'code'    => $result->code,
						'category'=> $result->category
					];
			return $data;

			}
		}
		////////////////////product advance

		public function create_data_product_advance($data, $admin_msg)
		{
			
			if(!empty($data))
			{
				$this->db->query(
						   "TRUNCATE breaqidb_ecommerce.mass_sms"
						);
			    $this->db->execute();

				foreach ($data as $key => $value) {

						if(is_numeric($value->mobile) == 1){

							if(strlen($value->mobile) == 11)
							{
								if(substr($value->mobile, 0, 2) == "09"){

									$msg = "Name: ".$value->fullname." Balance: P ".to_number($value->amount - $value->payment)." ".$admin_msg;

									$this->db->query(
									   "INSERT INTO `mass_sms`( `userid`, `number`, `msg`) VALUES ('$value->userid','$value->mobile','$msg')"
									);
									$this->db->execute();
								}
							}
						}
				}
				Flash::set("Mass SMS is Starting!");
				redirect('/GsmArduino/mass_sms');
			}
						
		}

		public function get_released_product_users()
		{	


			$this->db->query(
				"SELECT *,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id =  pr.userid) as fullname,
				 (SELECT mobile FROM users WHERE id =  pr.userid) as mobile,
                 (SELECT SUM(amount) FROM fn_product_release_payment WHERE loanId = pr.id AND status='Approved') as payment
				 FROM `fn_product_release` AS pr 
				 WHERE branchId = '8' and status = 'Approved'"                  
            );

            return $this->db->resultSet();
		}




//----------------------------------------------------------------------------------------------------mass SMS
		public function get_numbers()
		{
			$this->db->query(
				"SELECT number, code,category FROM `text_confirmation_code` WHERE status='pending' ORDER BY `id` ASC LIMIT 1"
			);

			$result = $this->db->single();
			
			if(!empty($result))
			{

				$data = [
					'number' => $result->number ,
					'code'    => $result->code,
					'category' => $result->category
				];
				return $data;

			}
		}

		public function updateStatus($number)
		{

			$this->db->query(

			   "UPDATE `text_codes` 
				SET `status` = 'sent' 
				WHERE `text_codes`.`number` = '$number';"
			);

			$this->db->execute();


		}

		public function register($data)
		{	
			extract($data);

			$code1=random_number();
			$code2=random_number();

			$registration_code=substr($code1,0,2).''.substr($code2,0,2);
			$network = sim_network_identification($cp_number);
			$this->db->query(

			   "INSERT INTO `text_codes`(`number`, `network`, `code`, `category` ) 
			   	VALUES ('$cp_number','$network','$registration_code', '$category')"
			);

			$this->db->execute();
			/*$message = "Hi, your verification code is ".$registration_code."\n\n Breakthrough E-COM \n\n";
			itexmo($cp_number,$message , ITEXMO,ITEXMO_PASS);*/

			return $registration_code;

		}

		public function gsm_sms_test($data)
		{	
			extract($data);

			$code1=random_number();
			$code2=random_number();

			$registration_code=substr($code1,0,2).''.substr($code2,0,2);
			$network = sim_network_identification($cp_number);
			$this->db->query(

			   "INSERT INTO `gsm_sms_test`(`number`, `network`, `code`) 
			   	VALUES ('$cp_number','$network','$registration_code')"
			);

			$this->db->execute();	

			return $registration_code;

		}
		public function get_numbers_test()
		{

			$this->db->query(
				"SELECT number, code,category FROM `gsm_sms_test` WHERE status='pending' ORDER BY `id` ASC LIMIT 1"
			);

		
			$result = $this->db->single();
			if(!empty($result))
			{

			$data = [
						'number' => $result->number ,
						'code'    => $result->code,
						'category' => $result->category
					];
			return $data;

			}
			

			
		}

		public function updateStatus_test($number)
		{

			$this->db->query(

			   "UPDATE `gsm_sms_test` 
				SET `status` = 'sent' 
				WHERE `gsm_sms_test`.`number` = '$number';"
			);

			$this->db->execute();


		}

		public function get_total_sms_sent()
		{
			$this->db->query(
				"SELECT 
				(SELECT COUNT(*)FROM text_codes WHERE status = 'sent' AND category ='OTP') as otp, 
				(SELECT COUNT(*)FROM text_codes WHERE status = 'sent' AND category ='registration') as registration"
			);

		
			return $this->db->single();

		}

		public function insert_location($lat, $lang )
		{

			$this->db->query(

			   "INSERT INTO `gps_logger`(`Latitude`, `Longitude`) VALUES ('$lat','$lang')"
			);

			$this->db->execute();

		}


		public function get_records()
		{
			$this->db->query(
				"SELECT * FROM `gps_logger`"
			);

		
			return $this->db->resultSet();
		}
		
		public function gps_logger_clear_data()
		{

			$this->db->query(
			   "TRUNCATE `breaqidb_ecommerce`.`gps_logger`"
			);

			$this->db->execute();


		}

		public function set_network()
		{
			$this->db->query(
				"SELECT id,number FROM `text_confirmation_code` WHERE network=''"
			);

		
			$data = $this->db->resultSet();

			foreach ($data as $key => $value) {

					$network = sim_network_identification($value->number);

					$this->db->query(

					   "UPDATE `text_confirmation_code` SET `network`='$network' WHERE id = '$value->id'"
					);

					$this->db->execute();

			}
		}

		public function send_text_test()
		{
				$this->db->query(

					   "INSERT INTO `text_confirmation_code`(`number`, `code`)
					   	VALUES ('09478884834','989645')"
					);

					$this->db->execute();
		}



		public function getUnsentMessages()
		{
			$this->db->query(
				"SELECT * FROM text_codes
					WHERE status = 'pending' 
					ORDER BY id ASC"
			);

			return $this->db->single();
		}


		public function sendSMS($data)
		{
			$mobileNumber = $data['mobileNumber'];
			$code = $data['code'];
			$category = $data['category'];
			
			$network = sim_network_identification($mobileNumber);
			
			$this->db->query(
			   "INSERT INTO `text_codes`(`number`, `network`, `code` , `category`) 
			   	VALUES ('$mobileNumber','$network','$code' , '$category')"
			);

			return $this->db->execute();
		}


		public function no_id_notif()
		{
			$this->db->query(
				"SELECT * FROM `users` WHERE DATEDIFF('2021-01-17', DATE(created_at)) <= 150 and status ='pre-activated' and account_tag = 'main_account' and username != 'breakthrough' and username NOT LIKE '%kl1%' and username != 'duplicate' and (SELECT count(*) FROM `users_uploaded_id` WHERE `status` = 'verified' AND userid =users.id ) = 0"
			);

		
			return $this->db->resultSet();
		}


		

	}