<?php 	

	class LDScheduleAtendeeModel extends Base_model
	{

		private $table_name = 'ld_schedule_attendees';

		public function add_attendee($scheduleid , $userid)
		{

			$alreadyLoggedIn = $this->check_if_already_loggedin($scheduleid , $userid);

			if(!$alreadyLoggedIn)
			{
				$timeNow = date('h:i:s');
				$dateNow = date('Y-m-d');

				$isLate = $this->is_late($scheduleid , $timeNow);

				//if late

				$remarks = 'ontime';

				if($isLate){
					$remarks = 'late';
				}


				/*subquery for sched time and sched_Date*/

				$this->db->query(
					"INSERT INTO $this->table_name(userid , scheduleid , arrival_time , arrival_date ,
					sched_time , sched_date , remarks)

					SELECT '$userid' , '$scheduleid' , '$timeNow' , '$dateNow' , time , date , '$remarks'
					FROM ld_group_schedules where id = '{$scheduleid}'"
				);

				return $this->db->insert();

			}
			return true;
		}


		private function is_late($scheduleid , $time)
		{
			$scheduleModel = new LDScheduleModel();

			$schedule =  $scheduleModel->get_schedule($scheduleid);

			$timeDif = $this->differenceInHours($schedule->time ,$time);

			if($timeDif < 0) {
				return true;
			}

			return false;
		}

		private function differenceInHours($startdate,$enddate)
		{
			$starttimestamp = strtotime($startdate);

			$endtimestamp   = strtotime($enddate);

			$difference = ($endtimestamp - $starttimestamp) / 60;

			return $difference;
		}

		private function check_if_already_loggedin($scheduleid , $userid)
		{
			$data = [
				$this->table_name , 
				'*',
				"scheduleid = '{$scheduleid}' and userid = '{$userid}'"
			];

			return $this->dbHelper->single(...$data);
		}

		/***/

		public function get_list($scheduleid)
		{
			$data = [
				$this->table_name , 
				'*',
				" scheduleid = '{$scheduleid}'"
			];

			return $this->dbHelper->resultSet(...$data);
		}
	}