<?php 	

	class CSR_TimesheetModel extends Base_model
	{

		public $table = 'csr_timesheets';
		/*
		*time rendered on calling the customer
		*/
		public function save($userId , $customerId , $durationInMinutes, $account_type )
		{

            $today = today();
			/*
			*Temporary fix
			*/
			$userRate = 1000;

			if(  isEqual($account_type , 'user')) 
				$userRate = 1000;
			/*
			*change code and connect rates to individual users.
			*/

			
			$workHours = 12;
			$salaryPerHour = $userRate / $workHours;

			$callIncome = $this->computeSalaryWithDuration($salaryPerHour , $durationInMinutes);


			if($durationInMinutes > 5)
				$callIncome = $this->computeSalaryWithDuration( $salaryPerHour , 5);


			$userdata = $this->get_csr_info($userId, $account_type );

			$phoneNumber = $userdata->mobile;
           
            $content = "You earned PHP: ". number_format($callIncome, 2)."breakthrough-e.com";

          	$sendSmsData = [
            	'mobile_number' => $phoneNumber,
            	'content'      => $content,
            	'category' => 'SMS'
          	];

	        //send sms
	        $sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $sendSmsData);
	        //$sms = json_decode($sms); 

			return parent::store([
				'user_id' => $userId,
				'customer_id' => $customerId,
				'amount' => floatval($callIncome),
				'rate'   => $userRate,
				'work_hours' => $workHours,
				'duration' => $durationInMinutes,
				'account_type' => $account_type,
                'created_at'  => $today
			]);

		}

		//temporary filter
		public function getAll($userid = null)
		{
			$where = null;

			if(! is_null($userid))
				$where = " WHERE user_id = '$userid' ";

			$this->db->query(
				"SELECT user_id , amount , duration , rate , work_hours ,
					user.firstname , user.lastname

					FROM {$this->table} as csr 
					LEFT JOIN users as user 
					ON user.id = user_id

					$where"
			);

			return $this->db->resultSet();
		}

		public function computeSalaryWithDuration($salaryPerHour , $durationInMinutes)
        {   
            return ($salaryPerHour / 60) * $durationInMinutes;
        }


        /*
        *Deprecated
        *getTotalAmount <-new and stable
        */
        public function getTotal($userId)
        {
        	$this->db->query(
        		"SELECT sum(amount) as total 
        			FROM $this->table
        			WHERE user_id = '$userId' "
        	);

        	return $this->db->single()->total ?? 0;
        }


        public function getTotalAmount($userId , $userType)
        {
        	$this->db->query(
        		"SELECT sum(amount) as total 
        			FROM $this->table
        			WHERE user_id = '$userId' 
        			AND account_type = '$userType' "
        	);

        	return $this->db->single()->total ?? 0;
        }
        
 		public function get_call_history($userId, $account_type)
        {
        	$profilling = "SELECT CONCAT('Source Income:',source_income,'<br>Income:',income,'<br>House Rental:',house_rental,'<br>Dependents:',dependents,'<br>Rice Consumption:',rice_consumption) FROM `user_profiling` WHERE userid = `csr_timesheets`.`customer_id`  AND process_by = `csr_timesheets`.`user_id`  ORDER BY `user_profiling`.`updated_at` DESC LIMIT 1";

        	$this->db->query(
        		"SELECT *,
        		(SELECT CONCAT(firstname,' ', lastname) FROM users WHERE id = `csr_timesheets`.`customer_id` ) as customer_name,
        		({$profilling}) as profile
        		FROM `csr_timesheets` WHERE `user_id` = '{$userId}' AND account_type = '$account_type' ORDER BY `id` DESC"
        	);
        
        	$data = $this->db->resultSet();

        	return $data;
        }


        public function get_csr_info($userId , $type)
        {
        	$table = "fn_accounts";
        	$sql = "SELECT * FROM";
        	$condition = "WHERE id = {$userId}";

        	if(isEqual( $type , 'user'))
        	{
        		$table = "users";
        	}

        	$sql = $sql." ".$table." ".$condition;

        	$this->db->query($sql);

        	return $this->db->single();
        }
        
        
        public function calledToday($userId)
        {
            $today = today();

            $this->db->query(
                "SELECT tsheet.* 
                    FROM {$this->table} as tsheet

                    LEFT JOIN user_on_call as u_call
                    ON u_call.user_id = tsheet.customer_id

                    WHERE customer_id = '$userId'
                    AND date(tsheet.created_at) = date('$today')
                    OR date(u_call.created_at) = date('$today')
                    or u_call.user_id = '$userId'"
            );

            return  $this->db->single();
        }
        
        public function getUserTotal($userId)
        {
            $this->db->query(
                "SELECT SUM(amount) as amount_total
                    FROM {$this->table} 
                    WHERE user_id = '$userId'
                    AND account_type = 'user' "
            );

            return $this->db->single()->amount_total ?? 0;
        }

        public function getStaffTotal($userId)
        {
            $this->db->query(
                "SELECT SUM(amount) as amount_total
                    FROM {$this->table} 
                    WHERE user_id = '$userId'
                    AND account_type = 'manager' "
            );

            return $this->db->single()->amount_total ?? 0;
        }

        
	}