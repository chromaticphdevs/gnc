<?php 	

	class UserIdVerificationModel extends Base_model
	{
		public $table = 'users_uploaded_id';
		public $table_name = 'users_uploaded_id';

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function get($params = []) {
			return $this->getAll($params)[0] ?? false;
		}
		
		public function getAll($params = []) {
			$where = null;
			$order = null;
			$limit = null;

			if(!empty($params['where'])) {
				$where = ' WHERE ' . parent::convertWhere($params['where']);
			}

			if(!empty($params['limit'])) {
				$limit = " LIMIT {$params['limit']}";
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}

			$this->db->query(
				"SELECT upi.*, 
					user.firstname,
					user.lastname, 
					user.email,
					user.address,
					user.esig
					
					FROM {$this->table} as upi
					LEFT JOIN users as user 
						ON upi.userid = user.id
					{$where} {$order} {$limit}
					"
			);

			return $this->db->resultSet();
		}

		public function get_date_today()
		{
			date_default_timezone_set("Asia/Manila");
			return date("Y-m-d");
		}

		public function count_manager_work()
		{
			$this->set_time_zone();
			$today = $this->get_date_today();

			$processBy = whoIs()['id'];

			$this->db->query(
                "SELECT
				(SELECT COUNT(*) FROM users_uploaded_id 
				 WHERE status = 'verified' AND DATE(date_time)='$today' AND userid_verifier = '$processBy') as approved,
				(SELECT COUNT(*) FROM users_uploaded_id 
				 WHERE status = 'deny' AND DATE(date_time)='$today' AND userid_verifier = '$processBy') as denied
				FROM `users_uploaded_id` LIMIT 1"               
            );

            return $this->db->single();
		}

		public function count_manager_work_week($days)
		{
			$this->set_time_zone();
			$today = $this->get_date_today();

			$processBy = whoIs()['id'];

			$this->db->query(
                "SELECT
				(SELECT COUNT(*) FROM users_uploaded_id
				  WHERE status = 'verified' AND DATEDIFF('$today', DATE(date_time)) <= {$days} AND userid_verifier = '$processBy') as approved,
				(SELECT COUNT(*) FROM users_uploaded_id 
				 WHERE status = 'deny' AND DATEDIFF('$today', DATE(date_time)) <= {$days} AND userid_verifier = '$processBy') as denied
				FROM `users_uploaded_id` LIMIT 1"               
            );

            return $this->db->single();
		}


		public function save_id_image($imageInfo , $userid)
		{
		
			extract($imageInfo);


			$ids = listOfValidIds();

			if($position == 'front')
			{
				$renderedImage = $this->renderPhoto($image);

				if($renderedImage == 'error'){
			
				$data = [
					'status' => 'error',
					'msg'    => 'back'
				];
					

				}else
				{
					$this->db->query(

						"INSERT INTO `users_uploaded_id`(`userid`, `id_card`, `type`) VALUES ( '$userid', '$renderedImage', '$ids[$ID_type]' )"
					);

					if($this->db->execute()){

						$data =  [
							'status' => 'success' ,
							'msg'    => 'front',
							'id_card_front' => $renderedImage,
							'type' => $ID_type
						];	
					}
				}


			}

			if($position == 'back')
			{
				$renderedImage = $this->renderPhoto($image);

				if($renderedImage == 'error'){
			
				$data = [
					'status' => 'error',
					'msg'    => 'back'
				];
					

				}else
				{
					$this->db->query(

						"UPDATE `users_uploaded_id` SET `id_card_back`='$renderedImage' WHERE id_card = '$id_card_front' and status ='unverified' and userid = '$userid'"
					);

					if($this->db->execute()){
						
						$data = [
							'status' => 'success' ,
							'msg'    => 'back'
						];
					}
				}	

			}

			echo json_encode($data);
		}

		public function saveId($userId, $idType, $idFacing, $imageName) {
			$idTypes =listOfValidIds();

			$currentValues = parent::dbget_single(parent::convertWhere([
				'userid' => $userId,
				'type'  => $idTypes[$idType]
			]));
			$facing = $idFacing == 'FRONT' ? 'id_card' : 'id_card_back';

			if($currentValues) {
				return parent::dbupdate([
					"{$facing}" => $imageName
				], $currentValues->id);
			} else {
				//insert
				return parent::store([
					'userid' => $userId,
					'type'   => $idTypes[$idType],
					"{$facing}" => $imageName
				]);
			}
		}
		public function save_id_image_html($front_id, $back_id, $type, $userid)
		{
			$idTypes = listOfValidIds();

			$this->db->query(
				"INSERT INTO `users_uploaded_id`(`userid`, `id_card`, `id_card_back`, `type`) 
				 VALUES ( '$userid', '$front_id','$back_id', '$idTypes[$type]' )"
			);

			return $this->db->execute();
		}
		
		public function save_id_image_test($imageInfo , $userid)
		{
		
			extract($imageInfo);

			

			$ids = listOfValidIds();


		
			
			if($position == 'front')
			{
				$renderedImage = $this->renderPhoto_test($image);

				if($renderedImage == 'error'){
			
				$data = [
					'status' => 'error',
					'msg'    => 'back'
				];
					

				}else
				{
					$this->db->query(

						"INSERT INTO `users_uploaded_id`(`userid`, `id_card`, `type`) VALUES ( '$userid', '$renderedImage', '$ids[$ID_type]' )"
					);

					if($this->db->execute()){

						$data =  [
							'status' => 'success' ,
							'msg'    => 'front',
							'id_card_front' => $renderedImage,
							'type' => $ID_type
						];	
					}
				}


			}

			if($position == 'back')
			{
				$renderedImage = $this->renderPhoto_test($image);
				
				if($renderedImage == 'error'){
			
				$data = [
					'status' => 'error',
					'msg'    => 'back'
				];
					

				}else
				{
					$this->db->query(

						"UPDATE `users_uploaded_id` SET `id_card_back`='$renderedImage' WHERE id_card = '$id_card_front' and status ='unverified' and userid = '$userid'"
					);

					if($this->db->execute()){
						
						$data = [
							'status' => 'success' ,
							'msg'    => 'back'
						];
					}
				}	

			}
			echo json_encode($data);
		}


		public function get_user_uploaded_id($userid)
		{
			$this->db->query(
                "SELECT `userid`, `type`, `status`, `id_card`, `id_card_back`, `id` , `date_time`
				FROM `users_uploaded_id` 
				WHERE userid = '$userid'  
				ORDER BY id desc"               
            );
            return $this->db->resultSet();
		}

		public function get_user_uploaded_by_type($userid, $idType) {
			$idTypes = listOfValidIds();
			return parent::dbget_single(parent::convertWhere([
					'userid' => $userid,
					'type' => $idTypes[$idType]
				]
			));
		}

		public function get_user_uploaded_id_all()
		{		
			$this->set_time_zone();

			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                CONCAT(lastname,', ',firstname,' ',middlename) as fullname,address, 
                id_card, id_card_back, type, date_time
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.status = 'unverified'
				
				ORDER BY user_id.id desc"               
            );

            return $this->db->resultSet();

		}

		public function get_user_uploaded_id_info($id)
		{		
			$this->set_time_zone();
			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                CONCAT(firstname, ' ', lastname ) as fullname,address, user_id.status ,
                id_card, id_card_back, type, date_time
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.userid = '$id' and user_id.status = 'verified'"               
            );
            return $this->db->resultSet();
		}

		public function getUserids($userid)
		{
			$this->db->query(
				"SELECT user_id.id as uploaded_id ,username, 
				CONCAT(firstname, ' ', lastname) as fullname ,address, 
				firstname,lastname, id_card, id_card_back, type, date_time, user_id.status as id_status,
				user.id as user_id

                FROM `users_uploaded_id` as user_id

				LEFT JOIN users as user 
                ON user_id.userid = user.id

				WHERE user_id.userid = '$userid'
				AND user_id.status != 'deny'

				ORDER BY FIELD(user_id.status,'verified','unverified','deny');"               
            );

            $results = $this->db->resultSet();

			return $results;
		}


		public function get_user_uploaded_id_by_branch($branchid)
		{	
			$this->set_time_zone();

			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                CONCAT(lastname,', ',firstname,' ',middlename  ) as fullname,address, 
                id_card, id_card_back, type, date_time
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.status = 'unverified' AND user.branchId = $branchid"               
            );

            return $this->db->resultSet();

		}


		public function get_next_uploaded_id()
		{		
			$this->set_time_zone();

			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                 CONCAT(lastname,', ',firstname,' ',middlename  )  as fullname,address, 
                id_card, id_card_back, type, date_time
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.status = 'unverified' LIMIT 1"               
            );

            return $this->db->single();

		}


		public function get_next_uploaded_id_by_branch($branchid)
		{		
			$this->set_time_zone();

			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                 CONCAT(lastname,', ',firstname,' ',middlename  ) as fullname,address, 
                id_card, id_card_back, type, date_time
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.status = 'unverified' AND user.branchId = $branchid LIMIT 1"               
            );

            return $this->db->single();

		}

		public function verify_id($id)
		{
			$processBy = whoIs()['id'] ?? 1;
			$session_type = get_session_type() ?? '_SECRET';

			$this->db->query(
			   "UPDATE `users_uploaded_id` 
				SET `status` = 'verified', `comment` = '',
					`userid_verifier` = '$processBy', 
					`verifier_type` = '$session_type'
				WHERE `users_uploaded_id`.`id` = '$id';"
			);

			if($this->db->execute())
			{
				$verifiedID = self::dbget($id);
				if(!isset($ths->userModel)) {
					$this->userModel = model('User_model');
				}

				$user = $this->userModel->get_user($verifiedID->userid);

				if(!$user) {
					$this->addError("User no longer exists");
					_unitTest(false, "Unable to fetch user on verify id ". get_class($this));
					return false;
				}
				/**
				 * verify user and 
				 * refresh user data
				 */
				$user = $this->verifyUser($user);
				$isQualifiedForCashAdvance = $this->qualifyUserForCashAdvance($user);

				if($isQualifiedForCashAdvance) {
					$this->autoloan($user);
				}
				/**
				 * process users sponsor also
				 * to check for is qualified for cash advance
				 */
				$directSponsor = $this->userModel->get_user($user->direct_sponsor);
				
				if($directSponsor) {
					//has valid direct sponsor
					$isSponsorQualifiedForCashAdvance = $this->qualifyUserForCashAdvance($directSponsor);
					if($isSponsorQualifiedForCashAdvance) {
						$this->autoloan($directSponsor);
					}
				}
				$this->addError("Account verified");
				return true;
			}else
			{
				$this->addError("Unable to verify account");
				return false;
			}
		}


		private function verifyUser($user) {
			if(!isset($this->userModel)) {
				$this->userModel = model('User_model');
			}
			$totalVerifiedIDs = $this->countUserVerifiedIds($user->id);
			if(!$user->is_user_verified) {
				if ($totalVerifiedIDs >= 2) {
					$this->userModel->db->query(
						"UPDATE users set is_user_verified = true
							WHERE id = '{$user->id}' "
					);
					$this->userModel->db->execute();
					$this->addMessage("User {$user->firstname} ID has been verified");
					//refresh user data
					$user = $this->userModel->get_user($user->id);
					//update focus page
					if(isEqual($user->page_auto_focus, [PAGE_AUTO_FOCUS['UPLOAD_ID_PAGE']])) {
						$this->userModel->dbupdate([
							'page_auto_focus' => PAGE_AUTO_FOCUS['REFERRAL_PAGE']
						], $user->id);
					}
					$this->updateSponsorPageAutoFocus($user->direct_sponsor);
				}
			}
			return $user;
		}

		//set auto_focus to bank_upload
		private function updateSponsorPageAutoFocus($sponsorId) {
			$referralIdApprovedIdCount = 0;

			$userSponsor = $this->userModel->get_user($sponsorId);
			$referrals = $this->userModel->getAll([
				'where' => [
					'user.direct_sponsor' => $sponsorId
				]
			]);
			
			//check how many ids are  verified
			foreach($referrals as $key => $user) {
				$totalVerifiedIDs = $this->countUserVerifiedIds($user->id);
				if($totalVerifiedIDs > 2) {
					$referralIdApprovedIdCount++;	
				}
			}


			if($referralIdApprovedIdCount) {
				//update this sponsor 
				if(isEqual($userSponsor->page_auto_focus, [PAGE_AUTO_FOCUS['UPLOAD_ID_PAGE'], PAGE_AUTO_FOCUS['REFERRAL_PAGE']])) {
					$this->userModel->dbupdate([
						'page_auto_focus' => PAGE_AUTO_FOCUS['BANK_DETAIL_PAGE']
					], $userSponsor->id);
				}
			}
		}
		/**
		 * add add loan
		 */
		private function qualifyUserForCashAdvance($user) {
			if(!isset($this->userModel)) {
				$this->userModel = model('User_model');
			}
			$verifiedAccountTotal = $this->userModel->getDirectsVerifiedAccounts($user->id);
			//check if user is qualified to loan\
			if($user->is_user_verified && $verifiedAccountTotal) {
				_unitTest(true, "User in qualified for cash advance userid = {$user->id}". get_class($this));
				//check if there is currently pending loan application
				if(!isset($this->fnCashAdvanceModel)) {
					$this->fnCashAdvanceModel = model('FNCashAdvanceModel');
				}
				$loans = $this->fnCashAdvanceModel->getUserLoans($user->id);
				if($loans) {
					_unitTest(true, "User in qualified for cash advance but has existing loan userid = {$user->id}");
					$this->addError("User has currently have pending loan");
					return false;
				}
				
				if(!isset($this->cAQualifiedUserModel)) {
					$this->cAQualifiedUserModel = model('CAQualifiedUserModel');
				}

				//add to qualified to loan users
				$this->cAQualifiedUserModel->addQualified($user->id);
				return true;
			}
			_unitTest(true, "User in unqualified for cash advance userid = {$user->id}");
			return false;
		}
		/**
		 * create automatic loan for user
		 * select closest approved referrals
		 */
		private function autoloan($user) {
			if(!isset($this->fnCashAdvanceModel)) {
				$this->fnCashAdvanceModel = model('FNCashAdvanceModel');
			}

			return $this->fnCashAdvanceModel->autoloan($user);
		}

		public function countUserVerifiedIds($userId)
		{
			$this->db->query(
				"SELECT count(id) as total FROM 
					users_uploaded_id
				WHERE status = 'verified'
				AND userid = '{$userId}' "
			);

			return $this->db->single()->total ?? 0;
		}


		public function deny_id($id, $comment)
		{
			if(!isset($this->userNotification)) {
				$this->userNotification = model('UserNotificationModel');
			}
			if(Session::check('BRANCH_MANAGERS'))
			{
			   $user = Session::get('BRANCH_MANAGERS');
			   $user_id = $user->id;

			}else if(Session::check('USERSESSION'))
			{
				$user_id = Session::get('USERSESSION')['id'];
			} else {
				$user_id = 1;
			}

			$uploadID = $this->get([
				'where' => [
					'upi.id' => $id
				]
			]);

			$this->db->query(
                "SELECT `id_card`, `id_card_back` FROM `users_uploaded_id` WHERE id = '$id'"               
            );

            $result = $this->db->single();

            $id_card_front = PUBLIC_ROOT.DS.'assets/user_id_uploads/'.$result->id_card;
            $id_card_back =  PUBLIC_ROOT.DS.'assets/user_id_uploads/'.$result->id_card_back;

			$response = parent::dbdelete($id);
         
            $this->db->query(

			   "UPDATE `users_uploaded_id` 
				SET `status` = 'deny', `comment` = '$comment',
					`userid_verifier` = '$user_id'
				WHERE `users_uploaded_id`.`id` = '$id';"
			);

			if($this->db->execute()){

				$this->userNotification->store([
					'message' => "Your upload {$uploadID->type} ID has been denied",
					'user_id' => $uploadID->userid,
					'parent_key' => 'UPLOAD_ID_MESSAGE'
				]);
				
				if(!empty($result->id_card)){
					unlink($id_card_front);
				}

				if(!empty($result->id_card_back)){
					unlink($id_card_back);
				}
				return true;
        	}else
			{
				return false;
			}

		}

		public function get_id_comment($userid)
		{
			$this->db->query(
                "SELECT comment,type FROM `users_uploaded_id` 
                 WHERE status = 'deny' AND userid='$userid' 
                 AND (SELECT COUNT(*) FROM `users_uploaded_id` WHERE status='unverified' AND userid='$userid') = 0 
                 ORDER BY date_time DESC LIMIT 1;"               
            );

            return $this->db->single();
		}


		public function verified_list($status)
		{
			if($status == 'deny')
			{
				$condition = "'deny'  AND user_id.comment != 'user cancel' Order BY user_id.date_time DESC";
			}
			else
			{
				$condition = "'verified' Order BY user_id.date_time DESC";
			}
			$this->set_time_zone();

			$this->db->query(
                "SELECT user_id.id as uploaded_id ,username, 
                CONCAT(firstname, ' ', lastname ) as fullname,address, 
                id_card, id_card_back, type, date_time,
                (SELECT name FROM fn_accounts WHERE id = user_id.userid_verifier) as verifier_name
                FROM `users_uploaded_id` as user_id INNER JOIN users as user 
                WHERE user_id.userid = user.id and user_id.status = $condition"               
            );

            return $this->db->resultSet();

		}

		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/user_id_uploads/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath . $fileName;
		    file_put_contents($file, $image_base64);

		    $image_info = @getimagesize($file); 

		    if($image_info){

 				return $fileName;
		    }else{

		   		return 'error';
		    }
		   
		} 

		private function renderPhoto_test($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/user_id_uploads/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath.$fileName;
		    file_put_contents($file, $image_base64);

		    $image_info = @getimagesize($file); 

		    if($image_info){

 				return $fileName;
		    }else{

		   		return 'error';
		    }
		    
		}   
	
		public function users_total_valid_id($userid)
		{
			$this->db->query(
                "SELECT COUNT(*) as total_valid_id 
                 FROM `users_uploaded_id` 
                 WHERE `userid` = '$userid' 
                 AND `status` = 'verified'"               
            );

            return $this->db->single();
		}
	}