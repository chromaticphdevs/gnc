<?php 	

	class LDScheduleModel extends Base_model
	{
		private $table_name = 'ld_group_schedules';
		
		public function create($scheduleInfo)
		{
			extract($scheduleInfo);

			$data = [
				$this->table_name,
				[
					'groupid'    => $groupid,
					'date'       => $date , 
					'time'       => $time ,
					'grace_time' => $this->format_grace_time($grace_time)
				]
			];


			$this->dbHelper->insert(...$data);
		}
		
		public function get_list($groupid)
		{
			$data = [
				$this->table_name ,
				'*',
				null,
				'date asc'
			];

			return $this->dbHelper->resultSet(...$data);
		}

		public function get_schedule($scheduleid)
		{
			$data = [
				$this->table_name ,
				'*',
				"id = '{$scheduleid}'",
				'date asc'
			];

			return $this->dbHelper->single(...$data);
		}

		public function format_grace_time(array $grace_time)
		{	
			extract($grace_time);

			return "$hour:$min:$sec";
		}

		public function update_schedule_status($scheduleid , $status)
		{
			$data = [
				$this->table_name ,
				[
					'status' => $status
				],
				"id = '{$scheduleid}'"
			];

			return $this->dbHelper->update(...$data);
		}

		public function update_schedules($status)
		{
			$data = [
				$this->table_name , 
				[
					'status' => $status
				]
			];

			return $this->dbHelper->update(...$data);
		}
	}