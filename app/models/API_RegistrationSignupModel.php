<?php 	

	class API_RegistrationSignupModel extends Base_model
	{

	// private $table_name = 'ld_users';

	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'ld_users';

		$this->binaryModel = new Binary_model();
		$this->binarypv_model = new Binarypv_model();
	}
	public function branch_list()
	{
		//"SELECT * FROM `fn_branches` ORDER BY `fn_branches`.`created_at` DESC"
		$this->db->query(
			"SELECT * FROM `fn_branches` WHERE id = '8'"
		);

		return $this->db->resultSet();
	}

	/*
	*USED FOR API PRE-REGISTRATION
	*SIGNUP-E.com
	**/
	public function pre_register_geneology($customerInfo)
	{
		extract($customerInfo);

		//$password="123456";

		date_default_timezone_set("Asia/Manila");

		$groupId=date("N", strtotime(date("l")))-1;

		$address = $house_st.", ".$brgy_text.", ".$city_text.", ".$province_text.", ".$region_text;

		/*$this->db->query("INSERT INTO pre_register_users( `firstname`, `middlename`, `lastname`, `phone`, `address`, `email`, `username`, `password`, `referral_id`, `note`, `religion_id`)
		VALUES ('$first_name','$middle_name','$last_name','$cp_number','','$email','$username','$password','$refferal_ID','pre-registration for Social Refferal', '$religion_id')");*/


		//check exists

		$this->db->query(
			"SELECT * FROM users
				WHERE mobile = '$cp_number'
				and email = '$email'
				and username = '$username' "
		);

		$isExist = $this->db->single();

		if($isExist){
			$this->error = " User already exists ";
			return true;
		}
		

		$this->db->query("INSERT INTO pre_register_users( `firstname`, `middlename`, `lastname`, `phone`, `address`, `email`, `username`, `password`, `referral_id`, `note`, `religion_id`)
		VALUES ('$first_name','$middle_name','$last_name','$cp_number','$address','$email','$username','$password','$refferal_ID','pre-registration for Social Refferal', '')");
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
			'address'        => $address,
			'mobile'         => $cp_number,
			'branchId'         => $branch,
			//'religion_id'         => $religion_id,
			'mobile_verify'         => 'verified',
			'account_tag'         => 'main_account'
		];

		return $this->insert_user_to_socialnetwork($props, $lbc, $current_loc);
	}

  	private function insert_user_to_socialnetwork($props, $lbc_branch, $current_location)
	{
		$keys = array_keys($props);

		$values = array_values($props);

		$this->db->query("
				INSERT INTO users(".implode(' , ', $keys).")
					VALUES('".implode("','", $values)."')");
		try{

			$userid = $this->db->insert();

			$this->db->query("INSERT INTO `user_addresses` (`userid`, `address`, `status`, `type`)
						      VALUES ('$userid', '$lbc_branch', 'active', 'COP');");
			$this->db->execute();

			$this->save_current_location($userid, $current_location);

			return true;
		}catch(Exception $e) {
			die($e->getMessage());
		}
	}

	public function save_current_location($userid, $location)
	{
		$this->db->query("INSERT INTO `user_current_location` (`userid`, `location`)
					      VALUES ('$userid', '$location');");
		$this->db->execute();
	}

	public function checkPersonExists($firstname, $middle_name, $lastname)
	{
		$data = [
			'users',
			'*',
			" firstname = '{$firstname}' and lastname = '{$lastname}' and middlename = '{$middle_name}'"
		];

		return $this->dbHelper->single(...$data);
	}

	public function checkFieldExists($field , $value)
	{
		$data = [
			'users',
			'*',
			" $field = '{$value}'"
		];

		return $this->dbHelper->single(...$data);
	}

	//check if $firstname, $middle_name, $lastname and mobile is match for account updating 
	//$mobile
	public function new_validation($firstname, $middle_name, $lastname)
	{
		$today = date("Y-m-d");

		$this->db->query(
			"SELECT * FROM `users` WHERE DATEDIFF('{$today}', DATE(created_at)) >= 30 
			 and status ='pre-activated' and account_tag = 'main_account' AND firstname = '{$firstname}' 
			 and lastname = '{$lastname}' and middlename = '{$middle_name}' 
			 and (SELECT COUNT(*) FROM `fn_product_release` WHERE `userid` = users.id ) <= 0 
			 ORDER BY `users`.`id` DESC"
		);

		return $this->db->single();

		/* and mobile = '{$mobile}'*/ 
	}

	public function saveTextCode($mobileNumber , $code) 
	{
		$network = sim_network_identification($mobileNumber);
		
		$this->db->query(

		   "INSERT INTO `text_codes`(`number`, `network`, `code`)
		   	VALUES ('$mobileNumber','$network','$code')"
		);

		return $this->db->execute();

		/*$message = "Hi, your verification code is ".$code."\n\n Breakthrough E-COM \n\n";
		itexmo($mobileNumber,$message , ITEXMO,ITEXMO_PASS);

		return true;*/

	}


	/**
	*Depricated not used on API 
	*PROCESS
	*/
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

				$this->db->query(

				   "INSERT INTO `text_codes`(`number`, `code`)
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


	/*
	*USED FOR UPDATE USER DATA IF THE FULLNAME IS Exist
	*SIGNUP-E.com
	**/
	public function update_user_info($customerInfo,$old_userid)
	{
		extract($customerInfo);

		$password=password_hash("123456", PASSWORD_DEFAULT);

		date_default_timezone_set("Asia/Manila");

		$groupId=date("N", strtotime(date("l")))-1;

		$address = $house_st.", ".$brgy_text.", ".$city_text.", ".$province_text.", ".$region_text;

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

		$this->db->query("UPDATE `users` 
						  SET `username`='$username',`password`='$password',`direct_sponsor`='$refferal_ID',
						  `upline`='$Upline',`L_R`='$position',`new_upline`='$refferal_ID',`branchId`='$branch',
						  `user_type`='2',`email`='$email',`religion_id`='$religion_id',`address`='$address',
						  `mobile`='$cp_number',`mobile_verify`='verified',`account_tag`='main_account' 
						  WHERE id='$old_userid'");

		return $this->db->execute();
	}


	/*NEW! updated april 8, 2021 4:30pm patrick de guzman
	*USED FOR UPDATE USER DATA IF THE FULLNAME IS Exist
	*SIGNUP-E.com
	**/
	public function new_update_user_info($customerInfo)
	{
		extract($customerInfo);

		$password=password_hash($password, PASSWORD_DEFAULT);

		$address = $house_st.", ".$brgy_text.", ".$city_text.", ".$province_text.", ".$region_text;

		$Upline = $upline;

		$this->db->query(
			"SELECT username FROM `users` WHERE upline = '$Upline' and L_R = '$position'"
		);

		$check_upline = $this->db->resultSet();

		if(!empty($check_upline))
		{
			$Upline = $this->binaryModel->outDownline($Upline, $position);
		}

		if($Upline == $userid)
		{
			$Upline = $upline;
		}

		$this->db->query("UPDATE `users` 
						  SET `username`='$username',`password`='$password',`direct_sponsor`='$refferal_ID',
						  `upline`='$Upline',`L_R`='$position',`new_upline`='$refferal_ID', `mobile`='$cp_number'
						  ,`email`='$email',`address`='$address'
						  WHERE id='$userid'");

		return $this->db->execute();
	}


	public function set_time_zone()
	{
		$this->db->query("SET time_zone = '+08:00'");
   		$this->db->execute();
	}

	public function get_total_registration_today()
	{	
		$this->set_time_zone();

		$date = date("Y-m-d");

		$this->db->query(
				"SELECT COUNT(*) as total_today 
				 FROM `users` 
				 WHERE DATE(created_at) = '$date'"
		);
			
		return $this->db->single();
	}
}