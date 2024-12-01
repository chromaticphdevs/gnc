<?php 	


	class SneModel extends Base_model
	{	
		public function over_all_user_lvl_activated()
	    {
	    
	    	$levels = array("starter", "bronze", "silver", "gold", "platinum", "diamond");
	    	$user_count = [];
	    	$total = 0;
	    	for($row = 0; $row < count($levels); $row++)
	    	{
	    		$this->db->query(
					"SELECT COUNT(username) as total FROM `users` WHERE status='$levels[$row]' "
				);

				$data = $this->db->single();

				array_push($user_count, array($data->total) );

				$total += $data->total;

	    	}
	    	array_push($user_count, array($total) );
	    	return $user_count;

	    }

	    public function over_all_amount_code_used_byLevel()
	    {
	    
	    	$levels = array("starter", "bronze", "silver", "gold", "platinum", "diamond");
	    	$total_amount = [];
	    	$total = 0;
	    	for($row = 0; $row < count($levels); $row++)
	    	{
	    		$this->db->query(
					"SELECT SUM(amount) as total_amount 
					FROM `fn_code_inventories` 
					WHERE level='$levels[$row]' AND (status= 'used' OR status= 'released')"
				);

				$data = $this->db->single();

				array_push($total_amount, array($data->total_amount) );

				$total += $data->total_amount;

	    	}
	    	array_push($total_amount, array($total) );
	    	return $total_amount;

	    }

		public function get_binary_commission($userid)
		{
			$this->db->query(
				"SELECT sum(amount) as total from binary_pv_commissions where user_id = '{$userid}' "
			);

			$res = $this->db->single();

			if($res) {
				return $res->total;
			}

			return 0;
		}

		public function get_direct_commission($userid)
		{
			$this->db->query(
				"SELECT sum(amount) as total , type from commissions where user_id = '{$userid}' 
				GROUP BY type"
			);

			$res = $this->db->resultSet();

			if($res) {
				return [
					$res->total , 
					$res->type
				];
			}

			return [];
		}


		private function get_toppers($top = 10 , $number_of_days = null, $type)
		{
			if(is_null($number_of_days)) {
				$today = date("Y-m-d");

				$sql = "SELECT userid , sum(amount) as total , username , 
				concat(firstname , ' ' ,lastname) as fullname 

				from commission_transactions as com 

				left join users as u on com.userid = u.id

				WHERE com.date = '{$today}' and com.type = '{$type}' 

				group by com.userid

				order by total desc 

				limit {$top}";
			}else{
				$to = date("Y-m-d");
			
				$number_of_days-=1;

				$date = new DateTime($to);
				
				$date->sub(new DateInterval('P'.$number_of_days.'D'));
				
				$from = $date->format('Y-m-d');

				$sql = "SELECT userid , sum(amount) as total , username , 
				concat(firstname , ' ' ,lastname) as fullname 

				from commission_transactions as com 

				left join users as u on com.userid = u.id

				WHERE date(com.date) <= '$to' AND date(com.date) >= '$from' and com.type = '{$type}' 

				group by com.userid

				order by total desc 

				limit {$top}";
			}
			try{
				$this->db->query($sql);

				return $this->db->resultSet();
			}catch(Exception $e) 
			{
				die($e->getMessage());
			}
		}

		public function get_toppers_directsponsors($top, $num_of_days) {

			return $this->get_toppers($top ,$num_of_days , 'drc');
		}

		public function get_toppers_unilevels($top, $num_of_days) {

			return $this->get_toppers($top ,$num_of_days , 'unilevel');
		}

		public function get_toppers_mentors($top, $num_of_days) {

			return $this->get_toppers($top ,$num_of_days , 'mentor');
		}

		public function get_toppers_binary($top, $num_of_days) {

			return $this->get_toppers($top ,$num_of_days , 'binary');
		}


		public function get_toppers_overall($top , $number_of_days) 
		{

			if(is_null($number_of_days)) 
			{
				$today = date("Y-m-d");

				$sql = "SELECT userid , sum(amount) as total , username , 
				concat(firstname , ' ' ,lastname) as fullname 

				from commission_transactions as com 

				left join users as u on com.userid = u.id

				WHERE date = '{$today}'

				group by com.userid

				order by total desc 

				limit {$top}";

			}else{
				$to = date("Y-m-d");
			
				$number_of_days-=1;

				$date = new DateTime($to);
				
				$date->sub(new DateInterval('P'.$number_of_days.'D'));
				
				$from = $date->format('Y-m-d');

				$sql = "SELECT userid , sum(amount) as total , username , 
				concat(firstname , ' ' ,lastname) as fullname 

				from commission_transactions as com 

				left join users as u on com.userid = u.id

				WHERE date(com.date) <= '$to' AND date(com.date) >= '$from'

				group by com.userid

				order by total desc 

				limit {$top}";
			}

			try{
				$this->db->query($sql);

				return $this->db->resultSet();

			}catch(Exception $e) {

				die($e->getMessage());
			}
		}


		private function temporary_view_commission($number_of_days = null)
		{

			if(is_null($number_of_days)) {
				$today = date("Y-m-d");

				$sql = "
				SELECT c_id as userid , ifnull(sum(com.amount) , 0) as total

				FROM commissions as com 

				WHERE date(com.dt) = '{$today}' 

				group by c_id";

			}else{
				$sql = "
				SELECT c_id as userid , ifnull(sum(com.amount) , 0) as total

				FROM commissions as com 

				WHERE date(com.dt) <= '$to' AND date(com.dt) >= '$from' 
				group by c_id";

			}

			return $sql;
		}
		private function temporary_view_binary_commission($number_of_days = null)
		{

			if(is_null($number_of_days)) {
				$today = date("Y-m-d");

				$sql = " SELECT user_id as userid , ifnull(sum(binarycom.amount) , 0) total 

					from binary_pv_commissions as binarycom 

					where date(binarycom.dt) = '{$today}' group by user_id";

			}else{

				$to = date("Y-m-d");
			
				$number_of_days-=1;

				$date = new DateTime($to);
				
				$date->sub(new DateInterval('P'.$number_of_days.'D'));
				
				$from = $date->format('Y-m-d');

				$sql = " SELECT user_id as userid , ifnull(sum(binarycom.amount) , 0) total 

					from binary_pv_commissions as binarycom 

					where date(binarycom.dt) <= '$to' AND date(binarycom.dt) >= '$from' group by user_id";
			}

			return $sql;
		}
	}

  

	// SELECT c_id as userid, SUM(amount) as total ,  username , concat(firstname , ' ' , lastname) as fullname 
	// 				FROM commissions as com  
	// 					LEFT JOIN users as u on com.c_id = u.id  

	// 					LEFT JOIN ($binary) as binary on binary.userid = com.c_id

	// 						WHERE amount != 0  and date(dt) = '{$today}'
	// 							GROUP by c_id order by total DESC limit 10