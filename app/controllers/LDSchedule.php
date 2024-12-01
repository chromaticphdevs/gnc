<?php 	

	class LDSchedule extends Controller
	{

		public function __construct()
		{
			$this->scheduleModel = $this->model('LDScheduleModel');
		}

		public function create_schedule()
		{
			if($this->request() === 'POST')
			{
				$result = $this->scheduleModel->create($_POST);

				if($result) {
					Flash::set("Schedule has been created!");
				}

				redirect("LDGroup/preview/?groupid={$_POST['groupid']}");
			}
		}

		public function update_schedule()
		{
			if($this->request() === 'POST')
			{
				$status = $_POST['status'];
				$scheduleid = $_POST['scheduleid'];

				switch($status)
				{
					case 'pending':
						$this->scheduleModel->update_schedule_status($scheduleid , 'pending');

						Flash::set("Schedule has been set to pending");
					break;

					case 'active':
						$result = $this->activate_schedule($scheduleid);

						Flash::set("Schedule has been activated");
						break;

					case 'finished':
						$this->scheduleModel->update_schedule_status($scheduleid , 'finished');

						Cookie::remove('scheduletoken');
						Flash::set("Schedule has been set to finished");
					break;
				}

				redirect("LDGroup/preview/?groupid={$_POST['groupid']}");
			}
		}

		private function activate_schedule($scheduleid)
		{	

			//finish current active schedule

			$result = $this->scheduleModel->update_schedules('finished');

			$result = 
				$this->scheduleModel->update_schedule_status($scheduleid , 'active');

			if($result) 
			{
				Flash::set("Schedule has been set");

				Cookie::set('scheduletoken' , $scheduleid);
			}

			return true;
		}
	}