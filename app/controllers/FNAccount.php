<?php 	

	class FNAccount extends Controller
	{

		private $account_types = [
			'stock-manager' , 'cashier' , 'branch-manager','cashier-assistance','id-verifier','payment-verifier','chat-bot-admin','id-socialmedia-verifier','auditor','staff','collector','customer-service-representative','cash_collection'
		];


		public function __construct()
		{
			$this->accountModel = $this->model('FNAccountModel');
			$this->branchModel  = $this->model('FNBranchModel');
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
		    $this->FNCashAdvanceModel = $this->model('FNCashAdvanceModel');
		}

		public function make_account()
		{
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{
				$errors = [];

				$username = trim($_POST['username']);

				$usernameExists = $this->accountModel->get_by_username($username);

				if(empty($username))
				{
					Flash::set("Username is required" , 'danger');
					redirect('FNAccount/make_account');
					return;
				}

				if($usernameExists) {
					Flash::set("Username already exists" , 'danger');
					redirect('FNAccount/make_account');
					return;
				}

				$result = $this->accountModel->make_account($_POST);

				if($result) {
					Flash::set("Account has been created");					
				}

				redirect('FNAccount/make_account');

			}else{
				$data = [
					'title'       => 'Account Create',
					'accounts' => $this->accountModel->get_list() ,
					'branches'  => $this->branchModel->get_list(),
					'accountTypes' => $this->account_types
				];

				$this->view('finance/account/make_account' , $data);
			}
		}

		public function edit_account($accountid)
		{
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{

				$result = $this->accountModel->update_account($_POST);

				if($result) 
				{
					Flash::set("Account Updated");
				}

				redirect("FNAccount/edit_account/{$_POST['accountid']}");
			}else{

				$data = [
					'title'     => 'Edit Account',
					'accountid' => $accountid ,
					'account'   => $this->accountModel->get_account($accountid),
					'accounts' => $this->accountModel->get_list() ,
					'branches'  => $this->branchModel->get_list(),
					'accountTypes' => $this->account_types
				];

				$this->view('finance/account/edit_account' , $data);		
				
			}
			
		}

		public function update_password()
		{
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{
				$accountid = $_POST['accountid'];
				$password  = $_POST['password'];

				if(strlen($password) < 3) 
				{
					Flash::set("Password must atleast contain 3 characters long" , 'warning');
					redirect("FNAccount/edit_account/{$accountid}");
					return;
				}

				$result = $this->accountModel->update_password($accountid , $password);

				if($result) {
					Flash::set("Password Updated");
				}

				redirect("FNAccount/edit_account/{$accountid}");
			}
		}

		public function request_staff()
		{
			$userid = $this->get_userid();

			if($this->request() === 'POST')
			{
				$errors = [];

				$username = trim($_POST['username']);

				$usernameExists = $this->accountModel->get_by_username($username);

				if(empty($username))
				{
					Flash::set("Username is required" , 'danger');
					redirect('FNAccount/request_staff');
					return;
				}

				if($usernameExists) {
					Flash::set("Username already exists" , 'danger');
					redirect('FNAccount/request_staff');
					return;
				}

				$result = $this->accountModel->request_staff($_POST, $userid);

				if($result) {
					Flash::set("You're Request is Now Pending");					
				}

				redirect('FNAccount/request_staff');

			}else{

				$data = [
					'list'   => $this->accountModel->get_request_info($userid,"userid")
				];

				$this->view('finance/account/request_staff',$data);
			}
		}

		public function change_request_status()
		{
			$userid = $this->get_userid();

			if($this->request() === 'POST')
			{
				$status = $_POST['status'];
			
				$query_status = $this->accountModel->change_request_status($_POST['id'], $status);

				if($status == 'approved')
				{
					$request_info = $this->accountModel->get_request_info($_POST['id'],"id");

					foreach ($request_info as $key => $value) {
						$username = $value->fn_username;
						$name = $value->name;
						$branchid = $value->fn_branchid;
					}
					$this->accountModel->approved_staff($username, $name, $branchid);

				}

				if($query_status) {
					Flash::set("Request is Now {$status}");					
				}

				return request()->return();


			}
		}

		public function approved_staff()
		{
			Authorization::setAccess(['admin']);
	
			$data = [
				'list'   => $this->accountModel->get_request_info("","")
			];

			$this->view('finance/account/approved_staff',$data);
			
		}

		public function loan_payments_info()
		{
			$data = [
					'loan_data' => $this->FNProductBorrowerModel->get_user_loans($this->get_userid()),
					'product_payment' => $this->FNProductBorrowerModel->get_payment_history($this->get_userid()),
					'cash_loan' => $this->FNCashAdvanceModel->get_user_loan($this->get_userid()),
					'cash_payment' => $this->FNCashAdvanceModel->get_payment_history($this->get_userid())
				];
			$this->view('finance/account/payments',$data);


		}


		private function get_userid()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				$user = Session::get('BRANCH_MANAGERS');
				$userid = $user->id;
				return $userid;

			}else if(Session::check('USERSESSION'))
			{
				$user = Session::get('USERSESSION');
				$userid = $user['id'];
				return $userid;

			}else{
				redirect('user/login');
			}
		}
	}
?>