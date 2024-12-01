<?php 	

	class MGPayout_RequestModel extends Base_model 
	{
		private $table_name = 'mg_payouts';

		public $table = 'mg_payouts';

		public function make_request($userid)
		{	
			$check_request = $this->check_request($userid);

			if(empty($check_request))
			{
				$this->db->query(
					"INSERT payout_request(`userId`) VALUES ('$userid')"
				);
				return $this->db->execute();
			}else
			{
				return false;
			}
			
		}

		public function check_request($userid)
		{
			//check if has current request
			$this->db->query("SELECT * FROM payout_request 
				WHERE userId = '$userid' AND status = 'pending'");
			return $this->db->resultSet();
		}	


		public function get_payouts()
		{
			/*get recent payout*/
			$most_recent_payout = $this->get_recent_payout();
			
			if($most_recent_payout) {
				//get cutoff
				$cutoff = null;


				$resultSet = $this->get_commissions();

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
					'list'    => $this->get_commissions(),
					'total'   => $total
				];
			}else{

				$resultSet = $this->get_commissions();
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

		private function get_commissions()
		{

			$table_name = 'commission_transactions';

			$prev_payout = "SELECT sum(amount) as total_amount from mg_payout_items 
					where userid = u.id group by userid";
	

			$userList = 
				"SELECT * , concat(firstname , ' ' , lastname) as fullname FROM users";					

			$makeQuery ="SELECT u.username , u.fullname , userid , (sum(amount)-IFNULL(($prev_payout),0)) as amount 

					FROM $table_name as com 

					LEFT join ($userList) as u

					on u.id = com.userid

					WHERE userid != '' AND 
					(SELECT COUNT(*) FROM payout_request WHERE userId = u.id and status ='pending') >= 1

					group by userid ORDER BY amount DESC";
	

			$this->db->query($makeQuery);

			return $this->db->resultSet();
		}

		public function make_cheques()
		{

			$getForPayouts = $this->get_commissions();
		
			$userid = Session::get('USERSESSION')['id'];

			if(!empty($getForPayouts))
			{		
				try{

					$doCheques = $this->make_cheque_items($getForPayouts);
					
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

		public function make_cheque_items($forPayouts)
		{
			$makeQuery = "INSERT INTO mg_payout_items(userid , amount ,status) VALUES";

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

					$makeQuery .= "('$row->userid' , '$row->amount' , 'pending')";

					//update request from pending to
					$this->request_change_status($row->userid,'released');	
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

		public function request_change_status($userid,$status)
		{
			$this->db->query(
					"UPDATE `payout_request` 
					 SET `status`='$status' 
					 WHERE userId = '$userid'
					 AND status='pending'"
				);
			return $this->db->execute();
		}	
	}

	