
<?php 	

	class ChartsModel extends Base_model
	{


		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function get_daily_registration()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(username) FROM users WHERE account_tag = 'main_account' and DATE(created_at) = '$date') as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}
			}
			
			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());

			
		}

		public function get_registration_count_by_time()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";

			$time_start = '00:00:00';
			

			for($hour = 0; $hour <= 23; $hour++ )
			{
				
				$time = date('h a',strtotime('+'.$hour.' hour',strtotime($time_start)));

				$sql .= "(SELECT COUNT(username) FROM users WHERE account_tag = 'main_account' and HOUR(created_at) = '$hour') as count".$hour.", ('$time ') as time".$hour."";

				if($hour != 23)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);
			echo json_encode($this->db->single());
			
		}

		public function get_registration_count_by_week()
		{

			$sql = "SELECT ";
		
			$activationLevels = [
				'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday', 'Sunday'
			];

			for($day = 0; $day <= 6; $day++ )
			{
				$day_name = $activationLevels[$day];

				$sql .= "(SELECT COUNT(username) FROM users WHERE account_tag = 'main_account' AND WEEKDAY(created_at) = '$day') as count".$day.", ('$day_name ') as day".$day."";

				if($day != 6)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();
			$this->db->query($sql);
			echo json_encode($this->db->single());
		}



		
		//login graph----------------------------------------------------------
		public function get_daily_login()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(userid) FROM user_login_logger WHERE DATE(date_time) = '$date' ) as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		public function get_login_count_by_time()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";

			$time_start = '00:00:00';
			

			for($hour = 0; $hour <= 23; $hour++ )
			{
				
				$time = date('h a',strtotime('+'.$hour.' hour',strtotime($time_start)));

				$sql .= "(SELECT COUNT(userid) FROM user_login_logger WHERE HOUR(date_time) = '$hour') as count".$hour.", ('$time ') as time".$hour."";

				if($hour != 23)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);
			echo json_encode($this->db->single());
			
		}

		public function get_login_count_by_week()
		{

			$sql = "SELECT ";
		
			$activationLevels = [
				'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday', 'Sunday'
			];

			for($day = 0; $day <= 6; $day++ )
			{
				$day_name = $activationLevels[$day];

				$sql .= "(SELECT COUNT(userid) FROM user_login_logger WHERE WEEKDAY(date_time) = '$day') as count".$day.", ('$day_name ') as day".$day."";

				if($day != 6)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();
			$this->db->query($sql);
			echo json_encode($this->db->single());
		}



		//Activation graph----------------------------------------------------------

		public function get_daily_activation()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(users.id) 
						 FROM users INNER JOIN fn_off_code_inventories as fn_code 
						 WHERE fn_code.userid = users.id AND users.status != 'pre-activated' 
						 AND DATE(fn_code.created_at) = '$date' AND fn_code.status = 'used' ) as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();
	
			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		public function get_activation_count_by_week()
		{

			$sql = "SELECT ";
		
			$activationLevels = [
				'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday', 'Sunday'
			];

			for($day = 0; $day <= 6; $day++ )
			{
				$day_name = $activationLevels[$day];

				$sql .= "(SELECT COUNT(users.id)
						 FROM users INNER JOIN fn_off_code_inventories as fn_code 
						 WHERE fn_code.userid = users.id AND users.status != 'pre-activated' 
						 AND WEEKDAY(fn_code.created_at) = '$day' AND fn_code.status = 'used') as count".$day.", ('$day_name ') as day".$day."";
				if($day != 6)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();
			$this->db->query($sql);
			echo json_encode($this->db->single());
		}


		public function get_activation_count_by_time()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";

			$time_start = '00:00:00';
			

			for($hour = 0; $hour <= 23; $hour++ )
			{
				
				$time = date('h a',strtotime('+'.$hour.' hour',strtotime($time_start)));

				$sql .= "(SELECT COUNT(users.id)
						 FROM users INNER JOIN fn_off_code_inventories as fn_code 
						 WHERE fn_code.userid = users.id AND users.status != 'pre-activated' 
						 AND HOUR(fn_code.created_at) = '$hour' AND fn_code.status = 'used') as count".$hour.", ('$time ') as time".$hour."";

				if($hour != 23)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);
			echo json_encode($this->db->single());
			
		}	

		//cash collection graph----------------------------------------------------------

		public function get_daily_cash_collection()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT SUM(amount) FROM fn_product_release_payment WHERE status='Approved' AND DATE(date_time) = '$date' ) as count".$days.", ('$date2') as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		public function get_cash_collection_count_by_time()
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";

			$time_start = '00:00:00';
			

			for($hour = 0; $hour <= 23; $hour++ )
			{
				
				$time = date('h a',strtotime('+'.$hour.' hour',strtotime($time_start)));

				$sql .= "(SELECT SUM(amount) FROM fn_product_release_payment WHERE status='Approved' AND HOUR(date_time) = '$hour') as count".$hour.", ('$time ') as time".$hour."";

				if($hour != 23)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);
			echo json_encode($this->db->single());
			
		}	



		//product released chart------------------------------------------------------------------------------------------------------

		public function get_daily_product_released($branchid, $category)
		{	
			$condition = "";
			if($branchid != 'ALL')
			{
				$condition = "and branchid = $branchid";
			}

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(*) FROM fn_product_release WHERE status != 'Deny' {$condition} and category = '$category' and
						  DATE(date_time) = '$date') as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}
			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}

		public function get_product_released_count_by_time($branchid)
		{
			$condition = "";
			if($branchid != 'ALL')
			{
				$condition = "and branchid = $branchid";
			}

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";

			$time_start = '00:00:00';
			

			for($hour = 0; $hour <= 23; $hour++ )
			{
				
				$time = date('h a',strtotime('+'.$hour.' hour',strtotime($time_start)));

				$sql .= "(SELECT COUNT(*) FROM fn_product_release WHERE status != 'Deny' {$condition} and HOUR(date_time) = '$hour') as count".$hour.", ('$time ') as time".$hour."";

				if($hour != 23)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();

			$this->db->query($sql);
			echo json_encode($this->db->single());
			
		}

		public function get_product_released_count_by_week($branchid)
		{	
			$condition = "";
			if($branchid != 'ALL')
			{
				$condition = "and branchid = $branchid";
			}

			$sql = "SELECT ";
		
			$activationLevels = [
				'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday', 'Sunday'
			];

			for($day = 0; $day <= 6; $day++ )
			{
				$day_name = $activationLevels[$day];

				$sql .= "(SELECT COUNT(*) FROM fn_product_release WHERE status != 'Deny' {$condition} AND WEEKDAY(date_time) = '$day') as count".$day.", ('$day_name ') as day".$day."";

				if($day != 6)
				{
					$sql .= ", ";
				}

			}

			$this->set_time_zone();
			$this->db->query($sql);
			echo json_encode($this->db->single());
		}



		// daily  DS of user
		public function get_daily_user_direct_sponsor($userid)
		{

			date_default_timezone_set('Asia/Manila');

			$sql = "SELECT ";


			for($days = 29; $days >= 0; $days-- )
			{
				
				$date = date("Y-m-d",strtotime("-".$days." day"));
				$date2 = date("M/d/Y",strtotime("-".$days." day"));

				$sql .= "(SELECT COUNT(username) FROM users WHERE account_tag = 'main_account' and direct_sponsor='$userid'  and DATE(created_at) = '$date') as count".$days.", CONCAT('$date2',' ',DAYNAME('$date')) as date".$days."";

				if($days != 0)
				{
					$sql .= ", ";
				}
			}

			$this->set_time_zone();

			$this->db->query($sql);

			echo json_encode($this->db->single());
			
		}






	}