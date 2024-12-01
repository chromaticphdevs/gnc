<?php

	class FNCashAdvancePayment extends Controller
	{

		private $account_types = [
			'stock-manager' , 'cashier' , 'branch-manager','cashier-assistance'
		];

		public function __construct()
		{
			$this->CashAdvancePaymentModel   = $this->model('FNCashAdvancePaymentModel');
			$this->CashAdvanceModel          = $this->model('FNCashAdvanceModel');
			$this->cashInventoryModel        = $this->model('FNCashInventoryModel');
			$this->mgPayoutModel             = $this->model('MGPayoutModel');
			$this->userModel                 = $this->model('User_model');
			$this->User_Account_Model        = $this->model("UserAccountModel");
			$this->mgPayoutItemModel         = $this->model('MGPayoutItemModel');

			$this->pera = model('BankPeraModel');
		}


		public function index()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				 $user = Session::get('BRANCH_MANAGERS');
				 $branchid = $user->branchid;
				 $user_id = $user->id;

			}else if(Session::check('USERSESSION'))
			{
				$branchid = 8;
				$user_id = 1;
			}

			$payments = $this->CashAdvancePaymentModel->getByBranch($branchid);

			$data = [
				'payments' => $payments
			];

			return $this->view('finance/cash_advance_payment/index' , $data);
		}

		public function show($id)
		{
			$paymentid = unseal($id);

			$data = [
				'payment' => $this->CashAdvancePaymentModel->dbget($paymentid)
			];

			return $this->view('finance/cash_advance_payment/show' , $data);
		}

		/* CUSTOMER MAKING PAYMENT */
		public function customer_payment()
		{
			$user_id = Session::get('USERSESSION')['id'];

			/*
			*loan_id is id from fn_cash_advances
			*/
			$loan_id = $_GET['loan_id'];

			$user = $this->userModel->get_user($user_id);
			$userCashPayment = new FNCashAdvancePaymentUserModel($user_id,$loan_id);
			$userCashAdvance = new FNCashAdvanceUserModel($user_id,$loan_id);
			$userEarning = new UserEarningModel($user_id);

			$peraAccount = $this->pera->getByUser($user_id);


			$data = [
				'title' => 'Customer Payment',
				'user'  => [
					'balance'  => $userCashAdvance->getBalance(),
					'payments' => $userCashPayment->getTotal(),
					'totalCashAdvance' => $userCashAdvance->getTotal(),
					'totalEarning' => $userEarning->getAvailable(),
					'payments_history' => $userCashPayment->getPaymentHistory(),
					'info' => $user
				],
				'pera' => $peraAccount, 
				'peraAuth' => THIRD_PARTY['pera']['business_auth'],
				'loan_id' => $loan_id
			];
			return $this->view('finance/cash_advance_payment/customer_payment' , $data);
		}


		/* CUSTOMER MAKING PAYMENT PAY BY EARNINGS*/
		public function payByEarning()
		{
			$commissionTransactionModel = $this->model('CommissionTransactionModel');

			$post = request()->inputs();

			$user = $this->userModel->get_user($post['user_id']);

			$amount = preg_replace("/a-Z -_@/" , '' , $post['amount']);

			if(!is_numeric($amount)) {
				Flash::set("Amount must be a valid number" , 'danger');
				return request()->return();
			}

			//check if available earning is ok with balance

			if($amount > $post['total_earning']) {
				Flash::set("Insuficient funds" , 'danger');
				return request()->return();
			}

			// if($amount < $post['total_earning']) {
			// 	Flash::set("You are paying too much" , 'warning');
			// 	return request()->return();
			// }

			$imageName = $image['result']['name'];

			$code = $this->CashAdvancePaymentModel->make_code();


			if(Session::check('BRANCH_MANAGERS'))
			{
				 $user       = Session::get('BRANCH_MANAGERS');
				 $branchid   = $user->branchid;
				 $cashier_id = $user->id;

			}else if(Session::check('USERSESSION'))
			{
				$branchid = 8;
				$cashier_id = 1;
			}

			/*
			*7/4/2020
			*Loan ID Added
			*/
			$payment = $this->CashAdvancePaymentModel->store([
				'userid'     => $post['user_id'],
				'loanid'     => $post['loan_id'],
				'code'       => $code,
				'amount'     => $amount,
				'path'       => 'ca_payments',
				'cashier_id' => $cashier_id,
				'branch_id'  => $user->branchId,
				'category'   => $this->CashAdvancePaymentModel::$category[1]
			]);

			/*Add deduction to total earnings*/
			$commissionTransactionModel->store([
				'userid' => $post['user_id'],
				'type'   => $this->CashAdvancePaymentModel::$forPaymentName,
				'amount' => (-1) * $amount,
				'date'   => today(),
				'origin' => $code
			]);

			/*INSERT LOGS*/
			$logs = $this->cashInventoryModel->make_cash([
				'branchid' => $user->branchId,
				'amount'   => $amount,
				'description' => "Cash Advance Payment code $code , Payment by : <b>{$user->fullname}</b> using Available earnings"
			]);

			/*UPDATE CASH ADVANCE REQUEST*/
			$userCashAdvance = new FNCashAdvanceUserModel($post['user_id'],null);

			/*CHECK IF USER HAS NO OUTSTANDING BALANCE*/
			if($userCashAdvance->getBalance() <= 0) {
				/*UPDATE ALL USERS CASH ADVANCE REQUEST TO PAID*/
				$this->CashAdvanceModel->setAllApprovedToPaid($post['user_id']);
			}


			if($payment && $logs) {
				Flash::set("Payment saved");
				return redirect("users");
			}else{
				die("Something went wrong");
			}
		}


		public function code_payment_list($amount)
		{
			$userid = Session::get('USERSESSION')['id'];

			if($this->request() === 'POST')
			{


			}else{

				$codes_unused = $this->CashAdvancePaymentModel->get_unused_code_by_user($userid);

				if(empty($codes_unused))
				{
					$result = $this->CashAdvancePaymentModel->create_payment_code($userid, $amount);
					if($result)
					{
						Flash::set("Payment Codes Generated Successfully");
						redirect('FNCashAdvancePayment/code_payment_list');
					}

				}

				$data = [
					'title'       => 'Code List For Payment',
					'codes_unused' =>  $codes_unused,
					'codes_used' => $this->CashAdvancePaymentModel->get_used_code_by_user($userid),
					'balance' => $this->CashAdvanceModel->get_balance_by_user($userid)
				];

				return $this->view('finance/cash_advance/code_payment' , $data);
			}
		}

		/* ADMIN MAKING PAYMENT ACTION */
		public function store()
		{
			$post = request()->inputs();
			$pathUpload = path_upload('ca_payments');


			if(Session::check('BRANCH_MANAGERS'))
			{
				 $user = Session::get('BRANCH_MANAGERS');
				 $branchid = $user->branchid;
				 $user_id = $user->id;

			}else if(Session::check('USERSESSION'))
			{
				$branchid = 8;
				$user_id = 1;
			}

			$user = $this->userModel->get_user($user_id);

			// $image = upload_image('payment_picture' , $pathUpload);

			$amount = preg_replace("/a-Z -_@/" , '' , $post['amount']);


			if(!is_numeric($amount)) {
				Flash::set("Amount must be a valid number" , 'danger');
				return request()->return();
			}

			$code = $this->CashAdvancePaymentModel->make_code();


			$payment = $this->CashAdvancePaymentModel->store([
				'userid'     => $post['user_id'],
				'loanid'     => $post['loan_id'],
				'code'       => $code,
				'amount'     => $amount,
				'path'       => 'ca_payments',
				'cashier_id' => $user_id,
				'branch_id'  => $branchid,
				'category'   => $this->CashAdvancePaymentModel::$category[0]
			]);


			/*INSERT LOGS*/
			$logs = $this->cashInventoryModel->make_cash([
				'branchid' => $branchid,
				'amount'   => $amount,
				'description' => "Cash Advance Payment code $code , Payment by : <b>{$user->fullname}</b> using Available earnings"
			]);


			/*UPDATE CASH ADVANCE REQUEST*/
			$userCashAdvance = new FNCashAdvanceUserModel($post['user_id'],$post['loan_id']);

			/*CHECK IF USER HAS NO OUTSTANDING BALANCE*/
			if($userCashAdvance->getBalance() <= 0) {
				/*UPDATE ALL USERS CASH ADVANCE REQUEST TO PAID*/
				$this->CashAdvanceModel->setAllApprovedToPaid($post['user_id']);
			}

			if($payment && $logs) {
				Flash::set("Payment saved");
				return redirect("FNCashAdvance/cash_advance_list");
			}else{
				die("Something went wrong");
			}
		}

		/*ADMIN MAKING PAYMENT*/
		public function make_payment()
		{
			$this->check_session();

			$user_id = unseal($_GET['userid']);
			$user = $this->userModel->get_user($user_id );

			$userCashAdvance = new FNCashAdvanceUserModel($user_id,$_GET['loan_id']);
			$userCashPayment = new FNCashAdvancePaymentUserModel($user_id, $_GET['loan_id']);

			$UserList = [];
			$user_account_list = $this->User_Account_Model->search_by_email_all($user->email,$user_id);

			foreach ($user_account_list as $key => $value) {

				$userEarning = new UserEarningModel($value->id);
				$totalEarning = $userEarning->getAvailable();

				array_push($UserList, array($value->id,$value->username,$totalEarning) );
			}


			 $data = [
				 'user'     => $userCashAdvance->getUser(),
				 'balance'  => $userCashAdvance->getBalance(),
				 'payments' => $userCashPayment->getAll(),
				 'earning_info'       => $UserList
			 ];

			 return $this->view('finance/cash_advance_payment/make_payment' , $data);

		}


		public function get_user_cash_advance_payments()
		{
			if($this->request() === 'POST')
			{
			}else{
				$data = [
					'title'       => 'Cash Advance Payments',
				    'payments' => $this->CashAdvancePaymentModel->get_user_cash_advance_payments($_GET['userid']),
					'amount'       => $_GET['amount'],
					'balance'       => $_GET['balance'],
					'date_time'       => $_GET['date']
				];
				$this->view('finance/cash_advance/user_cash_advance_payment_history' , $data);
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
?>
