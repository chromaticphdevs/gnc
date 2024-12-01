<?php
	/*
	*This is the main class for users
	*/
	class LDUserModel extends Base_model
	{
	// private $table_name = 'ld_users';

	public function __construct()
	{
		$this->table_name = 'ld_users';

		parent::__construct();

		// parent::__construct();
		//database not called
	}


	public function update($values , $id)
	{
		$data = [
			'users' ,
			$values ,
			" id = '$id'"
		];

		return $this->dbHelper->update(...$data);
	}

	public function create_account($accountInfo)
	{
		extract($accountInfo);

		$password='123456';

			$this->db->query(
				"SELECT  `email` FROM `ld_users` WHERE  `email`='$username'"
			);

			//check duplicated email
			$result=$this->db->resultSet();
			if($result==null)
			{

				if(strlen($phone)>=13){
						Flash::set('Phone Number is too long ','negative');
						redirect('/LDUser/register');
						return false;
				}
				date_default_timezone_set("Asia/Manila");

				$fulladdress="";
				$this->db->query(
					"INSERT INTO `ld_users`(`firstname`, `middlename`, `lastname`, `email`, `password`, `phone` , `user_type`,`address`,`branch_id`)
				VALUES ('$firstname','$middlename','$lastname','$username','$password','$phone','$user_type','$fulladdress','$branch')"
				);

				if($this->db->execute()){
					Flash::set("User Created","positive");
					redirect('/LDUser/create_account');
				}else{
					Flash::set("error");
					redirect('/LDUser/create_account');
				}

			}else{
					Flash::set('Username already exist','positive');
					redirect('/LDUser/create_account');
		    }

	}


	public function geneology_sample($userID)
	{
		$this->db->query(
			"SELECT * FROM `users` WHERE direct_sponsor=(SELECT id from users where dbbi_id='$userID')"
		);

		return $this->db->resultSet();
	}

	public function fireLogin($loginInfo){

		extract($loginInfo);

		/*$this->db->query(
			"SELECT `email`, `password`, `phone` FROM `ld_users` WHERE  (`phone`='$email_num' OR `email`='$email_num') AND `password`!='$pass'"
		);

		$result2=$this->db->single();
		if(!empty($result2))
		{
			Flash::set('Incorrect Password' , 'negative');
			redirect('LDUser/login');
		}else
		{*/

		//$sql = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM $this->table_name WHERE (`email`='$email_num' AND `password`='$pass') OR (`phone`='$email_num' AND `password`='$pass')";

		$sql = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM $this->table_name WHERE `email`='$email_num'  OR `phone`='$email_num' ";


		$this->db->query($sql);
	    $result = $this->db->single('UserObj');

       	if(empty($result))
       	{
       		Flash::set('No user found' , 'negative');
			redirect('LDUser/login');
    	}else{

    	 	//check if has class
    	 	$class = $result->getClass();

	 		$user = [
	 			'id' => $result->id,
	 			'firstname' => $result->firstname,
	 			'middlename' => $result->middlename,
	 			'lastname' => $result->lastname,
	 			'email' => $result->email,
	 			'password' => $result->password,
	 			'phone' => $result->phone,
	 			'type' => $result->user_type,
	 			'active_status' => $result->active_status,
	 			'created_on' => $result->created_on,
	 			'fullname' => $result->fullname,
	 			'classid'  => $class->groupid,
	 			'branch_id'  => $result->branch_id
	 		];

    	 	Session::set('loginVerified' , $user);

    	 	redirect('LDUser/face_module');
    	 }
    	//}
      }

      // for cashier attendance check
      public function fireLogin_cashier($username){

		$sql = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM $this->table_name WHERE `email`='$username'";

		$this->db->query($sql);
	    $result = $this->db->single('UserObj');

       	if(empty($result))
       	{
       		Flash::set('No user found' , 'negative');
			redirect('LDUser/login');
    	}else{

    	 	//check if has class
    	 	$class = $result->getClass();

	 		$user = [
	 			'id' => $result->id,
	 			'firstname' => $result->firstname,
	 			'middlename' => $result->middlename,
	 			'lastname' => $result->lastname,
	 			'email' => $result->email,
	 			'password' => $result->password,
	 			'phone' => $result->phone,
	 			'type' => $result->user_type,
	 			'active_status' => $result->active_status,
	 			'created_on' => $result->created_on,
	 			'fullname' => $result->fullname,
	 			'classid'  => $class->groupid,
	 			'branch_id'  => $result->branch_id
	 		];

    	 	Session::set('cashier_check_attendance' , $user);

    	 	redirect('LDCashier/attendance_check');
    	 }
      }



	public function register($customerInfo)
	{
		extract($customerInfo);
		$password='123456';
		//check gps
		/*if($latitude!=null && $longitude!=null)
		{	*/
			$this->db->query(
				"SELECT  `email` FROM `ld_users` WHERE  `email`='$email'"
			);

			//check duplicated email
			$result=$this->db->resultSet();

			if($result==null)
			{
				/*$location=$latitude.','.$longitude;
				$this->db->query(
					"INSERT INTO `ld_temp_user_location`(`username`, `location`) VALUES ('$email','$location')"
				);

				$this->db->execute();*/
				if(strlen($phone)>=13){
						Flash::set('Phone Number is too long ','negative');
						redirect('/LDUser/register');
						return false;
				}
				date_default_timezone_set("Asia/Manila");

				$groupId=date("N", strtotime(date("l")))-1;
				//$home." ".$brgy." ".$city." ".$province;
				$fulladdress="";

				$sql_ld_users = "INSERT INTO $this->table_name(`firstname`, `middlename`, `lastname`, `email`, `password`, `phone` ,`referral_id`, `user_type`,`address`,`branch_id`)
				VALUES ('$firstname','$middlename','$lastname','$email','$password','$phone','$refer','customer','$fulladdress','$branch')";
				$this->db->query($sql_ld_users);

				$upline = $this->binary_model->outDownline( $refer, $position);

				if($lastid = $this->db->insert())
				{

					//insert to social nigga
					$props  = [
						'dbbi_id'        => $lastid,
						'firstname'      => $firstname ,
						'lastname'       => $lastname,
						'username'       => $email,
						'password'       => password_hash($password, PASSWORD_DEFAULT),
						'direct_sponsor' => $refer,
						'upline'         => $upline,
						'L_R'            => $position,
						'new_upline'     => $refer,
						'user_type'      => '2',
						'email'          => $email,
						'address'        => $fulladdress,
						'mobile'         => $phone
					];

					$this->insert_user_to_socialnetwork($props);

					if(Session::get('user')['type']=='admin'){
						redirect('/LDUser/list');
					}else{
						/*mark angelo gonzales*/

						Flash::set("New user has been inserted" , 'success');

				 		$user = [
				 			'id'            => $lastid,
				 			'firstname'     => $firstname,
				 			'middlename'    => $middlename,
				 			'lastname'      => $lastname,
				 			'email'         => $email,
				 			'password'      => $password,
				 			'phone'         => $phone,
				 			'type'          => 'customer',
				 			'active_status' => '1',
				 			'created_on'    => date('Y-m-d'),
				 			'fullname'      => $firstname . ' ' . $lastname,
				 			'classid'       => $groupId,
				 			'branch_id'     => $branch
				 		];

						$file_make="assets/Faces/".$lastid."_".$firstname." ".$lastname;

            			mkdir($file_make);

				 		$this->db->query("INSERT INTO ld_groups_attendees(userid ,groupid ) VALUES('$lastid' , '$groupId' )");
						$this->db->execute();

    	 				Session::set('loginVerified' , $user);

						// redirect('/LDUser/login'); patrick
						redirect('/LDUser/face_module2');

						/*mark angelo gonzales*/

					}
				}else
				{
					Flash::set('Something went wrong','negative');
				}
			}else{
					Flash::set('Email already exist','negative');
					if(Session::get('user')['type']=='admin'){

						redirect('/LDUser/create');

					}else{
						redirect('/LDUser/register');
						// redirect('/LDUser/face_module');

					}
			}
		/*}else
		{
			Flash::set('Turn On GPS','negative');
			redirect('/LDUser/create');
		}	*/
	}

	/*its either code or order*/
	public function update_account($userid , $position , $upline , $activated_by = null)
	{
		if(!is_null($activated_by))
		{
			$this->db->query(
				"UPDATE users set L_R = '$position' , upline = '$upline' ,
				activated_by = '$activated_by'
				WHERE id = '$userid'"
			);
		}else{
			$this->db->query(
				"UPDATE users set L_R = '$position' , upline = '$upline'
					WHERE id = '$userid'"
			);
		}


		try{
			$this->db->execute();
			return true;
		}catch(Exception $e)
		{
			Flash::set($e->getMessage() , 'danger');

			return false;
		}
	}

	public function list()
	{
			$this->db->query(
				"SELECT * FROM users ORDER BY `users`.`created_at` DESC"
			);

			return $this->db->resultSet();
	}



	//ajax live search
	public function live_list($key_word)
	{
		extract($key_word);
			$this->db->query(
				"SELECT id, concat(firstname , ' ' , lastname) as fullname, username FROM users WHERE firstname LIKE '%$data%'  OR lastname LIKE '%$data%'  OR username LIKE '%$data%' OR  concat(firstname , ' ' , lastname) LIKE  '%$data%' LIMIT 5"
			);

			$result = $this->db->resultSet();


             echo '<select class="input100" name="refer" id="refer" required>';

					 foreach($result as $data)
					 {
							echo "
									 <option value=".$data->id.">".$data->fullname." ->( ".$data->username." )</option>

							   ";
					}

			echo '</select>';
	}


	//ajax live search for super admin and admin dbbi
	public function live_list_admin($key_word)
	{
		extract($key_word);
			$this->db->query(
				"SELECT id, concat(firstname , ' ' , lastname) as fullname, email FROM ld_users WHERE firstname LIKE '%$data%'  OR lastname LIKE '%$data%' OR   concat(firstname , ' ' , lastname) LIKE  '%$data%' LIMIT 5"
			);

			$result = $this->db->resultSet();


			echo json_encode($result);
	}




	public function get_recent()
	{
		$this->db->query(
			"SELECT * , concat(firstname , ' ' , lastname) as fullname
				FROM ld_users where date(created_on) = date(now())"
		);

		return $this->db->resultSet();
	}



	public function preview($customerId)
	{
			$sql = "SELECT *, concat('firstname' , ' ' , 'lastname') as fullname

			FROM $this->table_name WHERE  id=$customerId";

			$this->db->query($sql);

		    return $this->db->single('UserObj');
	    }

		public function className($customerId)
		{

	  	}



		public function history($lenderId){

				$sql="SELECT `ld_attendee_histories`.`created_on`,`ld_attendee_histories`.`notes`,ld_attendee_histories.prevgroup as prevG,
					ld_attendee_histories.newgroup as newG,ld_attendee_histories.approved_by as userid_app,
					(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=prevG) as prevgroup,
					(SELECT name FROM `ld_lenders_groups` WHERE ld_lenders_groups.id=newG) as newgroup,
					(SELECT CONCAT (firstname,' ',middlename,'. ',lastname) as name FROM `ld_users` WHERE ld_users.id=userid_app) as approved_by
					FROM `ld_attendee_histories` INNER JOIN `ld_users` ON ld_attendee_histories.userid=ld_users.id
					WHERE ld_attendee_histories.userid='$lenderId'";

					$this->db->query($sql);
					return $this->db->resultSet();

		}


		public function classlist()
		{

			$this->db->query(
				"SELECT userid as userID,(SELECT CONCAT (firstname,' ',middlename,'. ',lastname)  FROM ld_users WHERE id=userID) as NAME FROM `ld_groups_attendees`"
			);

			return $this->db->resultSet();
		}

		public function list_by_branch($branch_id)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name WHERE branch_id='$branch_id' ORDER BY `ld_users`.`created_on` DESC"
			);

			return $this->db->resultSet();
		}


		public function branch_list()
		{
			//"SELECT * FROM `fn_branches` ORDER BY `fn_branches`.`created_at` DESC"
			$this->db->query(
				"SELECT * FROM `fn_branches` WHERE id = '8'"
			);

			return $this->db->resultSet();
		}

		public function branch_vault($branch_id)
		{

			$this->db->query("SELECT balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");
			return $this->db->single();
		}

		public function branch_vault_all()
		{
			$this->db->query("SELECT balance,branch_id, (SELECT branch_name FROM `ld_branch` WHERE id=`ld_branch_vault`.branch_id ) as name FROM `ld_branch_vault`");
			return $this->db->resultSet();
		}

		public function branch_inventory($branch_id)
		{

			$this->db->query("SELECT (SELECT branch_name FROM `ld_branch` WHERE id=`ld_branch_inventory`.`branch_id`) as branch_name,(SELECT name FROM products WHERE id=`ld_branch_inventory`.`product_id`) as product_name, stock FROM `ld_branch_inventory` WHERE branch_id='$branch_id'");
			return $this->db->resultSet();
		}

		public function branch_inventory_all()
		{

			$this->db->query("SELECT (SELECT branch_name FROM `ld_branch` WHERE id=`ld_branch_inventory`.`branch_id`) as branch_name,(SELECT name FROM products WHERE id=`ld_branch_inventory`.`product_id`) as product_name, stock FROM `ld_branch_inventory`");
			return $this->db->resultSet();
		}

		public function save_id_image($imageInfo , $position)
		{
			extract($imageInfo);

			if($position == 'front')
			{
				$renderedImage = $this->renderPhoto($image);

				$this->db->query(
					"UPDATE `ld_users` SET `id_image` = '$renderedImage' WHERE `ld_users`.`id` = '$userid';"
				);

				if($this->db->execute()){

					return [
						'status' => 'success' ,
						'msg'    => 'front'
					];
				}
			}

			if($position == 'back')
			{
				$renderedImage = $this->renderPhoto($image);

				$this->db->query(
					"UPDATE `ld_users` SET `id_image_back` = '$renderedImage' WHERE `ld_users`.`id` = '$userid';"
				);

				$productAmountLoan = 1600;
				$productAmountLoan2 = 1000;
				$cashAmountLoan    = 5000;
				$loanInfo['date']    = date('Y-m-d');
				$loanInfo['time']    = date('H:i:s');
				$loanInfo['userid']  = $userid;
				$loanInfo['note'] = 'Automated Loan';
				$loanInfo['branch_id'] = $branch_id;
				$loanInfo['amount']  = $cashAmountLoan;
				/*insert automatedloan cash*/
				$this->automatedLoan($loanInfo, 'cash');
				for($i=1; $i<=8; $i++){
				$cashAmountLoan  = $cashAmountLoan  * 2;

				$loanInfo['amount']  = $cashAmountLoan;

				/*insert automatedloan cash*/
				$this->automatedLoan($loanInfo, 'cash');

				}

				/*insert change amount to product*/
				$loanInfo['amount']  = $productAmountLoan;
				$loanInfo['productid'] = 33; //0 means autoloan

				/*insert automatedloan product*/
				$this->automatedLoan($loanInfo, 'product');
				$loanInfo['amount']  = $productAmountLoan2;
				$loanInfo['productid'] = 66; //0 means autoloan

				/*insert automatedloan product*/
				$this->automatedLoan($loanInfo, 'product');

				if($this->db->execute()){
					return [
						'status' => 'success' ,
						'msg'    => 'back'
					];
				}
			}

		}

		/*
		*LoanType
		*Product /  Cash
		*/
		private function automatedLoan(array $loanInfo , $loanType)
		{

			if($loanType == 'cash')
			{
				return $this->LDCashModel->call_create($loanInfo);
			}

			if($loanType == 'product')
			{
				return $this->LDProductModel->call_create($loanInfo);
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


		//face registration for image processing
		public function save_face_image($name,$path,$image)
		{

			$renderedImage = $this->saveFace($image,$name,$path);
			echo $renderedImage;
		}




		private function saveFace($image,$name,$path)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/Faces/'.$path.'/';

		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];

		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName =$name . '.jpg';

		    $file = $folderPath . $fileName;
		    file_put_contents($file, $image_base64);

		   return $fileName;
		}

		public function total_referral($userId)
		{
			$this->db->query(
				"SELECT COUNT(`id`)as referral_total FROM `ld_users` WHERE referral_id='$userId'"
			);

			return $this->db->single();

		}

		public function total_weeks($userId)
		{
			$this->db->query(
				"SELECT date(created_on) as total_weeks FROM `ld_users` WHERE id='$userId'"
			);
			$created_on=$this->db->single();

			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$first = DateTime::createFromFormat('Y-m-d', $created_on->total_weeks);
		    $now = DateTime::createFromFormat('Y-m-d', $today);

		 	return floor($first->diff($now)->days/7);
		}

		public function collection_summary()
		{

			$today = date("Y-m-d H:i:s");

			$this->db->query(
				"SELECT id ,
					(SELECT ifnull(sum(amount),0) as total from ld_cash_payments where is_approved = true and date(created_on) = date('$today') and branch_id=ld_branch.id) as cash_payment_total,
					(SELECT ifnull(sum(interest_amount),0) as total from ld_cash_payments where is_approved = true and date(created_on) = date('$today') and branch_id=ld_branch.id) as cash_interest_total,
					(SELECT ifnull(sum(amount),0) as total from ld_product_payments where is_approved = true and date(created_on) = date('$today') and branch_id=ld_branch.id) as product_payment_total,
						branch_name FROM ld_branch"
			);
			return $this->db->resultSet();

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
			// $this->db->query(

			// );

			// $this->db->query("INSERT INTO `users`(`firstname`, `lastname`, `username`, `password`, `direct_sponsor`, `upline`, `L_R`, `new_upline`, `user_type`, `email`, `address`, `mobile`)
			// 	VALUES ('$firstname','$lastname','$email','$password','$refer','$refer','LEFT','$refer','2','$email','$fulladdress','$phone')");

			// 	$this->db->execute();
		}


		public function pre_register($customerInfo)
		{

			extract($customerInfo);

				$password="123456";
				$check_error_value = 0;
				$this->db->query(
					"SELECT  `username` FROM `users` WHERE  `username`='$username'"
				);

				//check duplicated email
				$result=$this->db->resultSet();

				if($result==null)
				{


					$this->db->query(
					"SELECT  `email` FROM `users` WHERE  `email`='$email'"
					);
					//check duplicated email
					$email_result=$this->db->resultSet();

					if($email_result != null)
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
					$mobile_result=$this->db->resultSet();

					if($mobile_result != null)
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

						$groupId=date("N", strtotime(date("l")))-1;

						//$address = $house_st.", ".$brgy.", ".$city.", ".$province.", ".$region;

						$this->db->query("INSERT INTO pre_register_users( `firstname`, `middlename`, `lastname`, `phone`, `address`, `email`, `username`, `password`, `referral_id`, `note`, `religion_id`)
						VALUES ('$first_name','$middle_name','$last_name','$cp_number','','$email','$username','$password','$refferal_ID','pre-registration for Social Refferal', '$religion_id')");
						$this->db->execute();

						$upline = $this->binaryModel->outDownline( $refferal_ID, $position);
							//insert to social nigga
							$props  = [
									//'dbbi_id'        => $lastid,
									'firstname'      => $first_name ,
									'middlename'      => $middle_name,
									'lastname'       => $last_name,
									'username'       => $username,
									'password'       => password_hash($password, PASSWORD_DEFAULT),
									'direct_sponsor' => $refferal_ID,
									'upline'         => $upline,
									'L_R'            => $position,
									'new_upline'     => $refferal_ID,
									'user_type'      => '2',
									'email'          => $email,
									//'address'        => $address,
									'mobile'         => $cp_number,
									'branchId'       => $branch,
									'religion_id'    => $religion_id,
									'mobile_verify'  => 'verified',
									'account_tag'    => 'main_account'
							];

							$this->insert_user_to_socialnetwork($props);
							echo 'OKOK';
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


		public function pre_register_geneology($customerInfo)
		{

			extract($customerInfo);

			$password="123456";

			date_default_timezone_set("Asia/Manila");

			$groupId=date("N", strtotime(date("l")))-1;

			//$address = $house_st.", ".$brgy.", ".$city.", ".$province.", ".$region;

			$this->db->query("INSERT INTO pre_register_users( `firstname`, `middlename`, `lastname`, `phone`, `address`, `email`, `username`, `password`, `referral_id`, `note`, `religion_id`)
			VALUES ('$first_name','$middle_name','$last_name','$cp_number','','$email','$username','$password','$refferal_ID','pre-registration for Social Refferal', '$religion_id')");
			$this->db->execute();


			$Upline = $upline;

			$this->db->query(
						"SELECT username FROM `users` WHERE upline = '$Upline' and L_R = '$position'"
						);

			$check_upline = $this->db->resultSet();

			if(!empty($check_upline))
			{
				$Upline = $this->binaryModel->outDownline($Upline, $position);
			}

				$props  = [

						'firstname'      => $first_name ,
						'middlename'      => $middle_name,
						'lastname'       => $last_name,
						'username'       => $username,
						'password'       => password_hash($password, PASSWORD_DEFAULT),
						'direct_sponsor' => $refferal_ID,
						'upline'         => $Upline,
						'L_R'            => $position,
						'new_upline'     => $refferal_ID,
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
						redirect('LDUser/pre_register_login');
					}

			}else{

				Flash::set('Account Already Activated');
				redirect('LDUser/pre_register_login');

			}

		}else{
			Flash::set('Account does not exists');
			redirect('LDUser/pre_register_login');
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

		/*
		*method for getting specified field on users
		* and a dynamic condition
		*/
		public function getRawSingle(array $fields , $where = null)
		{
			$data = [
				'users' ,
				$fields,
				$where
			];

			return $this->dbHelper->single(...$data);
		}

		public function getRawMultiple(array $fields , $where = null , $order_by = null)
		{
			$data = [
				'users' ,
				$fields,
				$where,
				$order_by
			];

			return $this->dbHelper->resultSet(...$data);
		}

		public function getChooseField($fields , $id)
		{
			$data = [
				'users',
				$fields,
				" id = '{$id}'"
			];

			return $this->dbHelper->single(...$data);
		}


		public function getResultsField($fields , $where)
		{
			$fieldsStr = implode(' , ' ,$fields);

			$where = " WHERE {$where}";

			$this->db->query(
				"SELECT $fieldsStr FROM users
					$where"
			);
			return $this->db->resultSet();
		}


		public function deleteUsers($userIds)
		{
			$userIdsString = implode(',' , $userIds);

			$this->db->query(
				"DELETE FROM users where id in($userIdsString)"
			);
			
			return $this->db->execute();
		}
	}
