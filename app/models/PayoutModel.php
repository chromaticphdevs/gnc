<?php 	
	use app\Classes\UserPayout;
	require_once(APPROOT.DS.'classes/UserPayout.php');

	class PayoutModel extends Base_model
	{
		public function displayPayoutList($start , $end , $userList)
		{
			$userPayouts = array();
			$total = 0;

			foreach($userList as $user)
			{	
				$uWallet = new UserPayout($user->id , new Database());

				if ($uWallet->getCommissions($start , $end) <= 0)
				{
					continue;
				}else
				{
					$tmp = array(
						'userId' => $user->id ,
						'username' => $user->username ,
						'fullname' => $user->firstname . ' ' . $user->lastname,
						'wallet'   => $uWallet->getCommissions($start , $end)
					);

					$total += $tmp['wallet'];

					array_push($userPayouts, $tmp);
				}
			}

			return array(
				'userPayouts' => $userPayouts ,
				'total' => number_format($total , 2)
			);
		}

		public function getPayout($payoutid)
		{
			$this->db->query("SELECT * from payouts where id = :payoutid");

			$this->db->bind(':payoutid' , $payoutid);

			return $this->db->single();
		}

		public function getLatestPayout()
		{
			$this->db->query("SELECT * FROM payouts 
				order by date_to desc limit 1");

			$res = $this->db->single();

			if($res)
				return $res->date_to;
			return false;
		}

		public function generatePayout($start , $end , $userListWithPayout)
		{
			try
			{
				$this->db->instance()->beginTransaction();

				$this->db->query(
					"INSERT INTO payouts(created_on ,date_from , date_to , status) 
					VALUES(now() , :start , now() ,'released')"
				);

				$this->db->bind('start' , $start);

				if(!$this->db->insert())
				{
					throw new Exception("Executation error on payout create", 1);
				}else{
					$payoutid = $this->db->lastInsertId();

					$this->db->instance()->commit();

					return $this->ascheque($payoutid , $userListWithPayout);
				}
				
			}catch(Exception $e)
			{
				$this->db->instance()->rollback();

				echo $e->getMessage();
			}

		}

		public function ascheque($payout_id , $userlist)
		{
			//payout information
			$payout = $this->getPayout($payout_id);

			$userPayouts = array();
			//release payout cheque
			$sql = "INSERT INTO payout_cheque(payout_id,user_id,amount,status) VALUES";
			//query to deduct sponsor amount
			$sql_deduct_drc = "INSERT INTO comission_deductions(user_id , deductor , amount , com_type)
			VALUES ";

			$sql_deduct_mentor = "INSERT INTO comission_deductions(user_id , deductor , amount , com_type)
			VALUES ";
			$sql_deduct_unilvl = "INSERT INTO comission_deductions(user_id , deductor , amount , com_type)
			VALUES ";
			//query to deduct binary wallet
			$sql_deduct_binary  = "INSERT INTO wallet_withdrawals
			(user_id , amount) VALUES ";

			$counter = 1;

			foreach($userlist as $user)
			{
				$uWallet = new UserPayout($user->id , new Database());
				$amount = $uWallet->getCommissions($payout->date_from , $payout->date_to);


				$points  = $uWallet->getBinaryCommission();

				$sponsor = $uWallet->getSponsorCommission();

				$drc     = $uWallet->getDrc();

				$unilvl  = $uWallet->getUnilvl();

				$mentor  = $uWallet->getMentor();


				if($amount > 0)
				{
					$sql .= "('$payout->id' , '$user->id' , '$amount' , 'recieved')";

					$sql_deduct_drc .= "('$user->id' , 'payout' , '$drc' ,'DRC')";

					$sql_deduct_mentor .= "('$user->id' , 'payout' , '$mentor' ,'MENTOR')";

					$sql_deduct_unilvl .= "('$user->id' , 'payout' , '$unilvl' ,'UNILVL')";

					$sql_deduct_binary  .= "('$user->id' , '$points')";

					if($counter < count($userlist))
					{
						$sql.=',';
						$sql_deduct_unilvl .= ',';
						$sql_deduct_drc    .= ',';
						$sql_deduct_mentor    .= ',';
						$sql_deduct_binary  .= ',';
					}
				}

				$counter++;

				
			}
			//insert release chhque
			try
			{
				$this->db->instance()->beginTransaction();
				if($amount > 0)
				{
					if(!$this->release_cheque($sql)){
						throw new Exception("AMOUNT ERR", 1);
					}

					if($drc > 0)
					{
						if(!$this->deduct_drc($sql_deduct_drc)){
							throw new Exception("DRC ERR", 1);
						}
					}

					if($unilvl > 0)
					{
						if(!$this->deduct_unilvl($sql_deduct_unilvl)){
							throw new Exception("UNILVL ERR", 1);
						}
					}

					if($points > 0)
					{
						if(!$this->deduct_binary($sql_deduct_binary)){
							throw new Exception("POINTS ERR", 1);
						}
					}

					if($mentor > 0)
					{
						if(!$this->deduct_mentor($sql_deduct_mentor)){
							throw new Exception("MENTOR ERROR", 1);
						}
					}
				}

				$this->db->instance()->commit();

				return true;
			}catch(Exception $e)
			{
				$this->db->instance()->rollback();
				return false;
			}
		}

		private function release_cheque($sql)
		{
			$this->db->query($sql);

			if($this->db->execute())
				return true;

			die("releasing cheque failed");
		}

		private function deduct_drc($sql)
		{
			$this->db->query($sql);

			if($this->db->execute())
				return true;

			die("releasing sql_deduct_drc failed");
		}

		private function deduct_mentor($sql)
		{
			$this->db->query($sql);

			if($this->db->execute())
				return true;

			die("releasing sql_deduct_mentor failed");
		}

		private function deduct_unilvl($sql)
		{
			$this->db->query($sql);

			if($this->db->execute())
				return true;

			die("releasing sql_deduct_unilvl failed");
		}
		private function deduct_binary($sql)
		{
			$this->db->query($sql);

			if($this->db->execute())
				return true;

			die("releasing deduct_binary failed");
		}

		private function updatePayout(int $payout_id)
		{
			$this->db->query("UPDATE payouts set status = 'released' where id = :payout_id");
			$this->db->bind('payout_id' , $payout_id);

			if($this->db->execute())
				return $payout_id;
			return 0;
			
		}
		public function getList()
		{
			$this->db->query("SELECT * FROM payouts order by date_from desc");

			return $this->db->resultSet();
		}

		public function getHasBalance()
		{
			$sql = "SELECT username ,sum(amount) as balance from payout_cheque

			left join users
			on users.id = payout_cheque.user_id

			where amount != 0
			
			GROUP by user_id";

			$this->db->query($sql);

			return $this->db->resultSet();
		}
	}