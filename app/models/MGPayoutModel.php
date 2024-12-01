<?php 	

	class MGPayoutModel extends Base_model 
	{

		private $table_name = 'mg_payouts';

		public function get_for_payouts()
		{
			/*get recent payout*/
			$most_recent_payout = $this->get_recent_payout();
			
			if($most_recent_payout) {
				//get cutoff
				$cutoff = $most_recent_payout->dateend;


				$resultSet = $this->get_commissions_with_user($cutoff);

				$total = 0;

				if(!empty($resultSet)) 
				{
					foreach($resultSet as $key => $row) 
					{	
					
						$total += $row->amount;
				
					}
				}

				return [
					'details' => $most_recent_payout, 
					'list'    => $this->get_commissions_with_user($cutoff),
					'total'   => $total
				];
			}else{

				$resultSet = $this->get_commissions_with_user(null);
				$total = 0;


				if(!empty($resultSet)) 
				{
					foreach($resultSet as $key => $row) 
					{					
						$total += $row->amount;
					}
				}
				
				return [
					'details'  => '',
					'list'    => $resultSet,
					'total'   => $total
				];
			}
		}



		public function get_recent_payout()
		{	
			$this->db->query(
				"SELECT * FROM $this->table_name order by id desc limit 1"
			);

			return $this->db->single();
		}


		public function get_payout($payoutid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name where id = '$payoutid'"
			);

			return $this->db->single();
		}

		private function get_commissions_with_user($cutoff = null)
		{
			$table_name = 'commission_transactions';

			/*if no cutoff*/
			if(is_null($cutoff)) 
			{
				/*get comissioners*/

				$userList = 
					"SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users";


				$total_amount ="SELECT sum(amount)

						FROM $table_name as com 
						WHERE userid = u.id
						group by userid ORDER BY amount DESC";



				$makeQuery ="SELECT u.username , u.fullname , userid , sum(amount) as amount 

						FROM $table_name as com 

						LEFT join ($userList) as u

						on u.id = com.userid

						WHERE userid != '' 

						group by userid ORDER BY amount DESC";


				$this->db->query($makeQuery);
			}else{

				$userList = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users ";



				$total_amount ="SELECT sum(amount)

						FROM $table_name as com 
						WHERE userid = u.id
						group by userid ORDER BY amount DESC";


						$makeQuery ="SELECT u.username , u.fullname , userid , sum(amount) as amount 

						FROM $table_name as com 

						LEFT join ($userList) as u

						on u.id = com.userid

						WHERE com.created_at > '$cutoff' AND com.userid != '' 

						group by userid ORDER BY amount DESC";


				$this->db->query($makeQuery);
			}


			return $this->db->resultSet();
		}











//with valid ID----------------------------------------------------------------------------------------------------------------------

		public function get_for_payouts_valid_id($limit_amount)
		{
			/*get recent payout*/
			$most_recent_payout = $this->get_recent_payout();
			
			if($most_recent_payout) {
				//get cutoff
				$cutoff = $most_recent_payout->dateend;


				$resultSet = $this->get_commissions_with_user_valid_id($cutoff, $limit_amount);

				$total = 0;

				if(!empty($resultSet)) 
				{
					foreach($resultSet as $key => $row) 
					{	
					
							$total += $row->amount;
	
						
					}
				}

				return [
					'details' => $most_recent_payout, 
					'list'    => $this->get_commissions_with_user_valid_id($cutoff, $limit_amount),
					'total'   => $total
				];
			}else{

				$resultSet = $this->get_commissions_with_user_valid_id(null, $limit_amount);
				$total = 0;


				if(!empty($resultSet)) 
				{
					foreach($resultSet as $key => $row) 
					{
				
							$total += $row->amount;
					}
				}
				
				return [
					'details'  => '',
					'list'    => $resultSet,
					'total'   => $total
				];
			}
		}

		private function get_commissions_with_user_valid_id($cutoff = null, $limit_amount)
		{

			$table_name = 'commission_transactions';

			/*if no cutoff*/
			if(is_null($cutoff)) 
			{
				/*get comissioners*/

				$userList = 
					"SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users";

				$total_amount ="SELECT sum(amount)
								FROM commission_transactions as com 
								WHERE userid = u.id AND com.created_at > '$cutoff' 
								AND com.userid != '' group by userid";
					


				$makeQuery ="SELECT u.username , u.fullname , userid , sum(amount) as amount 

						FROM $table_name as com 

						LEFT join ($userList) as u

						on u.id = com.userid

						WHERE userid != '' AND ($total_amount) >= $limit_amount AND 
						(SELECT COUNT(*) FROM users_uploaded_id WHERE userid = u.id and status ='verified') >= 1

						group by userid ORDER BY amount DESC";
	

				$this->db->query($makeQuery);
				
			}else{

				$userList = "SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users ";



				$total_amount ="SELECT sum(amount)
								FROM commission_transactions as com 
								WHERE userid = u.id AND com.created_at > '$cutoff' 
								AND com.userid != '' group by userid";
					

						$makeQuery ="SELECT u.username , u.fullname , userid , sum(amount) as amount 

						FROM $table_name as com 

						LEFT join ($userList) as u

						on u.id = com.userid

						WHERE com.created_at > '$cutoff' AND com.userid != '' AND ($total_amount)  >= $limit_amount  AND 
						(SELECT COUNT(*) FROM users_uploaded_id WHERE userid = u.id and status ='verified') >= 1

						group by userid ORDER BY amount DESC";

				$this->db->query($makeQuery);

			}


			return $this->db->resultSet();
		}

//with valid ID-------------------------------------------------END---------------------------------------------------------------------

	


		public function get_user_available_payout($userid) 
		{
			$most_recent_payout = $this->get_recent_payout();


			if(!empty($most_recent_payout))
			{
				$cutoff = $most_recent_payout->dateend;

				$this->db->query(
					"SELECT sum(amount) as total_amount from commission_transactions as com
						WHERE com.userid = '$userid' and com.created_at > '$cutoff'"
				);


				$res = $this->db->single();

				if($res) {
					return $res->total_amount;
				}
			}
			
			return 0;
		}

		private function get_commissions_total($cutoff = null) 
		{
			$table_name = 'commission_transactions';

			if(is_null($cutoff)) 
			{
				$this->db->query(
					"SELECT sum(amount) as  total FROM $table_name"
				);

			}else{
				$this->db->query(
					"SELECT sum(amount) as  total FROM $table_name 
						WHERE created_at > '$cutoff'"
				);
			}


			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		public function make_cheques()
		{
			$most_recent_payout = $this->get_recent_payout();

			$cutoff = $most_recent_payout->dateend ?? '';

			$status  = 'released';

			$getForPayouts = $this->get_commissions_with_user($cutoff);

			$userid = Session::get('USERSESSION')['id'];

			if(!empty($getForPayouts))
			{
				/*create payout*/
				if($most_recent_payout) {
					$start = $most_recent_payout->dateend;

					$this->db->query(
						"INSERT INTO mg_payouts(userid , datestart , dateend , status) 
						VALUES('$userid' , '$start' , now() , '$status')"
					);
					
				}else{

					$this->db->query(
						"INSERT INTO mg_payouts(userid , datestart , dateend , status) 
						VALUES('$userid' , now() , now() , '$status')"
					);
				}

				try{

					$insertid = $this->db->insert();

					$doCheques = $this->make_cheque_items($insertid , $getForPayouts);
					
					return true;

				}catch(Exception $e) {

					die(var_dump($e->getMessage()));
					
					return false;
				}
			}else{
				Flash::set("No user that will payout" , 'danger');

				return false;
			}
		}





	// make cheques w/ valid ID--------------------------------------------------------------------------
		public function make_cheques_valid_id($limit_amount)
		{
			$most_recent_payout = $this->get_recent_payout();

			$cutoff = $most_recent_payout->dateend ?? '';

			$status  = 'released';

			$getForPayouts = $this->get_commissions_with_user_valid_id($cutoff ,$limit_amount);
	
			$userid = Session::get('USERSESSION')['id'];

			if(!empty($getForPayouts))
			{
				/*create payout*/
				if($most_recent_payout) {
					$start = $most_recent_payout->dateend;

					$this->db->query(
						"INSERT INTO mg_payouts(userid , datestart , dateend , status) 
						VALUES('$userid' , '$start' , now() , '$status')"
					);
					
				}else{

					$this->db->query(
						"INSERT INTO mg_payouts(userid , datestart , dateend , status) 
						VALUES('$userid' , now() , now() , '$status')"
					);
				}

				try{

					$insertid = $this->db->insert();

					$doCheques = $this->make_cheque_items($insertid , $getForPayouts);
					
					return true;

				}catch(Exception $e) {

					die(var_dump($e->getMessage()));
					
					return false;
				}
			}else{
				Flash::set("No user that will payout" , 'danger');

				return false;
			}
		}

// make cheques w/ valid ID----------end----------------------------------------------------------------



		public function make_cheque_items($payoutid , $forPayouts)
		{
			$makeQuery = "INSERT INTO mg_payout_items(payoutid , userid , amount ,status) VALUES";

			$counter = 0;

			foreach($forPayouts as $key => $row)
			{
				
				if(!empty($row->userid)) 
				{	
					if($counter < $key) 
					{
						$makeQuery .= ',';
						$counter++;
					}

					$makeQuery .= "('$payoutid' , '$row->userid' , '$row->amount' , 'pending')";

					
				}
			}
			
			try{

				$this->db->query($makeQuery);

				$this->db->execute();

				return true;
			}catch(Exception $e) 
			{
				die($e->getMessage());
			}
		}

		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT * FROM mg_payouts $params"
			);

			return $this->db->resultSet();
		}

		public function get_list_with_total()
		{
			$this->db->query(
				"SELECT mg.* , sum(amount) as total 
					FROM mg_payouts as mg

					left join mg_payout_items as mgi 
					on mg.id = mgi.payoutid
					
					group by mg.id"
			);

			return $this->db->resultSet();
		}

		public function get_list_descending()
		{
			return $this->get_list(
				" ORDER BY id desc"
			);
		}




	}

	/*
	truncate mg_payouts;
	truncate mg_payout_items;
	*/