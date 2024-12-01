<?php
	require_once(FNCTNS.DS.'crawler.php');
	require_once(APPROOT.DS.'classes/UserBinaryPV.php');

	class Binary_model extends Base_model
	{
		/**
		*@param
		* Will generate downlines with a treshold of 7
		*/
		public function getDownlines($user_id , $treshold = 200)
		{
			$cur_upline = array($user_id);

			$upline_list = array();

			$stop = false;
			$loop_counter = 1;
			do{

				$downlines = $this->getBulkDownlines($cur_upline);

				if($downlines)
				{
					array_push($upline_list, $downlines);

					$cur_upline = $this->extract($downlines , 'id');
				}else{
					$stop = true;
					break;
				}

				$loop_counter++;

				if($loop_counter >= $treshold)
				{
					$stop = true;
				}
			}while($stop == false);

			return $upline_list;
		}

		public function createTree($uplines)
		{
			$users = array();

			foreach($uplines as $index=>$user)
			{
				array_push($users, $user);
			}
			return $users;
		}
		/**
		*@param
		*list of std_class array , field to be extracted
		*/
		private function extract(?array $std_arr , $field)
		{
			$extracted = array();

			if(count($std_arr))
			{
				foreach($std_arr as $std)
				{
					array_push($extracted, $std->id);
				}
			}

			return $extracted;
		}
		public function getMainDownlines($user_id)
		{
			$this->db->query("SELECT * FROM users where upline = :user_id order by created_at asc");
			$this->db->bind('user_id' , $user_id);

			$res = $this->db->resultSet();

			if($res)
				return $res;
			return 0;
		}

		public function getBinary($root)
		{
			$downlines  = array();
			if(!empty($root))
			{
				$downlines = $this->getMainDownlines($root);
			}

			$left  = 0;
			$right = 0;

			if(is_array($downlines) && !empty($downlines))
			{
				foreach($downlines as $downline)
				{
					$binary = new UserBinaryModel($downline->id);
					$binaryRecent = $binary->get_recent_transaction();

					if(strtolower($downline->L_R) == 'left')
					{
						$left = $this->userStd
						([	'id'        => $downline->id ,
							'username'  => $downline->username ,
							'first_name'=> $downline->firstname,
							'last_name' => $downline->lastname,
							'position'  => $downline->L_R ,
							'status'    => $downline->status ,
							'left'      => $binaryRecent->left_vol ?? 0,
							'right'     => $binaryRecent->right_vol ?? 0]);
						break;
					}
				}
				foreach($downlines as $downline)
				{
					$binary = new UserBinaryPv($downline->id);

					if(strtolower($downline->L_R) == 'right')
					{
						$right = $this->userStd
						([  'id'       => $downline->id ,
							'username' => $downline->username,
							'first_name'=> $downline->firstname,
							'last_name' => $downline->lastname,
							'position' => $downline->L_R ,
							'status'   => $downline->status,
							'left'     => $binary->left_volume(),
							'right'    => $binary->right_volume()]);
						break;
					}
				}
			}
			if(!is_object($left))
			{
				$left  = $this->userStd(['id' => '' , 'username' => 'N/A' , 'position'=>'N/A' , 'status'=>'na', 'left' => 0 , 'right'=>0]);
			}

			if(!is_object($right))
			{
				$right = $this->userStd(['id' => '' , 'username' => 'N/A', 'position'=>'N/A' , 'status'=>'na', 'left' => 0 , 'right'=>0]);
			}
			return array(
				'left' => $left ,
				'right' => $right
			);
		}

		private function userStd(array $fields)
		{
			$std = new stdClass();

			foreach($fields as $field=>$value)
			{
				$std->$field = $value;
			}

			return $std;
		}
		public function getBulkDownlines(?array $uplines)
		{

			$upline_ids = implode("','" , $uplines);

			$sql = "SELECT * FROM users where upline in ('{$upline_ids}')";
			$this->db->query("SELECT * FROM users where upline in ('{$upline_ids}')");

			$res = $this->db->resultSet();

			if($res)
				return $res;
			return 0;
		}

		public function outDownline($root , $position)
		{

			$root_downline = $this->getDownline($root , $position);
			$return_data = null;

			if(empty($root_downline))
			{
				$return_data = $root;

			}else{

				$cur_root = $root_downline->id;
				$stop = false;

				do{
					$downline = $this->getDownline($cur_root , $position);

					if(empty($downline))
					{
						$return_data = $cur_root;
						$stop = true;
					}else{
						$cur_root = $downline->id;
					}

				}while($stop == false);
			}
			return $return_data;
		}

		public function getDownline($root  , $position)
		{
			$this->db->query(
				"SELECT * from users where upline = '$root'
				and L_R = '$position'"
			);

			return $this->db->single();
		}


		public function getReverse($userid)
		{
			$position;

			$loopCounter = 0;

			$returnData = [];

			do{
				if($loopCounter == 0) 
				{
					$this->db->query(
						"SELECT * FROM users WHERE 
							id = '$userid'"
					);
				}else{
					$this->db->query(
						"SELECT * FROM users where 
							id = '$userid' AND L_R = '{$position}'"
					);
				}

				$user = $this->db->single();

				if($user) 
				{
					$position = $user->L_R;
					$userid = $user->upline;
					array_push($returnData, $user);
				}else{
					break;
				}
			}while($user && $loopCounter < 1000);


			return $returnData;
		}
	}
