<?php


	class LDProductAdvance extends Controller
	{

		private $view = 'lending/';
		public function __construct()
		{
			//loan user model
			$this->ProductModel = $this->model('LDProductModel');	
			$this->UserModel = $this->model('LDUserModel');	

		}
		
		public function create_activation_code()
		{	
			DBBIAuthorization::setAccess(['super admin'] , 'user' , 'FireLoginDBBI');
			$user_session = Session::get('user');
			$data = [
				'productList' => $this->ProductModel->productList(),
				'user_session' => $user_session,
				'username' => $this->UserModel->preview($user_session['id']),
				'activation_code_list_unused' =>  $this->ProductModel->activation_code_list_unused(),
				'activation_code_list_used' =>  $this->ProductModel->activation_code_list_used(),
				'branchList' => $this->UserModel->branch_list()
			];


			if($this->request() === 'POST')
			{
				$this->ProductModel->create_activation_code($_POST);
			}else
			{
				$this->view($this->view.'activation/create',$data);
			}

		
		}

		public function create()
		{
			DBBIAuthorization::setAccess(['super admin','admin' , 'customer'] , 'user' , 'FireLoginDBBI');

			$user_session = Session::get('user');

			$data = [
				'userList' => $this->UserModel->classlist(),
				'productList' => $this->ProductModel->productList(),
				'user_session' => $user_session,
				'username' => $this->UserModel->preview($user_session['id'])
			];


			if($this->request() === 'POST')
			{
				$this->ProductModel->create($_POST);
			}else
			{
				$this->view($this->view.'product/create',$data);
			}
		}

		public function list()
		{

			DBBIAuthorization::setAccess(['super admin','admin'] , 'user' , 'FireLoginDBBI');
			$data = [
				'list' => $this->ProductModel->list()
			];

			$this->view($this->view.'product/list' , $data);

		}

		public function history($userID)
		{

			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$data = [
				'history' => $this->ProductModel->history($userID),
				'user_id' => $userID
			];

			$this->view($this->view.'product/history' , $data);

		}
		
		public function update_status_approve()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->ProductModel->status_approve($_GET);

		}
		public function update_status_disapprove()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->ProductModel->status_disapprove($_GET);
	  
		}




		public function payment($userid)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');

			$data = [
				'userinfo' => $this->UserModel->preview($userid)
			];

			if($this->request() === 'POST')
			{
				$this->ProductModel->pay($_POST);
			}else
			{
				$this->view($this->view.'product/payment',$data);
			}
		}


		public function send_payment()
		{	
				DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
				$this->ProductModel->pay($_POST);
		
		}


			public function update_status_approve_payment()
		{
			DBBIAuthorization::setAccess(['super admin','admin'] ,'user' , 'FireLoginDBBI');
	    	 $class  = $this->ProductModel->payment_status_approve($_GET);

		}

			public function payment_history($userId)
		{

			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
			$data = [
				'payment_history' => $this->ProductModel->payment_history($userId),
				'user_id' => $userId
			];
			$this->view($this->view.'product/payment_history' , $data);

		}


			public function upload_collateral()
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');

			

			if($this->request() === 'POST')
			{
				$this->ProductModel->upload_collateral($_POST);
			}else
			{
				$this->view($this->view.'product/collateral_img');
			}
		}


			public function preview_collateral($loanId)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer'] , 'user' , 'FireLoginDBBI');
	
			if($this->request() === 'POST')
			{
				$this->ProductModel->upload_collateral($_POST);
			}else
			{

				$data = [
				'collateral_img_list' => $this->ProductModel->collateral_img_list($loanId),
				'loanId' => $loanId
				];

				$this->view($this->view.'product/preview_collateral_img',$data);
			}
			
		}

	}


?>