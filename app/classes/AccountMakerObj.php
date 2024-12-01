<?php 	

	class AccountMakerObj
	{
		private $runnable = true;

		//store all created users id
		private $createdUsersId;


		public function __construct($userid , $purchasedLevel)
		{
			$this->validLevels = ['starter' , 'bronze' , 'silver', 'gold'];

			$this->init($userid , $purchasedLevel);
		}

		public function arrangeUplines($users , $parent)
		{
			$userLength = count($users);

			$startFrom  = 0;

			$updateUsers = [];

			foreach($users as $key => $row) 
			{

				if($startFrom >= (count($users) - 1)) break;

				/*
				*On array of users pair two consecutive users
				*lesser user id will be pushed to left and the higer to the right.
				*/
				$pairUser = $this->pairUser($users[$startFrom] , $users[++$startFrom]);

				$startFrom++;

				$leftPosition  = $pairUser['left'];
				$rightPosition = $pairUser['right'];

				/*
				*Check if parent is array
				* PARENT IS PASSED AS AN INTEGER / STRING ID
				*The parent will be updated to an array after placing
				*first binaries on parent user
				*/
				if(is_array($parent))
				{
					$updateUsers[] = $this->createUpdateArray($leftPosition->id , array_values($parent)[0] , 'left');
					$updateUsers[] = $this->createUpdateArray($rightPosition->id , array_values($parent)[0] , 'right');

					unset($parent[0]);

					array_push($parent, $leftPosition->id);
					array_push($parent, $rightPosition->id);

					$parent = array_merge($parent);

				}else{

					/*
					*IF PARENT IS INTEGER/STRING
					*First 2 users will become the parent binaries
					*/

					/*
					*Move users to the updateUsers this will be queried after arranging all users
					*/
					$updateUsers [] = $this->createUpdateArray($leftPosition->id , $parent , 'left');
					$updateUsers [] = $this->createUpdateArray($rightPosition->id , $parent , 'right');

					/*
					*Convert integer/string parent to array.
					*parents values are the users that had been placed to updatedUsers
					*/
					$parent = [
						$leftPosition->id,
						$rightPosition->id
					];
				}
			}
			/*TEMPORARY CODE STYLE
			*ATTACH PREVIOUS PARENT BINARIES
			*TO NEW CREATED USERS
			**/
			$firstPosition = $this->getBinaryAtttachmentLeft($userLength);
			$lastPosition  = ($firstPosition * 2) + 1;

			/*GET CURRRENT PARAENT DOWNLINES
			*DOWNLINES THAT WILL BE MOVED TO LAST CHILDREN OF NEW BINARIES
			*/
			$parentDownlines = $this->getParentDownlines();


			if( $parentDownlines['left'] ) 
				$updateUsers [] = $this->createUpdateArray($parentDownlines['left']->id , 
					$users[$firstPosition]->id , 'left');

			if( $parentDownlines['right'])
				$updateUsers [] = $this->createUpdateArray($parentDownlines['right']->id , 
					$users[$lastPosition]->id , 'right');

			return $updateUsers;
		}

		private function createUpdateArray($userid , $upline , $position)
		{
			return compact([
				'userid','upline','position'
			]);
		}

		private function getBinaryAtttachmentLeft($userLength)
		{
			$leftBinary = 2;

			switch($userLength)
			{
				case 6:
					$leftBinary = 2;
				break;

				case 14;
					$leftBinary = 6;
				break;

				case 30;
					$leftBinary = 14;
				break;
			}

			return $leftBinary;
		}

		/**
		*Arranged users are users that will be updated
		*/
		private function runUpdateUsers($arrangedUsers)
		{
			$sql = "";
			
			if(empty($arrangedUsers))
				return false;

			foreach($arrangedUsers as $key => $row) 
			{
				$sql .= " UPDATE users set 
					upline = '{$row['upline']}',
					L_R = '{$row['position']}'
					WHERE id = '{$row['userid']}';";
			}

			$this->db->query($sql);

			return $this->db->execute();
		}

		private function pairUser($userA , $userB)
		{	
			$left = $userA;
			$right = $userB;

			if($userA->id > $userB->id) {
				$left = $userB;
				$right = $userA;
			}

			return compact([
				'left' , 'right'
			]);
		}


		private function getBinary($userid)
		{
			$this->db->query("SELECT id , username 
				FROM users
				WHERE upline = '{$userid}'");

			return $this->db->resultSet();

		}


		private function createSubAccounts($userid , $numberOfAccounts = 6)
		{
			$accountOrigin = $this->userModel->getChooseField([
				'firstname' , 'lastname', 'username',
				'email' , 'account_tag','password',
				'branchId' , 'user_type','email',
				'religion_id' , 'address' , 'mobile',
				'mobile_verify','middlename'
			] , $userid);

			$createdUsersId = [];
			/*accountTag
			*username
			*
			*/
			$firstname = substr($accountOrigin->firstname, 0 , 3);

			for($i = 1 ; $i <= $numberOfAccounts ; $i++) 
			{

				$username = $firstname.random_number(6);

				$this->db->query(
					"
						INSERT INTO users(
						firstname , lastname , username,
						password,branchId , 

						user_type , email,religion_id , 

						address , mobile,mobile_verify , 

						middlename,account_tag,status
						)VALUES(
							'$accountOrigin->firstname','$accountOrigin->lastname','$username',
							
							'$accountOrigin->password','$accountOrigin->branchId',

							'$accountOrigin->user_type','$accountOrigin->email','$accountOrigin->religion_id',
							
							'$accountOrigin->address','$accountOrigin->mobile','$accountOrigin->mobile_verify',
							
							'$accountOrigin->middlename','sub_account' , 'pre-activated'
						)
					"
				);

				$createdUsersId[] = $this->db->insert();
			}

			$this->createdUsersId = $createdUsersId;

			return $this->createdUsersId;
		}

		/*
		*Convert purchased level to number of accounts
		*/
		public function equivalentNumberOfAccounts()
		{
			$numberOfAccounts = 6;

			switch ($this->purchasedLevel) {
				case 'bronze':
					$numberOfAccounts = 6;
					break;

				case 'silver':
					$numberOfAccounts = 14;
					break;

				case 'gold':
					$numberOfAccounts = 30;
					break;
			}

			return $numberOfAccounts;
		}
		
		/*
		*Run tests on constructors
		*/
		public function init($userid , $purchasedLevel)
		{
			$purchasedLevel = strtolower($purchasedLevel);

			if( !in_array($purchasedLevel , $this->validLevels) ){
				$this->runnable = false;
				return;
			}

			$this->db = Database::getInstance();

			$this->userModel = model('LDUserModel');
			$this->userid = $userid;
			$this->purchasedLevel = $purchasedLevel;
		}

		/*
		*Run all Commands
		*/
		public function run()
		{

			return true;
			
			// if(!$this->runnable)
			// 	return false;


			// $parentId = $this->userid;

			// $numberOfAccounts = $this->equivalentNumberOfAccounts();
			// /*Create Sub accounts*/
			// $createdUsersId = $this->createSubAccounts($parentId ,  $numberOfAccounts);


			// $createdUsersIdCount = count($createdUsersId);


			// //if account created failed.
			// if($createdUsersIdCount != $numberOfAccounts) {
				
			// 	$this->addError(" Account Creation Failed ! Required Users To Create ${$numberOfAccounts}
			// 		Created Users ${$createdUsersIdCount}");
				
			// 	$this->rollbackCreatedUsers($createdUsersId);

			// 	return false;
			// }

			// $createdUsersIdString = implode("','" , $createdUsersId);

			// $users = $this->userModel->getResultsField([
			// 	'id' , 'username' , 'L_R' , 'upline' , 'direct_sponsor',
			// 	'status'
			// ], " id in('$createdUsersIdString') ");

			// /*
			// *Arrange users for update uplines
			// */
			// $arrangedUplines = $this->arrangeUplines($users , $parentId);


			// $this->runUpdateUsers($arrangedUplines);
		}


		private function getParentDownlines()
		{
			$results = $this->userModel->getResultsField([
				'id' , 'username' , 'L_R' , 'upline' , 'direct_sponsor',
				'status'
			] , " upline = '{$this->userid}'");

			$returnData = [
				'left'  => false,
				'right' => false
			];

			foreach($results as $key => $row)
			{
				if(isEqual($row->L_R , 'left')){
					$returnData['left']  = $row;
				}else{
					$returnData['right'] = $row;
				}
			}

			return $returnData;
		}


		public function getErrors()
		{
			return $this->errors;
		}

		private function addError($error)
		{
			if(!isset($this->errors)) {
				$this->errors = [];
			}

			$this->errors[] = $error;
		}

		/*DELETED CREATED USERS*/
		private function rollbackCreatedUsers($createdUsersId)
		{
			$this->userModel->deleteUsers($createdUsersId);
		}
	}