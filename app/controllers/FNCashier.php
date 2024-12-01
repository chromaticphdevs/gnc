<?php

	class FNCashier extends Controller
	{

		public function __construct()
		{
			$this->FNCashierModel = $this->model('FNCashierModel');

		}

		public function get_cash_inventory_today()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

			}else{


				$data = [
                'result' => $this->FNCashierModel->get_cash_inventory_today($branchid)
           		];

	            $this->view('finance/cashier/cash_inventory',$data);
			}

		}

		public function get_cash_inventory_all()
		{
			$branchid = $this->check_session();

			$data = [
				'result' => $this->FNCashierModel->get_cash_inventory_all($branchid)
			];

			return $this->view('finance/cashier/cash_inventory',$data);
		}

		public function get_cash_inventory_limit_by_days()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{	

 				$result_explode = explode('|', $_POST['days']);
 				$days = $result_explode[0];
		        $selected = $result_explode[1];

				$data = [
					'result' => $this->FNCashierModel->get_cash_inventory_limit_by_days($branchid, $days),
					'selected' => $selected
				];

				return $this->view('finance/cashier/cash_inventory_limit_days',$data);

			}else{
				$data = [
					'result' => $this->FNCashierModel->get_cash_inventory_limit_by_days($branchid, '0'),
					'selected' => "Today"
				];

				return $this->view('finance/cashier/cash_inventory_limit_days',$data);
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
				$branchid = 8;
				return $branchid;

			}else{
				redirect('user/login');
			}
		}

	}
