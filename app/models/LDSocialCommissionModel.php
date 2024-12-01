<?php 	

	class LDSocialCommissionModel extends Base_model 
	{

		public function post_commissions($purchaserid , $product)
		{
			//uplines
			$uplines  = $this->get_uplines($purchaserid);
			//sponsors
			$sponsors = $this->get_sponsors($purchaserid , 5);

			$direct_sponsor = 

				$this->add_direct_sponsors_commissions($purchaserid , $sponsors , $product);

				if($direct_sponsor) {

					$uplines = $this->add_binary_commissions($purchaserid , $uplines , $product);
				}
		}

		public function get_sponsors($userid , $deep = 5)
		{
			/**/
			$socialuserid = $this->get_user_information_by_dbbid($userid);

			$user   = $this->get_user_information($socialuserid);


			if(empty($user)) {

				return [];
			}
			// $childid;
			$digged = 0;

			$sponsorList = [];

			while($digged <= $deep) 
			{
				$userSponsor = $this->get_user_information($user->direct_sponsor);
				/*if has sponsor*/
				if(!empty($userSponsor))
				{
					$sponsorObj = new LDSponsorObj();

					$sponsorObj->set_prop('id' , $userSponsor->id);
					$sponsorObj->set_prop('username' , $userSponsor->username);
					$sponsorObj->set_prop('sponsor' , $userSponsor->direct_sponsor);
					$sponsorObj->set_prop('sponsored' , $user->id);

					/*get */
					array_push($sponsorList, $sponsorObj);

					if($userSponsor->direct_sponsor == 0)
					{
						//stoping the loop
						$digged = $deep;
					}
					/*set the user as the new fetched sponsor*/
					$user = $userSponsor;
				}else{
					//stoping the loop
					$digged = $deep;
				}
				$digged++;
			}

			// die(var_dump($sponsorList));
			return $sponsorList;
		}

		public function get_uplines($purchaserid)
		{	

			$socialuserid   = $this->get_user_information_by_dbbid($purchaserid);


			if(! $socialuserid) {

				return [];
			}

			$user       = $this->get_user_information($socialuserid);


			$upline     = $user->upline;
			
			$downlinePosition = $user->L_R;

			$downline   = $user->id;

			$uplineList = array();

			$stop       = false;

			do{
				// echo $loop;
				$this->db->query(
					"SELECT * FROM users where id = '$upline'"
				);

				$result = $this->db->single();

				if($result) 
				{
					$userBinary = new LDUserBinaryObj();

					$userBinary->set_prop('id' , $result->id);
					$userBinary->set_prop('username' , $result->username);
					$userBinary->set_prop('sponsor' , $result->direct_sponsor);
					$userBinary->set_prop('upline' , $result->upline);
					$userBinary->set_prop('position' , $result->L_R);
					$userBinary->set_prop('downlinePosition' , $downlinePosition);
					$userBinary->set_prop('downline' , $downline);
					$userBinary->set_prop('type' , $result->user_type);
					$userBinary->set_prop('accountLevel' , $result->status);
					$userBinary->set_prop('maxPair' , $result->max_pair);

					// $userBinary->set_prop('currentPair' , $this->get_total_pair_today($result->id));
					// $userBinary->set_prop('left' , $this->get_total_points($result->id , 'left'));
					// $userBinary->set_prop('right' , $this->get_total_points($result->id , 'right'));

					$upline = $result->upline;
					$downlinePosition = $result->L_R;
					$downline = $result->id;
					//add users
					$uplineList[] = $userBinary;

				}else{
					$stop = true;
				}
			}while($stop != true);


			return $uplineList;
		}

		private function get_user_information($userid) 
		{
			$this->db->query("SELECT * FROM users where id = '$userid'");

			return $this->db->single();
		}

		private function get_user_information_by_dbbid($dbbid)
		{
			$this->db->query("SELECT ifnull(id , 0) as id 
								FROM users 
									WHERE dbbi_id = '$dbbid'");

			$res = $this->db->single();

			if($res) 
				return $res->id;

			return 0;
		}

		/************************/


		private function add_direct_sponsors_commissions($purchaserid, $sponsors , $product)
		{

			$purchaser = $purchaserid;
			
			$order_id = 0;

			$unilvl = $product->unilvl_amount;
			$drc    = $product->drc_amount;
			$distribution = $product->distribution;

			try{
				if(!empty($sponsors))
				{	
					//loop count of foreach
					$instance = 0;

					if($distribution != null)
					{
						if($instance < $distribution)
						{
							//loop counter
							foreach($sponsors as $sponsor)
							{
								//get the parent ds
								if($instance <= 0){
									/*mentors comissions , unilvl drc*/
									$mentor_comdrc = $this->getMentorCommission($drc);
									$mentor_comunilvl = $this->getMentorCommission($unilvl);

									$mentorCommissionAmount = $mentor_comdrc + $mentor_comunilvl;
									/*insert mentor commission*/
									$commision = $this->inserMentorComission($order_id , $sponsor->id , 
										$purchaser , $mentorCommissionAmount);
									// $this->db->query("
									// 	INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
									// 	VALUES('{$order_id}','{$sponsor->direct_sponsor}' , '{$purchaser}' , 'MENTOR' , '$mentor_com')
									// 	");
									// $this->db->execute();

									try{
										$this->db->query("
											INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
											VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'DRC' , '$drc')
											");
										$this->db->execute();

										Debugger::make_log("{$sponsor->id} Recieved Commission {DRC}  " . 'LDSocialCommissionModel');

									}catch(Exception $e) {

										Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {DRC}  {ERROR}" . 'LDSocialCommissionModel');
										return false;
									}

									try{
										$this->db->query("
											INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
											VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'UNILVL' , '$unilvl')
											");
										$this->db->execute();

										Debugger::make_log("{$sponsor->id} Recieved Commission {UNILEVEL}  " . 'LDSocialCommissionModel');
									}catch(Exception $e) {

										Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {UNILEVEL}  {ERROR}" . 'LDSocialCommissionModel');
										return false;
									}

									$instance++;
								}
								//add commissions to grand parent ds
								else{

									try{
										$this->db->query("
											INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
											VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'UNILVL' , '$unilvl')
										");
										$this->db->execute();

										Debugger::make_log("{$sponsor->id} Recieved Commission {UNILEVEL}  " . 'LDSocialCommissionModel');
									}catch(Exception $e) {

										Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {UNILEVEL}  {ERROR}" . 'LDSocialCommissionModel');
										return false;
									}

									
								}
							}
							//loop counter
						}
					}else
					{
						//loop counter
						foreach($sponsors as $sponsor)
						{
							//get the parent ds
							if($instance <= 0){
								$commision = $this->inserMentorComission($order_id , $sponsor->id , 
										$purchaser , $mentorCommissionAmount);

								try{
									$this->db->query("
										INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
										VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'DRC' , '$drc')
										");
									$this->db->execute();

									Debugger::make_log("{$sponsor->id} Recieved Commission {DRC}  " . 'LDSocialCommissionModel');

								}catch(Exception $e) {

									Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {DRC}  {ERROR}" . 'LDSocialCommissionModel');
									return false;
								}

								try{
									$this->db->query("
										INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
										VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'UNILVL' , '$unilvl')
										");
									$this->db->execute();

									Debugger::make_log("{$sponsor->id} Recieved Commission {UNILEVEL}  " . 'LDSocialCommissionModel');
								}catch(Exception $e) {

									Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {UNILEVEL}  {ERROR}" . 'LDSocialCommissionModel');
									return false;
								}

								$instance++;
							}
							//add commissions to grand parent ds
							else{
								$commision = $this->inserMentorComission($order_id , $sponsor->id , 
										$purchaser , $mentorCommissionAmount);

								try{
									//add commissions to parent ds
									$this->db->query("
									INSERT INTO commissions(order_id, c_id , fu_id , type , amount )
									VALUES('{$order_id}','{$sponsor->id}' , '{$purchaser}' , 'UNILVL' , '$unilvl')
									");
									$this->db->execute();

									Debugger::make_log("{$sponsor->id} Recieved Commission {UNILEVEL}  " . 'LDSocialCommissionModel');

								}catch(Exception $e) {

									Debugger::make_log("{$e->getMessage()} {$sponsor->id} Recieved Commission {UNILEVEL}  {ERROR}" . 'LDSocialCommissionModel');
									return false;
								}
							}
						}
						//loop counter
					}
					
				}
				// return true;
			}catch(Exception $e)
			{	
				echo "AN ERROR OCCURED";
				echo $e->getMessage();
			}
			
		}


		public function add_binary_commissions($purchaserid , $uplines , $product)
		{


			$purchaser = $purchaserid;

			$order_id = 0;

			$points = $product->binary_pb_amount;

			$distribution = $product->distribution;

			$loop_counter = 0;

			try{
				if($distribution == null)
				{
					//loop counter
					foreach($uplines as $upline)
					{
						if($upline->max_pair < 1) {
							continue;
						}else
						{
							$u_id = $upline->id;
							$position = $upline->position;
							$user_max_pair = $upline->max_pair;

							//get each binaryPvInfo
							$bpvDetails = new UserBinaryPV($u_id);

							if($bpvDetails->cur_pair() >= $user_max_pair)
							{
								$this->insert_flushout_points($order_id , $purchaser , $u_id , $position , $points);

							}else{
								//combine cur points and incomming points
								$ip_combined_points = $this->compute_ip($bpvDetails->left_volume() , $bpvDetails->right_volume() , 
									array('points'=>$points , 'position'=>$position));

								//get combine points result [leftc , rightc , pair , amount]
								$computed_points = $this->compute_points($ip_combined_points->left , $ip_combined_points->right);

								if($computed_points->pair != 0)
								{
									//if computed pointts pair generate a pair which > than maxpair
									if(( $computed_points->pair + $bpvDetails->cur_pair() ) > $user_max_pair)
									{	
										$pair_deficit = $user_max_pair - $bpvDetails->cur_pair();
										$pair_extra   = $computed_points->pair - $pair_deficit;

										$this->insert_bpv_commission($order_id , $purchaser , $u_id , $position , $this->pair_to_points($pair_deficit));
										$this->insert_flushout_points($order_id , $purchaser , $u_id , $position , $this->pair_to_points($pair_extra));
									}
									else{

										$this->insert_bpv_commission($order_id , $purchaser , $u_id , $position , $points);
									}
								}else{
									$this->insert_pv_points($order_id , $purchaser , $u_id , $position ,$points);
								}
								
							}
							$loop_counter++;
						}
					}
					//loop counter end
				}else{
					if($loop_counter < $distribution)
					{
						//loop counter
						foreach($uplines as $upline)
						{
							$u_id = $upline->id;
							$position = $upline->position;
							$user_max_pair = $upline->max_pair;

							if($upline->max_pair < 1) 
							{
								continue;
							}else
							{
								$u_id = $upline->id;
								$position = $upline->position;
								$user_max_pair = $upline->max_pair;

								//get each binaryPvInfo
								$bpvDetails = new UserBinaryPV($u_id);

								if($bpvDetails->cur_pair() >= $user_max_pair)
								{
									$this->insert_flushout_points($order_id , $purchaser , $u_id , $position , $points);

								}else
								{
									//combine cur points and incomming points
									$ip_combined_points = $this->compute_ip($bpvDetails->left_volume() , $bpvDetails->right_volume() , 
										array('points'=>$points , 'position'=>$position));

									//get combine points result [leftc , rightc , pair , amount]
									$computed_points = $this->compute_points($ip_combined_points->left , $ip_combined_points->right);

									if($computed_points->pair != 0)
									{
										//if computed pointts pair generate a pair which > than maxpair
										if(( $computed_points->pair + $bpvDetails->cur_pair() ) > $user_max_pair)
										{	
											$pair_deficit = $user_max_pair - $bpvDetails->cur_pair();
											$pair_extra   = $computed_points->pair - $pair_deficit;

											/*PREVIOUSLY COMMENTED*/
											$this->insert_bpv_commission($order_id , $purchaser , $u_id , $position , $this->pair_to_points($pair_deficit));
											$this->insert_flushout_points($order_id , $purchaser , $u_id , $position , $this->pair_to_points($pair_extra));
										}
										else{

											$this->insert_bpv_commission($order_id , $purchaser , $u_id , $position , $points);
										}
									}else{
										$this->insert_pv_points($order_id , $purchaser , $u_id , $position ,$points);
									}
									
								}
							}
							$loop_counter++;
						}
						//loop counter end
					}
				}
				
			}catch(Exceptiion $e)
			{
				die($e->getMessage());
			}
			
		}


		/***********SPAGHETTI**********/

			private function insert_bpv_commission($order_id , $purchaser , $upline_id, $position , $points)
		{
			$id_insert_bpv = $this->insert_pv_points($order_id , $purchaser , $upline_id, $position , $points);

			//insert mentor points
			$user = new UserBinaryPV($upline_id);

			//binarycommission
			$bcom = $this->compute_points($user->left_volume() , $user->right_volume());

			$this->db->query(
				"INSERT INTO $this->binary_pv_pair_commission(user_id , binary_pvs_id , left_volume , right_volume,
				left_carry , right_carry ,pair , amount)

				VALUES(:user_id , :binary_pvs_id , :left_volume , :right_volume , :left_carry , :right_carry ,
				:pair , :amount)"
			);

			$this->db->bind(':user_id' , $upline_id);
			$this->db->bind(':binary_pvs_id' , $id_insert_bpv);
			$this->db->bind(':left_volume' , $bcom->left);
			$this->db->bind(':right_volume' , $bcom->right);
			$this->db->bind(':left_carry' , $bcom->leftc);
			$this->db->bind(':right_carry' , $bcom->rightc);
			$this->db->bind(':pair' , $bcom->pair);
			$this->db->bind(':amount' , $bcom->amount);

			$this->db->execute();

			Debugger::make_log("{$upline_id} Recieved BINARY COMMISSION " . 'LDSocialCommissionModel');

			//addcommissionlast id

			$id_insert_com = $this->db->lastInsertId();

			$this->insert_pair_counter( $id_insert_com ,  $bcom->pair , $upline_id );

			$this->insert_deduct_pv($id_insert_com , $bcom->amount , $upline_id);

			/*getting 10% of total computation of commissioners binary */
			$this->insertBinaryMentorCommission($order_id , $purchaser , $purchaser ,$this->getMentorCommission($bcom->amount));
		}

		private function insert_flushout_points($order_id , $purchaser , $upline_id , $position , $points)
		{
			$this->db->query("INSERT INTO $this->binary_pv (order_id , c_id , fu_id ,pos_lr,points,type) 

				VALUES(:order_id , :c_id , :fu_id , :pos_lr , :points , :type)");

			$this->db->bind(':order_id' , $order_id);
			$this->db->bind(':fu_id' , $purchaser);
			$this->db->bind(':c_id' , $upline_id);
			$this->db->bind(':pos_lr' , $position);
			$this->db->bind(':points' , $points);
			$this->db->bind(':type' , 'flash-out');

			$this->db->execute();

			return $this->db->lastInsertId();
		}
		
		private function insert_pv_points($order_id , $purchaser , $upline_id , $position , $points)
		{
			$this->db->query("INSERT INTO $this->binary_pv (order_id , c_id , fu_id ,pos_lr,points,type) 

				VALUES(:order_id , :c_id , :fu_id , :pos_lr , :points , :type)");

			$this->db->bind(':order_id' , $order_id);
			$this->db->bind(':fu_id' , $purchaser);
			$this->db->bind(':c_id' , $upline_id);
			$this->db->bind(':pos_lr' , $position);
			$this->db->bind(':points' , $points ?? 0);
			$this->db->bind(':type' , 'points');

			$this->db->execute();

			return $this->db->lastInsertId();
		}

		private function insert_pair_counter($binary_pv_com_id , $pair , $user_id)
		{
			$this->db->query(
				"INSERT INTO binary_pv_pair_counter(pair , binary_pv_com_id , user_id)
				 VALUES(:pair , :binary_pv_com_id , :user_id)"
			);

			$this->db->bind(':pair' , $pair);
			$this->db->bind(':binary_pv_com_id' , $binary_pv_com_id);
			$this->db->bind(':user_id' , $user_id);

			$this->db->execute();
		}

		private function insert_deduct_pv($b_com_id , $points , $user_id)
		{
			$this->db->query(
				"INSERT INTO $this->binary_pv_pair_deduction(user_id , binary_pv_com_id , points)
				 VALUES('$user_id' , '$b_com_id' , '$points')
				"
			);

			$this->db->execute();
		}

		private function inserMentorComission($order_id , $c_id , $fu_id , $amount)
		{
			//get purchaser sponsor sponsor;

			$this->db->query("SELECT direct_sponsor as sponsorid from users where id = '$c_id'");
			$mentorid = $this->db->single();

			if(!empty($mentorid))
			{
				$mentorid = $mentorid->sponsorid;
				$this->db->query(
					"INSERT INTO commissions(order_id , type , c_id , fu_id , amount)
					VALUES('$order_id' , 'MENTOR' , '$mentorid' , '$fu_id' , '$amount')"
				);

				Debugger::make_log("{$mentorid} Recieved BINARY MENTOR COMMISSION " . 'LDSocialCommissionModel');

				return $this->db->insert();
			}else{
				$mentorid = 0;
			}

			return true;
		}

		private function insertBinaryMentorCommission($order_id , $c_id , $fu_id , $amount)
		{
			$mentorid  = 0;

			$this->db->query("SELECT direct_sponsor as sponsorid from users where id = '$c_id'");

			$sponsor = $this->db->single();

			if(!empty($sponsor)){

				$sponsorid = $sponsor->sponsorid;

				return $this->inserMentorComission($order_id , $sponsorid , $fu_id , $amount);

			}else{
				return 0;
			}
		}
		/*
		*@param
		*left volume of upline
		*right volume of upline
		*IP incomming points
		*/
		private function compute_ip($left , $right , $IP)
		{
			if(strtolower($IP['position']) === 'left')
			{
				$left += $IP['points'];
			}else{
				$right += $IP['points'];
			}

			$computed = new stdClass();
			
			$computed->left  = $left;
			$computed->right = $right;

			return $computed;  
		} 
		// will return left right , leftc , right c , pair , amount
		private function compute_points($left , $right)
		{	
			//this will be dynamic and will be set by the app admin
			$settings = 100;

			$combined = new stdClass();

			$left_ceil  = $this->get_volcount($left);
			$right_ceil = $this->get_volcount($right);


			$pair = $left_ceil > $right_ceil ? $right_ceil: $left_ceil;

			//points or amount
			$amount = $pair * $settings;

			$combined->pair   = $pair;
			$combined->amount = $amount;

			$combined->left   = $left;
			$combined->right  = $right;

			$combined->leftc  = $left  - $amount;
			$combined->rightc = $right - $amount;


			return $combined;

			// return array(
			// 	'left','right','leftc','rightc','pair','amount'
			// );
		}

		private function get_volcount($volume)
		{
			$settings = 100;

			if($volume >= $settings)
				return floor($volume / $settings);
			return 0;
		}

		private function pair_to_points($pair)
		{	
			//points settings
			$point = 100;
			return $pair * $point;
		}


		private function getMentorCommission($drc)
		{	
			$percentage = 0.1;

			if($drc <= 0)
				return 0;
			return $percentage * $drc;

		}

		/*****************************/
	}