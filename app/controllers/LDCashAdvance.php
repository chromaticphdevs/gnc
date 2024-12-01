<?php


	class LDCashAdvance extends Controller
	{

		private $view = 'lending/';
		public function __construct()
		{
			//loan user model
			$this->CashModel = $this->model('LDCashModel');
			$this->ProductModel = $this->model('LDProductModel');	
			$this->UserModel = $this->model('LDUserModel');
		}
		

		public function create()
		{
			DBBIAuthorization::setAccess(['super admin','admin' , 'customer'] , 'user' , 'FireLoginDBBI');


			$user_session = Session::get('user');


			$data = [
				'userList' => $this->UserModel->classlist(),
				'user_session' => $user_session,
				'username' => $this->UserModel->preview($user_session['id'])
			];


			if($this->request() === 'POST')
			{

				$this->CashModel->create($_POST);

			}else
			{	
				$this->view($this->view.'cash/create',$data);
			}
		}

		

		public function list()
		{

			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');

			$data = [
				'list' => $this->CashModel->list()	
			];

			$this->view($this->view.'cash/list' , $data);

		}

		public function history($userID)
		{

			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$data = [
				'history' => $this->CashModel->history($userID),
				'userID' => $userID
			];

			$this->view($this->view.'cash/history' , $data);

		}

		public function update_status_approve()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->CashModel->status_approve($_GET);

		}
		public function update_status_disapprove()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->CashModel->status_disapprove($_GET);
	  
		}


			public function payment($userid)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$cashAdvance_balance = $this->CashModel->total_cashAdvance($userid);
			$data = [
				'userinfo' => $this->UserModel->preview($userid),
				'cashAdvance_balance' => $cashAdvance_balance,
				'loan_info_list_cash' => $this->CashModel->loan_info($userid),
				'loan_info_list_product' => $this->ProductModel->loan_info($userid)
			

			];

			if($this->request() === 'POST')
			{
				$this->CashModel->pay($_POST);
			}else
			{
				$this->view($this->view.'cash/payment',$data);
			}
		}

		public function payment_back_camera($userid)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$cashAdvance_balance = $this->CashModel->total_cashAdvance($userid);
			$data = [
				'userinfo' => $this->UserModel->preview($userid),
				'cashAdvance_balance' => $cashAdvance_balance,
				'loan_info_list_cash' => $this->CashModel->loan_info($userid),
				'loan_info_list_product' => $this->ProductModel->loan_info($userid)
			

			];

			if($this->request() === 'POST')
			{
				$this->CashModel->pay($_POST);
			}else
			{
				$this->view($this->view.'cash/payment_back_camera',$data);
			}
		}

		public function send_payment()
		{	
				DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
	
				$this->CashModel->pay($_POST);
		
		}	


			public function update_status_approve_payment()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->CashModel->payment_status_approve($_GET);

		}


			public function payment_history($userId)
		{

			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$data = [
				'payment_history' => $this->CashModel->payment_history($userId),
				'user_id' => $userId
			];
			$this->view($this->view.'cash/payment_history' , $data);

		}

			public function upload_collateral()
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');


			
			if($this->request() === 'POST')
			{
				$this->CashModel->upload_collateral($_POST);
			}else
			{
				$this->view($this->view.'cash/collateral_img');
			}
			
		}


		public function preview_collateral($loanId)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
	
			if($this->request() === 'POST')
			{
				$this->CashModel->upload_collateral($_POST);
			}else
			{

				$data = [
				'collateral_img_list' => $this->CashModel->collateral_img_list($loanId),
				'loanId' => $loanId
				];

				$this->view($this->view.'cash/preview_collateral_img',$data);
			}
			
		}

	}


?>