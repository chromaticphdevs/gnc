<?php 	

	class RFID_Attendance_Check_Modal extends Base_model
	{

		public function attendance_check($data)
		{
			extract($data);

			$this->db->query(
				" SELECT userId FROM rfid_users where UID = '$UID_code' "
			);

			$userId = $this->db->single();	

		
			if(!empty($userId))
			{	

				date_default_timezone_set('Asia/Manila');
				$day = date("l") ;
				
				$this->db->query(
					" SELECT  branchId, time, day FROM schedule_members where day = '$day' "
				);

				$result = $this->db->single();	
				if(!empty($result))
				{	

						$date_now = date('Y-m-d') ;

						$this->db->query(
							" SELECT * FROM `rfid_attendance` WHERE `UID` = '$UID_code' AND `DATE` = '$date_now' "
						);
	
						$result2 = $this->db->single();	
						if(empty($result2))
						{

								$renderedImage = $this->renderPhoto($faceimage);

								//$checkTime = date("h:i:s",strtotime("-30 minutes"));// subtract 30 mins;

								$checkTime = date("H:i:s");

								$baseTime = $result->time;


								if($baseTime > $checkTime){
					
										$this->db->query(
											"INSERT INTO `rfid_attendance`(`UID`,`userId`, `date`, `time`, `status`, `image`)

											 VALUES ('$UID_code', '$userId->userId', '$date_now','$checkTime', 'on_time', '$renderedImage')"
										);

										$this->db->execute();

										echo '1';
										Flash::set("On Time");
										//redirect('RFID_Attendance');
								}else{

										$this->db->query(
											"INSERT INTO `rfid_attendance`(`UID`,`userId`,`date`, `time`, `status`, `image`) 
											
											 VALUES ('$UID_code', '$userId->userId', '$date_now','$checkTime', 'late', '$renderedImage')"
										);
										
										$this->db->execute();

										echo '2';
										Flash::set("Late");
										//redirect('RFID_Attendance');
								
								}

						}else
						{

						echo '3';
						Flash::set("Attendance is Already Recorded");
						//redirect('RFID_Attendance');

						}	

				}else
				{
	
						echo '4';	
						Flash::set("No Schedule for Today ");
						//redirect('RFID_Attendance');

				}		

			}else
			{
				
				echo '5';	
				Flash::set(" Invalid ID! ");
				//redirect('RFID_Attendance');
			}


		}

		public function list($userId){

			$this->db->query(
				"SELECT UID, date,time,status,image,
				 (SELECT count(*) FROM `rfid_attendance` WHERE userId = '$userId' and status = 'late' )as num_late,
				 (SELECT count(*) FROM `rfid_attendance` WHERE userId = '$userId' and status = 'on_time' )as num_onTime 
				 FROM `rfid_attendance` WHERE userId = '$userId' "
			);

			return $this->db->resultSet();
		}


		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/RFID_Attendance/';
		  
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