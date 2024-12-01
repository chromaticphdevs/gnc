<?php 	

	class TkReport
	{
		private $db;
		
		public function __construct()
		{
			$this->db = new Database();
		}

		public function getReport($reportDate , $users_list)
		{
			return $this->getDateAttendance($reportDate , $users_list);
		}

		public function getDateAttendance($date , $users_list)
		{

			$dateSets = $this->getDateRange($date['start'] , $date['end']);
			
			$attendanceLog = array();
			foreach($users_list as $user)
			{
				$attendanceLog[$user->empid]['emp'] = array(
					'firstname' => $user->firstname , 'lastname' => $user->lastname
				);
				$attendanceLog[$user->empid]['rate'] = $user->hourly_rate;
				$attendanceLog[$user->empid]['presents'] = array();
				$attendanceLog[$user->empid]['absenses'] = array();
				$attendanceLog[$user->empid]['loglist'] = array();


				foreach($dateSets as $date)
				{
					$this->db->query("SELECT id FROM user_emp_logs where userid = '$user->id' and 
					date(dt) = CAST('$date' as DATE) order by id desc limit 1");

					if($res = $this->db->single())
					{
						$attendanceLog[$user->empid]['presents'][] = $date;
						$attendanceLog[$user->empid]['loglist'][]  = $res->id;
					}else
					{
						$attendanceLog[$user->empid]['absenses'][] = $date;
					}
				}
			}

			$workHourLog = $this->getWorkHours($attendanceLog);

			$computeWorkHours = $this->computeWorkHours($workHourLog);

			return $this->computeSalary($computeWorkHours);
		} 

		public function getWorkHours($attendanceLog)
		{
			
			foreach($attendanceLog as $userid => $userAttendanceLog)
			{
				$attendanceLog[$userid]['workHours'] = array();

				foreach($userAttendanceLog['loglist'] as $logid)
				{
					$this->db->query("SELECT * , time(dt) as dtime FROM user_emp_action_logs where emp_logsid = '$logid'");
					
					$res = $this->db->resultSet();

					$duration = $this->setDuration();

					$attendanceLog[$userid]['workHours'][] = $this->extractTime($res);
				}	
			}

			return $attendanceLog;
		}
		//append this after using getworkhour logs
		private function computeWorkHours($workHoursLog)
		{
			foreach($workHoursLog as $userid => $userLog)
			{
				$duration = 0;
				foreach($userLog['workHours'] as $workDuration)
				{
					//if work duration is not null do computation
					if(! is_null($workDuration->timein))
					{
						//explode timein
						$explodeTime = explode(':',$workDuration->timein);
						//generate time
						$timein = mktime($explodeTime[0] , $explodeTime[1] , $explodeTime[2]);

						//work timeout is not null
						if(! is_null($workDuration->timeout))
						{
							$explodeTime = explode(':',$workDuration->timeout);
							$timeout = mktime($explodeTime[0] , $explodeTime[1] , $explodeTime[2]);

							//first instance do this
							if($duration == 0)
							{	
								$duration = $timeout - $timein;
							}else
							{
								//another pair matched then compute
								//set new duration variable
								$duration = $duration + ($timeout - $timein);
								// $duration    = $newDuration + (time());
							}
						}
					}
				}

				if($duration <= 0)
				{
					$workHoursLog[$userid]['totalWorkHours'] = 0;
				}else
				{
					// $duration = $duration + time();
					//check if time is > than 1hr
					$oneHour = mktime(1,0,0);
					$duration = abs($duration);
					$totalWorkHours;

					if($duration > $oneHour )
					{
						$totalWorkHours = date('H:i:s' , $duration);
					}else
					{
						$totalWorkHours = date('i:s' , $duration);
					}
					$workHoursLog[$userid]['totalWorkHours'] = $totalWorkHours;
				}

				
			}
			
			return $workHoursLog;
		}

		private function computeSalary($computedWorkHours)
		{
			foreach($computedWorkHours as $userid => $workHours)
			{
				$explodeTime = explode(':',$workHours['totalWorkHours']);
				$hourToMin   = $explodeTime[0] <= 0 ? 0: $explodeTime[0] * 60;
				$min         = isset($explodeTime[1]) ? $explodeTime[1] : 0;
				$ratePerMinute = $workHours['rate'] == null ? 0 : $workHours['rate'] / 60;

				$computedWorkHours[$userid]['salary'] = ($hourToMin + $min) * $ratePerMinute;
			}

			return $computedWorkHours;	
		}
		private function extractTime($res)
		{
			$timein  = null;
			$timeout = null;
			foreach($res as $row)
			{
				if($row != null && $row->action == 'timein')
				{
					$timein = $row->dtime;
				}else if($row != null && $row->action =='timeout')
				{
					$timeout = $row->dtime;
				}
			}

			return $this->setDuration($timein , $timeout);
		}
		private function setDuration($timein = null , $timeout = null)
		{
			$duration = new stdClass();
			$duration->timein  = $timein;
			$duration->timeout = $timeout;

			return $duration;
		}
		
		private function getDateRange($start, $end, $format = 'Y-m-d') 
		{ 
	      
		    // Declare an empty array 
		    $array = array(); 
		      
		    // Variable that store the date interval 
		    // of period 1 day 
		    $interval = new DateInterval('P1D'); 
		  
		    $realEnd = new DateTime($end); 
		    $realEnd->add($interval); 
		  
		    $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
		  
		    // Use loop to store date into array 
		    foreach($period as $date) {                  
		        $array[] = $date->format($format);  
		    } 
		  
		    // Return the array elements 
		    return $array; 
		} 

		// private function setAttendanceLog($key , $value)
		// {

		// }
	}