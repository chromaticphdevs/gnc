<?php 	

	class CSR_ReportsModel extends Base_model
	{

		public $table = 'csr_timesheets';
       

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

        public function get_call_history($user_id, $account_type = null)
        {

        	$condition = "";
        	if($user_id != "ALL" )
        	{
        		$condition = "WHERE user_id = $user_id AND account_type = '$account_type'";
        	}

			$date = date("Y-m-d");

			$this->set_time_zone();

        	$this->db->query(
        		"SELECT *,SUM(duration) total_duration,COUNT(customer_id) as total_call_today ,SUM(amount) as allowance,(SELECT CONCAT(firstname,' ', lastname) FROM users WHERE id = `csr_timesheets`.`user_id` AND `csr_timesheets`.`account_type` = 'user') as csr_user, (SELECT name FROM fn_accounts WHERE id = `csr_timesheets`.`user_id` AND `csr_timesheets`.`account_type` = 'manager') as csr_manager FROM {$this->table} {$condition}   GROUP BY user_id , account_type ORDER BY `account_type` DESC"
        	);


        	return $this->db->resultSet();
        }


        public function get_chart($user_id, $account_type)
		{	
			$condition = "";

        	if($user_id != "ALL" )
        	{
        		$condition = " user_id = ".$user_id." AND account_type = '".$account_type."' AND";
        	}
			
			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(*) FROM csr_timesheets WHERE {$condition}  DATE(created_at) = '$date') as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}
			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		// todays reports chart and list of called 
		public function get_call_history_today($date)
        {
		
			$this->set_time_zone();

        	$this->db->query(
        		"SELECT *,SUM(duration) total_duration,COUNT(customer_id) as total_call_today ,SUM(amount) as allowance,(SELECT CONCAT(firstname,' ', lastname) FROM users WHERE id = `csr_timesheets`.`user_id` AND `csr_timesheets`.`account_type` = 'user') as csr_user, (SELECT name FROM fn_accounts WHERE id = `csr_timesheets`.`user_id` AND `csr_timesheets`.`account_type` = 'manager') as csr_manager FROM {$this->table} WHERE DATE(created_at) = '$date'   GROUP BY user_id , account_type ORDER BY `account_type` DESC"
        	);
        	return $this->db->resultSet();
        }


        public function get_chart_today($user_id)
		{	
			$condition = "";

        	if($user_id != "ALL" )
        	{
        		$condition = " user_id = ".$user_id." AND";
        	}
			
			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(*) FROM csr_timesheets WHERE {$condition}  DATE(created_at) = '$date') as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}
			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		public function get_sorted_duration($user_id, $account_type)
		{	
			$sql = "SELECT * FROM `csr_timesheets` WHERE `duration`";
			$condition = "AND user_id = ".$user_id." AND account_type = '".$account_type."'";

			$this->db->query(
        		"{$sql} <= 1 {$condition }"
        	);
        	$search1 = count($this->db->resultSet());

        	$this->db->query(
        		"{$sql} >= 1.1 and duration <= 2 {$condition }"
        	);
        	$search2 = count($this->db->resultSet());

        	$this->db->query(
        		"{$sql} >= 2.1 and duration <= 3 {$condition }"
        	);
        	$search3 = count($this->db->resultSet());

        	$this->db->query(
        		"{$sql} >= 3.1 and duration <= 4 {$condition }"
        	);
        	$search4 = count($this->db->resultSet());

        	$this->db->query(
        		"{$sql} >= 4.1 and duration <= 5 {$condition }"
        	);
        	$search5 = count($this->db->resultSet());

			$data = [
                  'search1' =>  $search1,
                  'search2' =>  $search2,
                  'search3' =>  $search3,
                  'search4' =>  $search4,
                  'search5' =>  $search5,
            ];

        	return $data;
			
		}

		// change this code ahhaha
		public function get_sorted_duration_today($date, $userList)
		{	
			
			$sql = "SELECT COUNT(*) FROM `csr_timesheets` WHERE `duration`";
			
			$UserList = [];
			foreach ($userList as $key => $value) {

				$condition = "AND user_id = '{$value->user_id}'
							  AND account_type = '{$value->account_type}' 
							  AND DATE(created_at) = '{$date}'";

				$search1 = "{$sql} <= 1 {$condition }";
				$search2 = "{$sql} >= 1.1 and duration <= 2 {$condition }";
				$search3 = "{$sql} >= 2.1 and duration <= 3 {$condition }";
				$search4 = "{$sql} >= 3.1 and duration <= 4 {$condition }";
				$search5 = "{$sql} >= 4.1 and duration <= 5 {$condition }";
				$search6 = "{$sql} >= 5.1 and duration <= 6 {$condition }";

				$this->set_time_zone();
				$this->db->query(
	        		"SELECT ($search1) as search1, ($search2) as search2, ($search3) as search3,
					         ($search4) as search4, ($search5) as search5, ($search6) as search6
					  FROM `csr_timesheets` LIMIT 1 "
	        	);
	        	
	        	$report  = $this->db->single();

	        	$user_fullname;

	        	if($value->account_type == "manager")
                {
                  $user_fullname = $value->csr_manager;

                }else if($value->account_type = "user")
                {
                  $user_fullname = $value->csr_user;
                }

	        	$userObject = (object) [
					'user_id' => $value->user_id,
					'name'    => $user_fullname,
					'report' => $report 
    			];

    			array_unshift($UserList, $userObject);
			}

			return $UserList;
		}

	}