<?php 	

	class LDCashier extends Controller
	{	

		public function __construct()
		{
			$this->productLoanModel = $this->model('LDProductLoanModel');	
			$this->cashloanModel = $this->model('LDCashLoanModel');
			$this->UserModel = $this->model('LDUserModel');
			$this->ActivationModel = $this->model('LDActivationModel');
		}

		public function index()
		{
			
			$user   = Session::get('user');
			$userId = $user['id'];
			$branchId = $user['branch_id'];
	
				$data = [

					'cash_payments_today' => $this->cashloanModel->payment_list_today_cashier($userId),
					'product_payments_today' => $this->productLoanModel->payment_list_today_cashier($userId),
					'branch_activation_lvl' => $this->ActivationModel->activation_level_branch($branchId)

				];

				$this->view('lending/cashier/index', $data);

		}

		public function attendance_check(){

			if(! Session::check('cashier_check_attendance')){
				unAuthorize();
			}

			$data = [
				'userData' => Session::get('cashier_check_attendance')
			];

			$this->view('lending/cashier/attendance_check' , $data);

		}

	}


