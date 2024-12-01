<?php
	function crawler_upline($child)
	{
		$con = Database::getInstance();
		$upline_list = [];
		$instance = 0;
		$cur_child = $child;
		$stop = FALSE;

		do
		{
			$sql = "SELECT id , username , firstname , lastname , upline , 
			max_pair , L_R as position , L_R , status as rank
			from users where id = '{$cur_child}'";

			$con->query($sql);

			$result = $con->single();

			if($result) {

				if($instance == 0) {

					$cur_child = $result->upline;

					$prev    = $result;

					$instance++;

				}else{
					$cur_child = $result->upline;

					$result->downlinePosition = $prev->position;

					$prev = $result;

					array_push($upline_list, $result);
				}
			}else{
				$stop = TRUE;
			}
		}while($stop != TRUE);

		return $upline_list;
	}

	function crawler_drc($userid , $deep = 5)
	{

		$con = Database::getInstance();

		$hasSponsor = false;

		$tree = [];

		/*get the purchasers direct sponsor*/
		$con->query("SELECT id , direct_sponsor , username , max_pair
				FROM users WHERE id = '$userid'");
		/*get the users direct sponsor*/
		$userDetail = $con->single();

		$sponsor_id = $userDetail->direct_sponsor;

		do{
			$con->query(
				"SELECT id , direct_sponsor , username , max_pair FROM users
					WHERE id = '$sponsor_id'"
			);
			$user = $con->single();

			if(empty($user) || !$user) {
				$hasSponsor = false;
			}else{
				$hasSponsor = true;
				$sponsor_id  = $user->direct_sponsor;
				array_push($tree , $user);
			}

		}while($hasSponsor);


		return $tree;
	}