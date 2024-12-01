<?php
	
	use app\Classes\UserPayout;
	require_once(APPROOT.DS.'classes/UserPayout.php');
	class Payout_model extends Base_model
	{
		/**
		*@param both referring to dates
		*/
		public function generatePayout($start , $end)
		{
			$this->db->query(
				"INSERT INTO payouts(created_on ,date_from , date_to , status) 
				VALUES(now() , :start , :date_end ,'pending')"
			);

			$this->db->bind('start' , $start);
			$this->db->bind('date_end' , $end);

			if($this->db->execute())
			{
				return $this->db->lastInsertId();
			}else{
				return 0;
			}

		}

		public function ascheque($payout_id , $userlist)
		{
			//payout information
			$payout = $this->getPayoutId($payout_id);

			$userPayouts = array();
			//release payout cheque
			$sql = "INSERT INTO payout_cheque(payout_id,user_id,amount,status) VALUES";
			//query to deduct sponsor amount
			$sql_deduct_drc = "INSERT INTO comission_deductions(user_id , deductor , amount , com_type)
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

				$sql .= "('$payout->id' , '$user->id' , '$amount' , 'pending')";

				$sql_deduct_drc .= "('$user->id' , 'payout' , '$drc' ,'DRC')";

				$sql_deduct_unilvl .= "('$user->id' , 'payout' , '$unilvl' ,'UNILVL')";

				$sql_deduct_binary  .= "('$user->id' , '$points')";

				if($counter < count($userlist))
				{
					$sql.=',';
					$sql_deduct_unilvl .= ',';
					$sql_deduct_drc    .= ',';
					$sql_deduct_binary  .= ',';

					$counter++;
				}
			}

			if($this->release_cheque($sql) && $this->deduct_drc($sql_deduct_drc) && 
				$this->deduct_unilvl($sql_deduct_unilvl) && 
				$this->deduct_binary($sql_deduct_binary) )
			{
				$updatePayout = $this->updatePayout($payout_id);
				if($updatePayout)
					return $updatePayout;
				return 0;
			}else{
				return 0;
			}
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
		public function getPayoutId(int $payout_id)
		{
			$this->db->query("SELECT * from payouts where id = :payout_id");

			$this->db->bind(':payout_id' , $payout_id);

			return $this->db->single();
		}

		public function getList(?string $type = null)
		{
			switch($type)
			{
				case null;
				$this->db->query("SELECT * FROM payouts
				 where date_from != '0000-00-00' and date_to != '0000-00-00'
					order by date_from , date_to , status desc");
				break;
			}


			return $this->db->resultSet();
		}
	}<?php 	

	class Payroll_model extends Base_model
	{
		private $table_name = 'users_payroll';

		//secret is cookie
		public function loginUser($secret , $password)
		{
			$res = $this->getUser('secret' , $secret);

			if(!$res)
			{
				return [
					'status' => FALSE , 
					'errors' => 'NO USER FOUND'
				];
			}
			//check password
			if($res->password != $password)
			{
				return [
					'status' => FALSE , 
					'errors' => 'Incorrect Password'
				];
			}

			return $res;
		}

		private function getUser($field , $value)
		{
			$this->db->query("SELECT * FROM $this->table_name where 
				$field = '$value'");

			$res = $this->db->single();

			if($res)
				return $res;
			return 0;
		}

		public function saveCookie($cookie)
		{
			$this->db->query("INSERT INTO $this->table_name(password , secret)
				VALUES('1111' , '$cookie')");

			return $this->db->execute();
		}
	}