<?php 	

	class Employee extends Controller
	{

		private $truncator = 'truncate user_emp_log_pictures; truncate user_emp_logs ; truncate user_emp_action_logs;';

		public function __construct()
		{
			$this->load_model('employee_model' , 'emp_model');
		}

		public function loginCapture()
		{
			//no security
			if(isset($_GET['empid']))
			{
				$data = [
					'empid' => trim($_GET['empid'])
				];
				$this->view('employee/capture' , $data);
			}
		}

		public function logout()
		{
			$this->emp_model->logout($_POST['logid']);
		}
		public function login()
		{
			// $this->emp_model->login();
			if($this->request() === 'POST')
			{
				$userid = $_POST['userid'];

				$res = $this->emp_model->login(['userid'=>$userid] , $rawImage = $_POST['image']);

				echo json_encode($res);
			}else
			{
				$this->view('employee/login');
			}
		}
		
		public function create()
		{
			if($this->request() === 'POST')
			{
				$this->emp_model->create($_POST);
			}else
			{
				$data = [
					'basicRate' => 71
				];

				$this->view('employee/create' , $data);
			}
		}


		public function getSecret()
		{
			$res = $this->emp_model->get_password($_POST['secret']);

			if($res)
			{
				redirect('employee/loginCapture/?empid='.$res->id);
			}else
			{
				Flash::set(' NO USER FOUND ' , 'warning');

				redirect('employee/login');
			}
		}

		public function edit()
		{

		}

		public function preview()
		{

		}

		public function list()
		{
			$data = [
				'emp_list' => $this->emp_model->get_list()
			];

			$this->view('employee/list' , $data);
		}
	}