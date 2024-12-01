<?php 	

	class LDClassLogger extends Base_model
	{	

		private $table_name = 'ld_individual_attendances';
		private $full_name;


		public function fireLogger($classid = null, $userid , $faceimage)
		{

			$renderedImage = $this->renderPhoto($faceimage);
			
			
			if(empty($classid))
			{	

				$verifiedUser = Session::get('loginVerified');
				$this->full_name  = Session::get('loginVerified');
				Session::remove('loginVerified');
				Session::set('user' , $verifiedUser);
				Flash::set('Welcome User ' . $verifiedUser['fullname']);
				$res = 
					$this->insertLog(null , $userid , 0 , 'NO SCHEDULE' , $renderedImage);
					echo $res;

			}else
			{

				$class = $this->LDClassModel->view($classid);
				/*REMOVE SESSION*/

				$verifiedUser = Session::get('loginVerified');
				$this->full_name  = Session::get('loginVerified');
				Session::remove('loginVerified');
				Session::set('user' , $verifiedUser);
				Flash::set('Welcome User ' . $verifiedUser['fullname']);
				/*current month schedule*/

				if(!empty($class))
				{
					if($this->isSchedule( $class->getMonthSchedule() )){
							//check if late
							if($this->isLate($class->time))
							{
								$res = 
									$this->insertLog($classid , $userid , 1 , 'HAS SCHEDULE' , $renderedImage);
								echo $res;
							}else
							{

								$res = 
									$this->insertLog($classid , $userid , 0 , 'HAS SCHEDULE' , $renderedImage);
								echo $res;
							}
					}else
					{
						$res = 
							$this->insertLog($classid , $userid , 0 , 'NO SCHEDULE' , $renderedImage);
							echo $res;
					}

				}else
				{
					$res = 
						$this->insertLog(0 , $userid , 0 , 'NO SCHEDULE' , $renderedImage);
						echo $res;


				}
			}

		}

		//for cashier attendance check
		public function fireLogger_manual_cashier($classid = null, $userid , $faceimage)
		{


			$renderedImage = $this->renderPhoto($faceimage);

		
			$class = $this->LDClassModel->view($classid);

			/*REMOVE SESSION*/

			$verifiedUser = Session::get('cashier_check_attendance');
			$this->full_name  = Session::get('cashier_check_attendance');
			Session::remove('cashier_check_attendance');
	
			/*current month schedule*/

			if(!empty($class))
			{
				if($this->isSchedule( $class->getMonthSchedule() )){
						//check if late
						if($this->isLate($class->time))
						{
							$res = 
								$this->insertLog($classid , $userid , 1 , 'HAS SCHEDULE' , $renderedImage);
							echo $res;
						}else
						{

							$res = 
								$this->insertLog($classid , $userid , 0 , 'HAS SCHEDULE' , $renderedImage);
							echo $res;
						}
				}else
				{
					$res = 
						$this->insertLog($classid , $userid , 0 , 'NO SCHEDULE' , $renderedImage);
						echo $res;
				}

			}else
			{
				$res = 
					$this->insertLog(0 , $userid , 0 , 'NO SCHEDULE' , $renderedImage);
					echo $res;
			}
		}


		/*
		*@param
		*pass class date and time schedule
		*pass login date and time
		*/
		private function isLate($baseTime )
		{	
			$checkTime = date("h:i:s",strtotime("-30 minutes"));// subtract 30 mins;

			$baseTime  = strtotime($baseTime);
			if($baseTime > $checkTime){
				return true;
			}else{
				return false;
			}
		}

		private function isSchedule($classSechedules){
			/*format*/
			$today = date('Y M D d' , time());

			if(in_array($today , $classSechedules)){
				return true;
			}return false;
		}


		private function insertLog($groupid = null , $userid , $isLate , $notes , $faceimage){

			$time = date('H:i:s');
			$day  = getDay();
			$date = date('Y-m-d');
			if($groupid == null)
			{

				$sql = "INSERT INTO $this->table_name(`date`,`time`, `day` , `groupid` ,`userid` , `is_late` , 
					`notes` , `faceimage`)
					VALUES('$date','$time' , '$day' ,null, '$userid' , '$isLate' , 
					'$notes' , '$faceimage')";
			}else
			{

				$sql = "INSERT INTO $this->table_name(`date`,`time`, `day` , `groupid` ,`userid` , `is_late` , 
					`notes` , `faceimage`)
					VALUES('$date','$time' , '$day' ,'$groupid' , '$userid' , '$isLate' , 
					'$notes' , '$faceimage')";
			}
		

			$this->db->query($sql);

			if($this->db->execute()){
				
				echo $faceimage."&name=".$userid."_".$this->full_name['fullname'];
			}else{
				return false;
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