<?php

	use Services\UserService;
	load(['UserService'], APPROOT.DS.'services');

	class User_model extends Base_model
	{
		public $table = 'users';
		public $table_name = 'users';

		const BYPASS_EMAIL = [
			'edromero1472@yahoo.com',
			'gonzalesmarkangeloph@gmail.com'
		];

		const BYPASS_DOMAIN_NAME = [
			'breakthrough-e.com'
		];
		/**
		 * REGISTER USING PERSONAL INFORMATION
		 */
		public function register($user_data = [])
		{
			$errors = [];
			/**
			 * MUST CHECK IF THE USER ALREADY EXISTS
			 * BY CHECKING FIRSTNAME AND LASTNAME , 
			 * (EMAIL , PHONE) should be seperated
			 */
			$user_username_check = $this->get_by_username( $user_data['username'] );
			$user_mobile_check = $this->getByMobile( $user_data['mobile'] );
			$user_email_check = $this->get_list(" WHERE email ='{$user_data['email']}' limit 1");
			$user_name_check = $this->get_list(" WHERE firstname ='{$user_data['firstname']}' AND lastname ='{$user_data['lastname']}' limit 1");

			if($user_username_check) 
				$errors[] = " Username already exists. ";

			if($user_mobile_check)
				$errors[] = " Mobile number is already in use";

			if($user_email_check && !isEqual($user_data['email'], self::BYPASS_EMAIL))
				$errors[] = " Email already used .";

			if($user_name_check && !isEqual($user_data['email'], self::BYPASS_EMAIL))
				$errors[] = " This person you are trying to register has already existing account with us.";

			
			if(!empty($errors)){
				$this->addError( implode(',' , $errors) );
				return false;
			}

			$this->binaryModel = new Binary_model();
			/**
			 * USED TO CHECK IF THE USER NEEDS TO BE DISTRIBUTED BELOW
			 */
			$this->db->query(
				"SELECT username FROM `users` 
					WHERE upline = '{$user_data['upline']}' and L_R = '{$user_data['position']}'"
			);
	
			$check_upline = $this->db->resultSet();
	
			if(!empty($check_upline)){
				$user_data['upline'] = $this->binaryModel->outDownline($user_data['upline'], $user_data['position']);
			}

			extract($user_data);

			$username = trim($username);
			$email = trim($email);
			$mobile = trim($mobile);
			$password = trim($password);

			$props  = [
				'firstname'      => str_escape($firstname) ,
				'lastname'       => str_escape($lastname),
				'username'       => str_escape($username),
				'password'       => password_hash($password, PASSWORD_DEFAULT),
				'direct_sponsor' => str_escape($direct_sponsor),
				'upline'         => $upline,
				'L_R'            => $position,
				'new_upline'     => str_escape($direct_sponsor),
				'address'        => str_escape($address),
				'user_type'      => '2',
				'status'         => 'pre-activated',
				'email'          => str_escape($email),
				'mobile'         => str_escape($mobile),
				'loan_processor_id'         => $loan_processor_id ?? null,
				'mobile_verify'  => 'verified',
				'account_tag'         => 'main_account',
				'page_auto_focus ' => PAGE_AUTO_FOCUS['UPLOAD_ID_PAGE']
			];

			$keys = array_keys($props);
			$values = array_values($props);
			$this->db->query("
					INSERT INTO users(".implode(' , ', $keys).")
						VALUES('".implode("','", $values)."')");
			try{
				$this->db->execute();
				$userId = $this->db->lastInsertId();

				if(!isset($this->userCreditLineModel)) {
					$this->userCreditLineModel = model('UserCreditLineModel');
					$this->userCreditLineModel->addUserCreditLine($userId, 1000);
				}
				
				$body = <<<EOF
					<div> Name : {$firstname} {$lastname}</div>
					<div> Email : {$email}</div>
					<div> Phone Number : {$mobile}</div>
					<div> Address : {$address}</div>
				EOF;
				_mail(['Edromero1472@yahoo.com', 'chromaticsoftwares@gmail.com'], 'NEW REGISTRATION', $body);
				return $userId;
			}catch(Exception $e) {
				die($e->getMessage());
			}
		}

		
		public function saveTextCode($mobileNumber, $OTP_code) 
		{	
			
			$network = sim_network_identification($mobileNumber);
			
			$this->db->query(

			   "INSERT INTO `text_codes`(`number`, `network`, `code`, `category`)
			   	VALUES ('$mobileNumber','$network','$OTP_code','OTP')"
			);

			return $this->db->execute();
		}
		
		public function verify_mobile_number($mobile_number)
		{

			$sql = "UPDATE `users` SET `mobile_verify`='verified' WHERE mobile = '$mobile_number'";
			$this->db->query($sql);
			$this->db->execute();
		}

		public function check_user_activation($userID)
		{

			$this->db->query(
				"SELECT * FROM `users` WHERE id='$userID' and status = 'pre-activated'"
			);

			return $this->db->single();
		}

		public function get_user_by_username($username , $allFields = false, $option)
		{
			if(!$allFields){
				$this->db->query(
					"SELECT id , username , firstname , lastname , email 
						FROM users WHERE {$option} = '$username'"
				);
			}else{
				$this->db->query(
					"SELECT * FROM users where {$option} = '{$username}'"
				);
			}

			return $this->db->resultSet();
		}


		public function get_user_by_key($key)
		{
			$this->db->query(
				"SELECT * from users where (
					username like '%$key%' or lastname like '%$key%'
					or firstname like '%$key%' ) and account_tag = 'main_account' "
			);

			return
				$this->db->resultSet();
		}
		public function user_login(string $username , string $password , $user_type = 1)
		{
			$inArray = is_array($user_type) ? "'".implode("','",$user_type)."'": "'".$user_type."'";
			$this->db->query("SELECT * FROM users
				where username = '{$username}' and user_type in({$inArray})");

			return $this->db->single();
		}

		public function updateProfile($userid , $image)
		{
			$sql = "UPDATE users set selfie = '$image' where id = '$userid'";

			$this->db->query($sql);

			if($this->db->execute()){
				Flash::set('User profile updated');

				$res = $this->get_user($userid);

				$user_session = [
					'id' => $res->id ,
					'type' => $res->user_type,
					'selfie' => $res->selfie,
					'firstname' => $res->firstname,
					'lastname'  => $res->lastname,
					'username'  => $res->username,
					'status'    => $res->status,
					'is_activated' => $user->is_activated,
					'branchId'     => $user->branchId,
					'account_tag'  => $user->account_tag,
				    'is_staff' => $res->is_staff
				];

				Session::set('USERSESSION' , $user_session);

				redirect('users/profile');
			}else
			{
				Flash::set('may error', 'danger');
				redirect('users/profile');
			}
		}

		public function updateInfo($userInfo)
		{
			extract($userInfo);

			$errors = array();

			if(strlen($mobile) < 11) {
				array_push($errors , 'Mobile number should be valid');
			}

			if(!empty($errors))
			{
				Flash::set(implode(',', $errors) , 'danger');
				redirect('users/profile');
			}

			else
			{
				$address = filter_var(trim($address), FILTER_SANITIZE_STRING);

				$sql = "UPDATE users set mobile = '$mobile' , address='$address'

				where id = '$userid'";

				$this->db->query($sql);

				if($this->db->execute())
				{
					Flash::set('User information updated');
					redirect('users/profile');
				}else
				{
					Flash::set('Info not  changed', 'danger');
					redirect('users/profile');
				}
			}
		}


		public function update_password($userid , $password)
		{
			if(strlen($password) < 4) {
				$this->addError("Password must be atleast 4 characters long");
				return false;
			}else{
				$password = password_hash($password, PASSWORD_DEFAULT);
				return parent::dbupdate([
					'password' => $password
				], $userid);
			}
		}

		public function update_personal($userinformations)
		{
			extract($userinformations);

			$errors = array();

			if(strlen($firstname) < 2)
			{
				$errors [] =  "First name must be atleast 2 characters long";
			}

			if(strlen($lastname) < 2)
			{
				$errors [] =  "Last name must be atleast 2 characters long";
			}

			if(!empty($errors))
			{
				Flash::set(implode(',', $errors) , 'info');

				redirect('users/edit');

				return false;
			}else{

				$this->db->query(
					"UPDATE users set firstname = '$firstname' , lastname = '$lastname' where id = '$userid'"
				);

				try{
					$this->db->execute();

					Flash::set("Personal info has been updated");

				}catch(Exception $e) {
					Flash::set($e->getMessage() , 'danger');
				}

				redirect('users/profile');
			}

		}
		public function get_by_username($username)
		{
			$this->db->query("SELECT * FROM users where username = '$username'");

			return $this->db->single();
		}


			public function updateUpline($userids)
		{
			extract($userids);

			$this->db->query(
				"UPDATE `users` SET `upline`='$ups_sponsorID' WHERE `id`='$userID'"
			);

			if($this->db->execute()){
				Flash::set("User updated");
				redirect("account/searchUser");
			}else{
				Flash::set("User not created");
			}
		}

		public function updateDirectSponsor($userids)
		{
			extract($userids);

			$this->db->query(
				"UPDATE `users` SET `direct_sponsor`='$ups_sponsorID'
				WHERE `id`='$userID'"
			);

			if($this->db->execute()){
				Flash::set("User updated");
				redirect("account/searchUser");
			}else{
				Flash::set("User not created");
			}
		}

		public function get_user_by_id(int $user_id)
		{
			return $this->DBselectById($this->db , 'users' , $user_id);
		}

		public function get_user($user_id)
		{
			$this->db->query("SELECT * , date(created_at) as dateonly ,
				concat (firstname , ' ' , lastname) as fullname ,
				ifnull(mobile , 'not set') as mobile,
				ifnull(address, 'not set') as address

				from users where id = '$user_id'");

			return $this->db->single();
		}

		public function get_user_upline($userid)
		{
			$this->db->query(
				"SELECT * FROM users where upline = '$userid' 
					order by id desc limit 2"
			);

			return $this->db->resultSet();
		}

		public function getPublic($userId)
		{
			$this->db->query(
				"SELECT id , firstname , lastname , address , mobile, email , username,
					concat(firstname , ' ' , lastname) as fullname
					
					FROM users 
					WHERE id = '$userId' "
			);

			return $this->db->single();
		}


		public function get_activated_users_total_today($number_of_days)
		{

			extract($number_of_days);
			if($number_of_days<=0){

				$number_of_days=1;
			}

			if($number_of_days==1){

				$this->db->query(
					"select count(*) as total from users where date(created_at) = date(now()) and status != 'pre-activated' and is_activated = true"
				);
			}else{

				$to_date=date("Y-m-d");
				$number_of_days-=1;

				$date = new DateTime($to_date);
				$date->sub(new DateInterval('P'.$number_of_days.'D'));

				$from_date=$date->format('Y-m-d');

				$this->db->query(
					"select count(*) as total from users where (date(created_at) <= '$to_date' and date(created_at) >= '$from_date') and status != 'pre-activated' and is_activated = true"
				);

			}

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;

		}


		public function get_activated_users_today($number_of_days)
		{


			extract($number_of_days);

			if($number_of_days<=0){

				$number_of_days=1;
			}


			if($number_of_days==1){


				$this->db->query(
					"select * , concat(firstname , ' ' , lastname) as fullname from users where date(created_at) = date(now()) and status != 'pre-activated' and is_activated = true
					order by firstname asc "
				);

			}else{

				$to_date=date("Y-m-d");
				$number_of_days-=1;

				$date = new DateTime($to_date);
				$date->sub(new DateInterval('P'.$number_of_days.'D'));

				$from_date=$date->format('Y-m-d');

				$this->db->query(
					"select * , concat(firstname , ' ' , lastname) as fullname from users where (date(created_at) <= '$to_date' and date(created_at) >= '$from_date') and status != 'pre-activated' and is_activated = true order by created_at DESC"
				);

			}

			return $this->db->resultSet();
		}

		public function get_all($limit = null)
		{

			if($limit == null)
			{
				$limit = 100;
			}

			$this->db->query("SELECT id , username , firstname , lastname  FROM users order by id desc limit $limit");

			return $this->db->resultSet();
		}	

		public function getSingle($params = []) {
			return $this->getAll($params)[0] ?? false;
		}
		public function getAll($params = []) {
			$where = null;
			$order = null;
			$limit = null;

			if(!empty($params['where'])) {
				$where = " WHERE ".parent::convertWhere($params['where']);
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}

			if(!empty($params['limit'])) {
				$limit = " LIMIT {$params['limit']}";
			}
			
			$this->db->query(
				"SELECT user.*, 
					concat(user.firstname, ' ', user.lastname) as fullname,
					concat(direct_sponsor.firstname, ' ', direct_sponsor.lastname) as sponsor_fullname,
					concat(upline.firstname, ' ', upline.lastname) as upline_fullname,
					sp_video.video_file as sp_video_file,
					sp_video.id as sp_id

					FROM users as user 
					LEFT JOIN users as direct_sponsor
						ON user.direct_sponsor = direct_sponsor.id

					LEFT JOIN users as upline
						ON user.upline = upline.id
						
					LEFT JOIN sponsor_videos as sp_video
						ON sp_video.beneficiary_id = user.id
						AND sp_video.sponsor_id = user.direct_sponsor
					{$where} {$order} {$limit}"
			);

			return $this->db->resultSet();
		}

		public function get_list($params = null)
		{

			if($params == null)
			{
				$this->db->query("SELECT * , concat(firstname , ' ' , lastname) as fullname
					 			FROM users order by id asc");
			}else
			{
				$this->db->query("SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users $params");
			}

			return $this->db->resultSet();
		}

		public function get_activated_users( $limit = null)
		{

			if(is_null($limit)) {
				return $this->get_list(
					" WHERE status !='pre-activated' order by firstname asc"
				);
			}else{

				return $this->get_list(
					" WHERE status !='pre-activated' order by firstname asc limit {$limit}"
				);
			}

		}

		public function user_get_upline($user_id)
		{
			$user = $this->get_user_by_id($user_id);
			
			if(!$user){
				return false;
			}

			$this->db->query("SELECT *, '{$user->L_R}' as user_position, '{$user->id}' as downline_id from users where id = :userid");
			$this->db->bind(':userid' , $user->upline);

			return $this->db->single();
		}

		public function user_get_sponsor($user_id)
		{
			$sponsor = $this->get_user_by_id($user_id);
			$this->db->query("SELECT * from users where id = :userid");
			$this->db->bind(':userid',$sponsor->direct_sponsor);

			return $this->db->single();
		}

		public function getDirectReferralTotal($userid)
		{
			$sql = "SELECT count(id) as total_user FROM users where direct_sponsor = '$userid'
			and status != 'pre-activated'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total_user;
			return 0;
		}

		public function get_direct_sponsor_total($userid)
		{
			$sql = "SELECT count(id) as total_user FROM users where direct_sponsor = '$userid'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total_user;
			return 0;
		}

		public function getDirects($userId) {
			return parent::dbget_assoc('updated_at', parent::convertWhere([
				'direct_sponsor' => $userId
			]));
		}

		public function getDirectsVerifiedAccounts($userId) {
			return parent::dbget_assoc('updated_at', parent::convertWhere([
				'direct_sponsor' => $userId,
				'is_user_verified' => true
			]));
		}

		/**
		 * to be deleted
		 */
		public function changepassword($userid , $password ,$redirect = null, $callBack = null)
		{

			$password = password_hash($password, PASSWORD_DEFAULT);
			$sql ="UPDATE users set password = '$password' where id = '$userid'";

			$this->db->query($sql);

			if($this->db->execute())
			{
				Flash::set('Password changed');
			}else
			{
				Flash::set('something went wrong' , 'danger');
			}

			if(is_null($redirect)){
				redirect('users/changepassword');
			}else{
				redirect($redirect);
			}
		}

		public function changeusername($userid, $username) {
			if(strlen($username) < 4) {
				$this->addError("Username must atleast be 4 characters long.");
				return false;
			}
			$getExistingUsername = parent::dbget([
				'username' => $username,
				'id' => [
					'condition' => 'not equal',
					'value' => $userid
				]
			]);
			
			if($getExistingUsername) {
				$this->addError("Username already taken");
				return false;
			}

			return parent::dbupdate([
				'username' => $username,
			], $userid);
		}


		public function login_logger($userid)
		{

			$sql = "INSERT INTO `user_login_logger`(`userid`) VALUES ('$userid')";
			$this->db->query($sql);
			$this->db->execute();

		}

		public function logout_logger($userid)
		{

			$sql = "INSERT INTO `user_logout_logger`(`userid`) VALUES ('$userid')";
			$this->db->query($sql);
			$this->db->execute();

		}


		/****** UPDATE SESSION */
		public function sessionUpdate($id)
		{
			$user = $this->get_user($id);
			$verifiedReferrals = $this->getDirectsVerifiedAccounts($id);
			$isTotalVerifiedReferralsPassed = count($verifiedReferrals) >= 2;

			$user_session = [
				'id' => $user->id ,
				'type' => $user->user_type,
				'selfie' => $user->selfie,
				'firstname' => $user->firstname,
				'lastname'  => $user->lastname,
				'username'  => $user->username,
				'status'      => $user->status,
				'is_activated'    => $user->is_activated,
				'branchId'    => $user->branchId,
				'account_tag' => $user->account_tag,
				'is_staff' => $user->is_staff,
				'is_user_verified' => $user->is_user_verified,
				'is_total_referral_passed' => $isTotalVerifiedReferralsPassed,
				'page_auto_focus' => $user->page_auto_focus,
			];

			Session::set('USER_INFO' , $user);
			Cookie::set('USERSESSION' , $user_session);
			Session::set('USERSESSION' , $user_session);

			$userAccountModel = new UserAccountModel();
			//get user accounts and put in session
			$user_account_list = [];

			$user_account_list["by_name"] =
				$userAccountModel->search_by_name_and_email($user->firstname,
				$user->lastname, $user->email, $user->id);

			Session::set('MY_ACCOUNTS' , $user_account_list);

			set_logged_in();//set user login

			$this->login_logger($user->id);

			if(Session::check('USERSESSION'))
				return true;
			return false;
		}

		/*get user by username*/

		public function getByUsernames($username)
		{
			$this->db->query(
				"SELECT * , concat(firstname, ' ' , lastname) as fullname
				FROM users where username like '%$username%'"
			);

			return $this->db->resultSet();
		}

		/*
		*accepted associative arrays
		*/
		public function getByKeyPair($keypair , $orderby = null , $limit = null)
		{
			$where = " WHERE ";
			$counter = 0;
			$i = 0;
			foreach($keypair as $key => $row)
			{
				if($i < $counter){
					$where .= " , ";
					$counter++;
				}
				$where .= "$key like '%$row%'";
			}

			if(!is_null($orderby))
				$orderby = " ORDER BY $orderby";
			if(!is_null($limit))
				$limit = " LIMIT $limit";

			$this->db->query(
				"SELECT * , concat(firstname, ' ' , lastname) as fullname
				FROM users $where $orderby $limit"
			);

			return $this->db->resultSet();
		}


		public function getOldUpline($userid)
		{
			$this->db->query(
				"SELECT u.id , username , firstname , lastname 
					FROM old_sponsor_upline as osu 
					LEFT JOIN users as u 
					on osu.upline = u.id

					WHERE osu.userid = '{$userid}'"
			);

			return $this->db->single();
		}

		public function getOldSponsor($userid)
		{
			$this->db->query(
				"SELECT u.id , username , firstname , lastname 
					FROM old_sponsor_upline as osu 
					LEFT JOIN users as u 
					on osu.direct_sponsor = u.id

					WHERE osu.userid = '{$userid}'"
			);

			return $this->db->single();
		}

		public function getByMobile($mobileNumber)
		{
			$data = [
				$this->table,
				'*',
				" mobile = '{$mobileNumber}' "
			];
			
			return $this->dbHelper->single( ...$data);
		}

		public function getDownline($userId)
		{
			$this->db->query(
				"SELECT * FROM users 
					where upline = '$userId' "
			);

			return $this->db->resultSet();
		}

		public function get_qualification_notes($userid)
		{

			$this->db->query(
				"SELECT * FROM user_notes as u_note 
				 INNER JOIN  fn_accounts as accounts
				 WHERE u_note.noted_by = accounts.id 
				 AND userid = '$userid' "
			);

			return $this->db->resultSet();
		}

		public function make_qualification_notes($userid, $note, $noted_by)
		{

			$this->db->query(
				"INSERT INTO `user_notes` (`userid`, `note`, `noted_by`) 
				VALUES ('$userid','$note', '$noted_by');"
			);

			return $this->db->execute();
		}

		public function check_cop($user_id)
		{	
			$this->db->query(
				"SELECT COUNT(*) as cop
				 FROM `user_addresses` 
				 WHERE `userid` = $user_id AND `type` = 'COP'"
			);

			return $this->db->single();	
		}

		public function change_upline($data)
		{
			extract($data);

			$old_upline =  unseal($old_upline_id);
			$new_upline = unseal($new_upline_id);
			$id = unseal($user_id);

			$this->db->query("INSERT INTO `user_old_upline`( `userid`, `old_upline`) 
							  VALUES ($id,$old_upline)");
			$this->db->execute();

			$this->db->query("UPDATE users SET upline=$new_upline WHERE id = $id");
			return $this->db->execute();
		}

		public function updateStatus($status, $userID) {

			$isOkay = parent::dbupdate([
				'status' => $status
			], $userID);

			if($isOkay) {
				//updated
				if(whoIs()['id'] == $userID) {
					//reset session
					$this->sessionUpdate($userID);
				}
			}
		}

		public function setMPIN($userId, $mpin) {
			if(!$this->MPINvalidate($mpin)) {
				return false;
			}
			return parent::dbupdate([
				'mpin' => $mpin
			], $userId);
		}
		
		public function getUserByMPIN($userId, $mpin) {
			$resp =  parent::dbget([
				'id' => $userId,
				'mpin' => $mpin
			]);

			if(!$resp) {
				$this->addError("User not found");
				return false;
			} else {
				return $this->get_user($resp->id);
			}
		}

		private function MPINvalidate($mpin) {
			if(strlen($mpin) != 4) {
				$this->addError("MPIN must be 4 characters long");
				return false;
			}

			return true;
		}
	}
