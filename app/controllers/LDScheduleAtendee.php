<?php 	

	class LDScheduleAtendee extends Controller
	{


		public function __construct()
		{
			$this->scheduleModel = $this->model('LDScheduleModel');
			$this->attendeeModel = $this->model('LDScheduleAtendeeModel');
			$this->groupModel = $this->model('LDGroupModel');
		}
		public function get_list()
		{

			$this->userModel = $this->model('LDUserModel');

			if(isset($_GET['scheduleid']))
			{
				$scheduleid = $_GET['scheduleid'];

				$scheduleDetail = $this->scheduleModel->get_schedule($scheduleid);

				$groupDetail    = $this->groupModel->get_group($scheduleDetail->groupid);

				$data = [
					'title' => 'Attendees' , 

					'schedule' => [
						'detail' => $scheduleDetail , 
						'attendeeList'   => $this->attendeeModel->get_list($scheduleid)
					],

					'user'  => [
						'onbranch' => $this->userModel->get_by_branch($groupDetail->branchid)
					],

					'groupinfo'    => $this->groupModel->get_group($scheduleDetail->groupid)
				];

				if(isset($_GET['getuser']) && $_GET['user'] == 'all')
				{
					$data['user']['all'] = $this->userModel->get_list();
				}
				
				$this->view('lending/schedule/list' , $data);
			}
		}
	}