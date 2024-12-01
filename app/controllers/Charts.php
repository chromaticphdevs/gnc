<?php 	

	class Charts extends Controller
	{

		public function __construct()
		{

			$this->ChartsModel = $this->model('ChartsModel');
		}

		public function registration_graph()
		{
			Authorization::setAccess(['admin']);

			$this->view('charts/registration_line_graph');
		}


		public function stock_chart()
		{
			$branchid = $this->check_session();
			$this->view('charts/stock_manager_chart');
		}



		public function data_registration_line_graph()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_daily_registration();

			}
		}

		public function get_registration_count_by_week()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_registration_count_by_week();

			}
			
		}

		public function data_registration_count_by_time_bar_graph()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_registration_count_by_time();

			}
		
		}


		//login graph----------------------------------------------------------

		public function login_graph()
		{
			Authorization::setAccess(['admin']);

			$this->view('charts/login_graph');

		}


		public function login_graph_data()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_daily_login();
			}


		}

		public function data_login_count_by_week()
		{	
			if($this->request() === 'POST')
			{	
				 $this->ChartsModel->get_login_count_by_week();
			}
		
		}		

		public function data_login_count_by_time_bar_graph()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_login_count_by_time();
			}
		
		}


		//Activation graph----------------------------------------------------------

		public function activation_graph()
		{
			Authorization::setAccess(['admin']);

			$this->view('charts/activation_graph');

		}


		public function activation_graph_data()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_daily_activation();
			}


		}
		
		
		public function get_activation_count_by_week()
		{	
			if($this->request() === 'POST')
			{	
				 $this->ChartsModel->get_activation_count_by_week();
			}
		
		}	

		public function data_activation_count_by_time_bar_graph()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_activation_count_by_time();

			}
		
		}

		//Cashier Collection---------------------------------------------------------------------------------------------------------

		public function cash_collection_graph()
		{
			Authorization::setAccess(['admin']);

			$this->view('charts/cash_collection_graph');
		}


		public function cash_collection_graph_data()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_daily_cash_collection();
			}


		}

		

		public function cash_collection_by_time_bar_graph()
		{	
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_cash_collection_count_by_time();

			}
		}


		//Product released graph----------------------------------------------------------

		public function product_released_graph_data()
		{	
			$branchid = $this->check_session();
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_daily_product_released($branchid,$_POST['category']);
			}
		}
		
		
		
		public function get_product_released_count_by_week()
		{	
			$branchid = $this->check_session();
			if($this->request() === 'POST')
			{	
				 $this->ChartsModel->get_product_released_count_by_week($branchid);
			}	
		}	

		public function data_product_released_count_by_time_bar_graph()
		{	
			$branchid = $this->check_session();
			if($this->request() === 'POST')
			{	
				$this->ChartsModel->get_product_released_count_by_time($branchid);
			}	
		}



		//user charts -----------------------------------------------------------------------

		public function user_charts()
		{
			Authorization::setAccess(['users']);

			$this->view('charts/user_charts');
		}

		public function user_DS_daily()
		{	
			if($this->request() === 'POST')
			{	

				if(Session::check('USERSESSION'))
				{
					$userid = Session::get('USERSESSION')['id'];

					$this->ChartsModel->get_daily_user_direct_sponsor($userid);
				}

			}
		}


		private function check_session()
		{

			if(Session::check('BRANCH_MANAGERS'))
			{
				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;
				return $branchid;

			}else if(Session::check('USERSESSION'))
			{
				$branchid = "ALL";
				return $branchid;

			}else{
				redirect('user/login');
			}
		}
		

	}