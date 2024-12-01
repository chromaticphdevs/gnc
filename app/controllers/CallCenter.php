<?php 	

	class CallCenter extends Controller
	{

		public function __construct()
		{
			$this->CallCenterModel = $this->model('CallCenterModel');
			$this->csrTimesheet = model('CSR_TimesheetModel');
		}

		public function index()
		{
			/*TEMPORARY filter*/

			$userid = $_GET['user'] ?? null;				

			$results = $this->csrTimesheet->getAll($userid);

			$grouped = [];

			foreach($results as $key => $row) {

				if( !isset($grouped[$row->user_id] ))
					$grouped[$row->user_id] = [];

				$grouped[$row->user_id][] = $row;
			}

			$data = [
				'grouped' => $grouped,
				'results' => $results
			];

			return $this->view('call_center/index' , $data);
		}

		public function make_call()
		{
			echo $this->CallCenterModel->call(unseal($_POST['userid']), $_POST['mobile'],unseal($_POST['call_by']));

			//return request()->return();
		}	

		public function end_call()
		{

			echo $this->CallCenterModel->end_call(unseal($_POST['userid']), $_POST['mobile']);

			return request()->return();
		}	

		public function get_number($device_id)
		{
			$data = $this->CallCenterModel->get_number($device_id);
		
			if(!empty($data))
			{	
				echo json_encode($data);
			}else
			{
				echo "";
			}
		}

		public function check_call_status($id)
		{
			$data = $this->CallCenterModel->check_call_status($id);
		
			if(!empty($data))
			{	
				echo json_encode($data);
			}else
			{
				echo "";
			}
		}

		public function select_device()
		{

			$this->CallCenterModel->select_device($_POST['device_selected']);

			return request()->return();
		}

	}