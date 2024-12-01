<?php

	class UplineSwitchModel extends Base_model
	{	


		public function get_upline($userid)
		{
			$user = $this->get_user($userid);

			$this->db->query(
				"SELECT * FROM users where id = '$user->upline'"
			);

			return $this->db->single();
		}

		public function get_user($userid)
		{
			$this->db->query("SELECT * , L_R as position from users where id = '$userid'");

			return $this->db->single();
		}

		/*check if upline is activated*/
		public function upline_activated($upline)
		{
			if($upline) {
				if($upline->max_pair <= 0 )
					return false;
				return true;
			}

			return false;
		}



		public function make_switch($uplineid , $userid)
		{
			/*
			*This will be the user new upline
			*/
			$newUpline = false;

			/*
			*Upline of uplines that
			*previously fetched
			*/
			$previouslyParsedUpline = false; 

			do{
				$this->db->query(
					"SELECT id , username , upline , max_pair , L_R as position
						FROM users where id = '{$uplineid}'"
				);

				$result = $this->db->single();
				/*
				*If Result has maxpair or is activated
				*Set New Upline
				*/
				if($result->max_pair > 0) 
				{
					$newUpline = $result;
				}else
				{
					/*
					*if upline is still not available then
					*Move result to previouslyParsedUpline
					*and reset uplinied to result upline field.
					*/
					$previouslyParsedUpline = $result;
					$uplineid = $result->upline;
				}

				/*IF UPLINE SWITCH NOT POSSIBLE
				*THIS IS DUE TO DATABASE ROWS MODIFICATION
				*THEN BREAK THE LOOP.(NO SWITCH AVAILABLE)
				*/
				if($uplineid < 0) break;

			}while(!$newUpline);


			if(!$newUpline || !$previouslyParsedUpline) {
				die("OOPS SOMETHING WENT WRONG PLEASE REPORT TO THE ADMINISTRATOR");
			}

			/*MOVE USER TO HIS NEW UPLINE*/
			$moveUserToNewUpline = $this->updateUpline($userid , $newUpline->id);

			$moveUplineToUser = $this->updateUpline($previouslyParsedUpline->id , $userid);

			if(!$moveUserToNewUpline || !$moveUplineToUser) 
				die("OOPS SOMETHING WENT WRONG PLEASE REPORT TO THE ADMINISTRATOR");
			
			return TRUE;
		}

		private function updateUpline($userid , $newUplineId)
		{
			$this->db->query(
				"UPDATE users set upline = '$newUplineId'
					WHERE id = '$userid'"
			);
			writeLog('user-switch' , " user {$userid} to his new upline {$newUplineId} ");

			return $this->db->execute();
		}

		/*
		*OLD MAKE SWITCH
		*REFACTORERD
		*/

		// public function make_switch_oldie($uplineid , $userid)
		// {
		// 	$loopCount = 0;

		// 	$newUpline = 0;

		// 	$child = $uplineid;
			
		// 	while(is_numeric($newUpline) && $newUpline == 0 && $loopCount <= 100)
		// 	{
		// 		$this->db->query(
		// 			"SELECT * FROM users
		// 				WHERE id = '$child'"
		// 		);

		// 		$result = $this->db->single();

		// 		if($result) 
		// 		{
		// 			if($result->max_pair > 0) 
		// 			{
		// 				/** CHECK IF USER HAS AVAILABLE POSITION */

		// 				$this->db->query( " SELECT count(id) as total from users 
		// 					WHERE upline  = {$result->id} and max_pair > 0");

		// 				$downlines = $this->db->single()->total ?? 0;

		// 				if($downlines >= 2) {
		// 					continue;
		// 				}else{
		// 					$newUpline = $result;
		// 				}
						
		// 			}

		// 			$child = $result->upline;
		// 		}

		// 		$loopCount++;
		// 	}

		// 	$user = $this->get_user($userid);

		// 	/** NEW UPLINE AVAILABLE LEG*/
		// 	$uplineLegAvailable = $this->get_available_leg($newUpline->id , $user->position); 
			
		// 	/** SUBJECT CURRENT DOWNLINE*/
		// 	$prev_downlineid = $this->get_downline($userid , $user->position);

		// 	/** IF SUBJECT HAS DOWNLINES */
		// 	if($prev_downlineid > 0) {
		// 		/** IF TRUE THEN FIRST DOWNLINE SHALL BE THE NEW DOWNLINE OF SUBJECTS UPLINE */
		// 		/** UPDATE ALSO THE POSITION SINCE THERE WILL BE AN INSTANCE THE THE SUBJECT WILL CHANGE POSITION AS WELL */
		// 		$this->update_upline($uplineid , $prev_downlineid);
		// 	}

		// 	/** NEW UPLINE CURRENT DOWNLINE */
		// 	$downlineid = $this->get_downline($newUpline->id , $uplineLegAvailable);

		// 	/** UPDATE SUBJECTS UPLINE
		// 	 * 3rd param is the available leg position of the new upline
		// 	 */
		// 	$this->update_upline($newUpline->id , $user->id , $uplineLegAvailable);

		// 	/** NEW UPLINE PREVIOUS DOWNLINE WILL CONNECT TO OUR SUBJECT AS DOWNLINE */
		// 	if($downlineid > 0) {
		// 		$this->update_upline($user->id  , $downlineid , $user->L_R);
		// 	}
			
		// }

		private function update_upline($newupline , $userid , $position = null)
		{
			if(is_null($position))
			{
				$this->db->query(
					"UPDATE users set upline = '$newupline'
						WHERE id = '$userid'"
				);
			}else{
				$this->db->query(
					"UPDATE users set upline = '$newupline' , L_R = '$position'
						WHERE id = '$userid'"
				);
			}
			

			return
				$this->db->execute();
		}

		private function get_downline($userid , $position)
		{
			$this->db->query(
				"SELECT * FROM users where
					upline = '$userid' and L_R = '$position'"
			);


			$result = $this->db->single();

			if($result) {
				return $result->id;
			}

			return 0;
		}

		private function get_available_leg($userid , $position)
		{
			$positions = ['LEFT' , 'RIGHT'];

			$this->db->query(
				"SELECT id FROM users where upline = '$userid' and L_R ='{$position}' 
				and max_pair > 0"
			);

			$result = $this->db->single();
			/** IF HAS RESULT MEANS THAT POSITION IS ALREADY OCCUPIED */
			if($result){
				/** IF POSITION AND RETURN THE OPPOSITE*/
				return $position == 'LEFT' ? 'RIGHT' : 'LEFT';
			}
			/** IF SUBJECTS POSITION ON HIS NEW UPLINE LEG THEN RETURN CURRENT POSITION */
			return $position;
		}
	}
