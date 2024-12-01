<?php 	

	class FNSinglebox extends Controller
	{

		public function __construct()
		{
			$this->singleboxModel = $this->model('FNSingleboxModel');
			$this->userModel = $this->model('User_model');
			$this->branchModel = $this->model('FNBranchModel');
			$this->codeInventory = $this->model('FNCodeInventoryModel');
			$this->codePurchaseModel= $this->model('FNCodePurchaseModel');
			$this->itemInventoryModel = $this->model('FNItemInventoryModel');
		}

		public function make_assistance()
		{
			Authorization::setAccess(['admin' , 'customer']);

			$user = Session::get('USERSESSION');
			
			$userid = $user['id'];

			if($this->request() === 'POST')
			{
				/*for unpaid assistance*/
				$data = [
					'userid' => $userid,
					'branchid' => $user['branchId'],
					'addtionalBoxes' => $_POST['addtionalBoxes']
				];

				$result = 	
					$this->singleboxModel->make_assistance($data);

				if($result) 
				{
					Flash::set("Single assistance requested loan success");
				}

				unset($_POST);
			}

			$paidBoxes = $this->singleboxModel->get_total_paid_boxes($userid);


			$data = [
				'title' => 'Single Box Assistance',
				'addtionalBoxes' => $this->singleboxModel->get_addition_boxes($paidBoxes), //just an example
				'assistanceLogs' => $this->singleboxModel->get_user_assistance($userid),
				'activations'    => $this->codeInventory->get_user_codes($userid),
				'productClaimCodes' => $this->codePurchaseModel->get_by_user($userid)
			];
			/*TEMPORARY*/
			$userUpline = $this->userModel->get_user_upline($userid);
			//check if userupline !empty
			if(is_array($userUpline))
			{
				//count user upline
				if(count($userUpline) >= 2) {
					$data['userDownline'] = $userUpline;
				}

			}


			$data['user'] = $user;

			return $this->view('finance/singlebox/make_assistance' , $data);
		}


		public function claim_assistance()
		{

			$data = [
				'title' => 'Product Assistance Claim',
				'codes' => $this->singleboxModel->get_list_order_branch()
			];

			if(Session::check('BRANCH_MANAGERS'))
			{
				$user = Session::get('BRANCH_MANAGERS');
				
				$data['codes'] = $this->singleboxModel->get_by_branch($user->branchid);
			}
			$this->view('finance/singlebox/claim_assistance' , $data);
		}


		public function preview($boxid)
		{

			
			$data = [
				'title' => 'Product Assistance View',
				'code' => $this->singleboxModel->get_code($boxid)
			];

			$data['userinfo']   = $this->userModel->get_user($data['code']->userid);
			$data['branch'] = $this->branchModel->get_branch($data['code']->branchid);
			
			$this->view('finance/singlebox/code_view' , $data);
		}

		public function claim_assistance_search()
		{


			if($this->request() === 'POST')
			{
				$data = ['title' => 'Product Assistance View'];

				$getCode = $this->singleboxModel->get_info_by_code($_POST['code']);

				$branchAccount = Session::get('BRANCH_MANAGERS');
				// die(var_dump($getCode));

				if($getCode) {
					$data['code']       = $getCode;
					$data['userinfo']   = $this->userModel->get_user($getCode->userid);
					$data['branch']     = $this->branchModel->get_branch($getCode->branchid);
					$data['branchAccount'] = $branchAccount;
					
					$this->view('finance/singlebox/code_view_search' , $data);
				}else{
					Flash::set("Product Assistance Code '{$_POST['code']}'" , 'danger');
					redirect('FNSinglebox/claim_assistance_search');
				}
			}else
		{	
				$user = Session::get('BRANCH_MANAGERS');

		      	$userid = $user->id;

				$data =[
					'items'    => $this->itemInventoryModel->get_branch_inventory($user->branchid)
				];
				$this->view('finance/singlebox/claim_assistance_search', $data );
			}

			
		}

		public function status_list_all()
		{
			
			$data = [
				'title' => 'Single Box Status List',
				'list' => $this->singleboxModel->get_list_order_branch()
			];
			
			$this->view('finance/singlebox/product_status_list' , $data);
		}

		public function status_list_by_branch()
		{
			$user = Session::get('BRANCH_MANAGERS');
				

			$data = [
				'title' => 'Single Box Status List',
				'list' => $this->singleboxModel->get_by_branch($user->branchid)
			];
			
			$this->view('finance/singlebox/product_status_list' , $data);
		}


	}