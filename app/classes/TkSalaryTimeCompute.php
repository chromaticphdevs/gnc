<?php 	

	class TkSalaryTimeCompute
	{
		private 
		$rate , $timein , $timeout;

		private 
		$duration , $salary;

		public function setRate($rate)
		{
			$this->rate = $rate;
			return $this;
		}

		public function setTimein($timein)
		{
			$this->timein = $timein;
			return $this;
		}

		public function setTimeout($timeout)
		{
			$this->timeout = $timeout;
			return $this;
		}

		public function setLogDate($logDate)
		{
			$this->logDate = $logDate;
			return $this;
		}
		private function computeSalary()
		{
			$timein = $this->timeToMinutes($this->timein);
			$timeout   = $this->timeToMinutes($this->timeout);
			//compute total mins

			$this->duration = $totalMinutes = $timeout - $timein;
			//hourly rate to tomin

			$rateToMins = ($this->rate / 60);

			$this->salary = $rateToMins * $totalMinutes;
		}

		private function timeToMinutes($time)
		{
			//explode time to seperate hour , mins and seconds

			$timeProp = explode(':' , $time);

			$hourToMin = $timeProp[0] * 60;

			$concatMinutes = $hourToMin+$timeProp[1];

			return $concatMinutes;
		}
		

		public function getComputation()
		{

			$this->computeSalary();

			return [
				'logDate'   => $this->logDate,
				'timein'    => $this->timein,
				'timeout'   => $this->timeout,
				'rate'      => $this->rate,
				'duration'  => $this->minsToTime($this->duration),
				'salary'    => $this->salary
			];
		}

		private function minsToTime($minutes)
		{
			$mintoHours = floor($minutes / 60);
			$extraMins  = abs($minutes % 60);


			return "{$mintoHours} hrs , $extraMins mins";
		}
	}