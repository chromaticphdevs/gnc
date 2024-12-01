<?php 	

	class LDGroup extends Controller
	{

		public function __construct()
		{
			$this->branchModel = $this->model('LDBranchModel');

			$this->groupModel  = $this->model('LDGroupModel');
		}


		public function group_list()
		{

			$data = [
				'title' => 'Group List',
				'groupList' =>  $this->groupModel->get_list()
			];

			$this->view('lending/groups/list' , $data);
		}
		public function create_group()
		{
			if($this->request() === 'POST') 
			{
				$result = $this->groupModel->create($_POST);

				if($result) 
				{
					Flash::set("Group {$_POST['group_name']} has been created");

					redirect("LDGroups/preview/?groupid={$result}");
				}	
			}else{

				$data = [
					'title' => 'Groups' ,
					'branchList' => $this->branchModel->get_list(),
					'groupList'  => $this->groupModel->get_list()
				];

				$this->view('lending/groups/create' , $data);
			}
		}

		public function preview()
		{
			if(!isset($_GET['groupid']))
			{
				die("Incorrect Request");
				return false;
			}

			$this->scheduleModel = $this->model('LDScheduleModel');

			$groupid = $_GET['groupid'];

			$data = [	
				'groupid' => $groupid,
				
				'group' => [
					'detail'    => $this->groupModel->get_group($groupid),
					'schedules' => $this->scheduleModel->get_list($groupid)
				],
				'scheduleStatus' => [
					'pending' , 'active' , 'finished'
				]
			]; 
			
			$this->view('lending/groups/view' , $data);
		}
	}