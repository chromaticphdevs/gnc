<?php

	class FNProductBorrower extends Controller
	{

		public function __construct()
		{
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
		}

		public function get_product_borrower()
		{
			$this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;

				$data = [
					'title' => "Product Borrower",
	                'result' => $this->FNProductBorrowerModel->get_product_borrower($branchid)
	            ];

	            $this->view('finance/product_advance/product_borrower' , $data);
			}

		}

		public function release_product($userId)
		{

			$this->check_session();

			$user = Session::get('BRANCH_MANAGERS');

			$branchid = $user->branchid;
            $this->FNProductBorrowerModel->release_product($branchid, $userId);
		}

		public function get_released_product_users()
		{

			$this->check_session();

			if($this->request() === 'POST')
			{

			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;

				$data = [

					'title' => "Released Product ( Client List )",
	                'result' => $this->FNProductBorrowerModel->get_released_product_users($branchid)
	            ];

	            $this->view('finance/product_advance/released_product_user_list' , $data);

			}

		}

        public function get_released_product_users_admin()
		{

			if($this->request() === 'POST')
			{

			}else{

				$branchid =8;
				$data = [

					'title' => "Released Product ( Client List )",
	                'result' => $this->FNProductBorrowerModel->get_released_product_users($branchid)
	            ];

	            $this->view('finance/product_advance/released_product_user_list' , $data);

			}

		}

		public function search_user()
		{

			$this->check_session();

			if($this->request() === 'POST')
			{

				$data = [
	                'userInfo' => $this->FNProductBorrowerModel->search_user($_POST['userid'])
	            ];

	            $this->view('finance/product_advance/search_user' , $data);

			}else{

	            $this->view('finance/product_advance/search_user');

			}

		}


		public function make_payment()
		{
			$this->check_session();

			if($this->request() === 'POST')
			{
			   $user = Session::get('BRANCH_MANAGERS');
			   $branchid = $user->branchid;

	           $result = $this->FNProductBorrowerModel->make_payment($_POST['loan_id'], $_POST['amount'], $branchid, $_POST['userId'], $_POST['loan_number'] );

	           if($result)
	           {

					redirect('/FNProductBorrower/get_released_product_users');
	           }else
	           {
	            	Flash::set("Error Please Try Again");
					redirect('/FNProductBorrower/get_released_product_users');

	           }

			}else{

				$data = [
	                'userInfo' => $this->FNProductBorrowerModel->loanInfo($_GET['loan_id'])
	            ];

	            $this->view('finance/product_advance/make_payment', $data);

			}

		}




		private function check_session()
		{
			if(Session::check('BRANCH_MANAGERS'))
			{
				return true;
			}else{
				redirect('/user/login');
			}
		}

	}
