<?php

	class ProductAdvance extends Controller
	{
		public function __construct()
		{
			$this->userModel = $this->model('User_model');
			$this->productadvanceModel = $this->model('ProductAdvanceModel');

			$this->branchModel = $this->model('LDBranchModel');
		}

		public function index()
		{
			$this->create();
		}

		public function create()
		{
			Authorization::setAccess(['admin' , 'user']);

			$user = Session::get('USERSESSION');
			$branchList     = $this->branchModel->get_list();
			$paidBoxes = $this->productadvanceModel->get_total_paid_boxes($user['id']);

			$data = [
				'title' => 'Product Advance',
				'productLoanList'  => $this->productadvanceModel->get_list($user['id']),
				'paidBoxes' => $paidBoxes,
				'addtionalBoxes' => $this->productadvanceModel->get_addition_boxes($paidBoxes),
				'branchList'  => $branchList,
				'activation_list' => $this->productadvanceModel->get_user_activations($user['id'])
			];

			/*TEMPORARY*/
			$userUpline = $this->userModel->get_user_upline($user['id']);
			//check if userupline !empty
			if(is_array($userUpline))
			{
				//count user upline
				if(count($userUpline) >= 2) {
					$data['userDownline'] = $userUpline;
				}

			}

			if($this->request() === 'POST')
			{
				$addtionalBoxes = $data['addtionalBoxes'];
				$branchid       = $user['branchId'];
				
				$result = $this->productadvanceModel->single_box_loan($user['id'] ,$branchid , $addtionalBoxes);

				if($result)
				{
					Flash::set("Product allowance request sent");
				}

				$data = [
					'title' => 'Product Advance',
					'productLoanList'  => $this->productadvanceModel->get_list($user['id']),
					'paidBoxes' => $paidBoxes,
					'addtionalBoxes' => $this->productadvanceModel->get_addition_boxes($paidBoxes),
					'branchList'  => $branchList,
					'activation_list' => $this->productadvanceModel->get_user_activations($user['id'])
				];

			}
		

			$this->view('productadvance/create' , $data);
		}
	}
