<?php 	

	class LDAttendanceModel extends Base_model
	{
		private $table_name = 'ld_individual_attendances';

		public function getAttendance($userid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name where userid = '$userid' ORDER BY `ld_individual_attendances`.`created_at` DESC"
			);
			return $this->db->resultSet();
		}


		public function getFirstTimer()
		{	
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$total = 0;

			$this->db->query("SELECT count(id) as instance from $this->table_name where `date`='$today' group by userid");

			$res = $this->db->resultSet();

			if($res) {
				foreach($res as $row)
				{
					if($row->instance == 1) {
						$total++;
					}
				}
			}

			return $total;
		}

		public function getRepeat()
		{	
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			$total = 0;
			$this->db->query("SELECT count(id) as instance from $this->table_name where `date`='$today' group by userid");

			$res = $this->db->resultSet();

			if($res) {
				foreach($res as $row)
				{
					if($row->instance > 1) {
						$total++;
					}
				}
			}

			return $total;
		}

		public function get_list_today()
		{

			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");

			$this->db->query(
				"SELECT  `date`, `time`, `day`, `groupid`, `userid` as userID, `is_late`, `notes`, `faceimage`, `created_at`,(Select CONCAT (firstname,' ',middlename,'. ',lastname) FROM ld_users WHERE id=userID) as fullname,(Select address FROM ld_users WHERE id=userID)  as user_address  FROM `ld_individual_attendances` WHERE `date`='$today' ORDER BY `time` DESC"
			);

			
			return $this->db->resultSet();
		}
	}