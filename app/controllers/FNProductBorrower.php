<?php

	class FNProductBorrower extends Controller
	{


		public function __construct()
		{

			$this->CX = $this->model('FNProductBorrowerCXModel');
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
			$this->activationCode = $this->model('FNCodeInventoryModel');
			$this->userCodeModel  = $this->model('FNUserCodeModel');
			$this->accountUpgradeModel = $this->model('AccountUpgradeModel');

			/*
			*Used from make payment method
			*/
			$this->cashInventoryModel = $this->model('FNCashInventoryModel');
			$this->userModel = $this->model('User_model');

		}

		public function  count_users_purchase()
        {
        	$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$data = [
					'title' => "Clients Product Purchase",
	                'result' => $this->FNProductBorrowerModel->count_users_purchase($branchid)
	            ];

	            $this->view('finance/product_advance/count_users_purchase' , $data);
			}
        }

		public function get_product_borrower()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$data = [
					'title' => "Product Borrower",
	                'result' => $this->FNProductBorrowerModel->get_product_borrower($branchid)
	            ];

	            $this->view('finance/product_advance/product_borrower' , $data);
			}

		}

		public function get_product_borrower_old()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$data = [
					'title' => "Product Borrower",
	                'result' => $this->FNProductBorrowerModel->get_product_borrower_old($branchid)
	            ];

	            $this->view('finance/product_advance/product_borrower_old' , $data);
			}

		}

		public function release_product()
		{
			$branchid = $this->check_session();

            if($this->request() === 'POST')
			{
				$userId = $_POST['userid'];
				$Quantity = $_POST['quantity'];

				$stock_manager = 0;
				if(Session::check('BRANCH_MANAGERS'))
				{
					$user = Session::get('BRANCH_MANAGERS');
					$stock_manager = $user->id;

				}else if(Session::check('USERSESSION'))
				{
					$stock_manager = 1;

				}
				
	            $this->FNProductBorrowerModel->release_product($branchid, $userId, $Quantity, $stock_manager);

			}else{


			}
		}

		public function get_released_product_users($status)
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

			}else{

				$data = [
					'status' => $status,
					'title' => "Released Product ( Client List ) '$status'",
	                'result' => $this->FNProductBorrowerModel->get_released_product_users($branchid, $status)
	            ];

	            $this->view('finance/product_advance/released_product_user_list' , $data);

			}

		}


		public function get_released_product_paid()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{
				$status = 'Paid';
				$data = [
					'status' => $status,
					'title' => "Released Product ( Client List ) '$status'",
	                'result' => $this->FNProductBorrowerModel->get_released_product_users($branchid, $status)
	            ];

	            $this->view('finance/product_advance/all_paid' , $data);
			}
		}

		public function get_collector_task()
		{

			$branchId = $this->check_session();

			if($this->request() === 'POST')
			{

			}else{

				$status ='Approved';
				$data = [
					'status' => $status,
					'title' => "Released Product ( Client List )",
	                'result' => $this->CX->getMeta(compact(['branchId' , 'status']))
	            ];

	            $this->view('finance/collector/collector_task' , $data);

			}

		}

		// this is for collector's notes
		public function make_notes()
		{
			$branchid = $this->check_session();
			
			if($this->request() === 'POST')
			{	

				$this->FNProductBorrowerModel->make_notes($_POST,$branchid);
				Flash::set("Note successfully added");
				redirect('/FNProductBorrower/get_collector_notes');
			}else{

				$loanId = unseal($_GET['id']);
		
				$user = Session::get('BRANCH_MANAGERS');
				$userid = $user->id;
			
				$data = [
					'userid' => $userid,
	                'result' => $this->FNProductBorrowerModel->loanInfo($loanId),
	                'all_notes' =>$this->FNProductBorrowerModel->get_user_all_notes($loanId)
	            ];

	            $this->view('finance/collector/make_note' , $data);
			}
		}

		public function get_collector_notes()
		{
			$branchid = $this->check_session();
			
			if($this->request() === 'POST')
			{	

			
			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$userid = $user->id;
			
				$data = [
					'userid' => $userid,
	                'result' => $this->FNProductBorrowerModel->get_collector_notes($branchid, $userid)
	            ];

	            $this->view('finance/collector/notes' , $data);
			}
		}

		public function get_released_rice($status)
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

			}else{	

				$result = $this->FNProductBorrowerModel->get_released_rice($branchid, $status);
				$total = 0;

				foreach ($result as $key => $value) {
					$total += ($value->amount + $value->delivery_fee);
				}

				$data = [
					'status' => $status,
					'title' => "Released Rice Loan ( Client List ) ",
	                'result' => $result,
	                'total' => $total
	            ];

	            $this->view('finance/product_advance/rice_loan' , $data);

			}

		}

		public function get_released_product_all()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
				$result_explode = explode('|', $_POST['days']);
 				$days = $result_explode[0];
		        $selected = $result_explode[1];

		        $result = $this->FNProductBorrowerModel->get_released_product_all($branchid, $days);
				$total_paid = 0;
				$total_not_paid = 0;
				
		        foreach ($result as $key => $value) 
		        {
		        	if($value->status == "Paid")
		        	{
		        		 $total_paid += $value->amount;	

		        	}elseif($value->status == "Approved")
		        	{
		        		 $total_not_paid += $value->amount;	
		        	}
		        }

		        $paid_amount_count = $this->FNProductBorrowerModel->group_by_amount_paid($branchid, $days);
		        $unpaid_amount_count = $this->FNProductBorrowerModel->group_by_amount($branchid, $days);

		        $data = [
					'selected' => $selected,
					'title' => "Released Products",
	                'result' => $result,
	                'total_paid' => $total_paid,
	                'total_not_paid' => $total_not_paid,
	                'unpaid_amount_count' => $unpaid_amount_count,
	                'paid_amount_count' => $paid_amount_count
	            ];
	      
	             $this->view('finance/product_advance/product_released_all' , $data);

			}else{
				$result = $this->FNProductBorrowerModel->get_released_product_all($branchid, '0');
				$total_paid = 0;
				$total_not_paid = 0;
				
		        foreach ($result as $key => $value) 
		        {
		       		if($value->status == "Paid")
		        	{
		        		 $total_paid += $value->amount;	

		        	}elseif($value->status == "Approved")
		        	{
		        		 $total_not_paid += $value->amount;	
		        	}
		        }

		        $paid_amount_count = $this->FNProductBorrowerModel->group_by_amount_paid($branchid, '0');
		        $unpaid_amount_count = $this->FNProductBorrowerModel->group_by_amount($branchid, '0');

				$data = [
					'selected' => 'Today',
					'title' => "Released Products",
	                'result' => $result,
	                'total_paid' => $total_paid,
	                'total_not_paid' => $total_not_paid,
	                'unpaid_amount_count' => $unpaid_amount_count,
	                'paid_amount_count' => $paid_amount_count
	            ];

	             $this->view('finance/product_advance/product_released_all' , $data);

			}

		}


		public function search_user_ban()
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

				$loan_count = $this->FNProductBorrowerModel->check_users_pending_loan($_POST['userid']);

				if($loan_count == 0)
				{
					$data = [
	                 	'userInfo' => $this->FNProductBorrowerModel->search_user($_POST['userid'])
	           		];	
	           		$this->view('finance/product_advance/search_user' , $data);
				}else
				{
					Flash::set("Can't make loan for this client, because of unpaid product advance");
					redirect('/FNProductBorrower/search_user');
				}
				
	          

			}else{

	            $this->view('finance/product_advance/search_user');

			}

		}


		public function make_payment()
		{
			$this->check_session();

			if($this->request() === 'POST')
			{
				/*
				*ACCOUNT LOGGED IN AUTO CONFIG
				*DO NOT TOUCH
				**/
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

			   $folderPath = PUBLIC_ROOT.DS.'assets/payment_image/';

			   $file = new File();

		     $file->setFile($_FILES['payment_picture'])
			   ->setPrefix('IMAGE')
			   ->setDIR($folderPath)
		     ->upload();

	       $errors = $file->getErrors();
	       $fileName = $file->getFileUploadName();

		       if(!empty($file->getErrors())){
		            Flash::set("Upload Image failed, PLease Try Again" , 'danger');
		            redirect('FNProductBorrower/get_released_product_users/Approved');
		       }

		       if(empty($fileName)){

		       	 	Flash::set("Upload Image failed, PLease Try Again" , 'danger');
		            redirect('FNProductBorrower/get_released_product_users/Approved');

		       }else
		       {

						 /*
						 *CUSTOMER ID
						 */

		       		$userid = $_POST['userId'];
							$user = $this->userModel->get_user($userid);

		       		$result = $this->FNProductBorrowerModel->make_payment($_POST['loan_id'], $_POST['amount'], $branchid,
		           				$_POST['userId'], $_POST['loan_number'],  $fileName, $user_id );

							$description = "Loan Payment for loan #{$_POST['loan_number']} , payment by <b>{$user->fullname}</b>";

							/*
							*Log Payment on cashi inventory
							*/
							$cashier_id = $user_id;
							$this->cashInventoryModel->make_cash([
								'branchid' => $branchid,
								'amount'   => $_POST['amount'],
								'cashier_id' => $cashier_id,
								'description' => $description
							]);


			       	if(strlen($result) > 3 AND strlen($result) < 13)
		            {


		            	$activationCode = $result;

						$activationDetails = $this->activationCode->get_by_code($activationCode);

						//if no result
						if(empty($activationDetails)) {

							Flash::set("Code {$activationCode} does not exists" , 'danger');

							redirect('FNProductBorrower/get_released_product_users/Approved');

							return;
						}
						//check if used;

						if(strtolower($activationDetails->status) == 'used') {

							Flash::set("Code {$activationCode} already used" , 'danger');

							redirect('FNProductBorrower/get_released_product_users/Approved');

							return;
						}

						//distrocommission;


						$submitCommission = $this->submit_commissions($userid , $activationDetails, $activationCode);

						if($submitCommission)
						{
							$useActivationcode = $this->activationCode->update_status($activationDetails->id , 'used');

							$this->userCodeModel->update_status($activationDetails->id , 'used');

							if($useActivationcode) {

								$prefix = substr($activationCode, 0 , 2);

								if($prefix != 'PR')
								{
									Flash::set("Your Loan is now Paid. Code {$activationCode} successfully registered");
									$this->accountModelInstance()->update_account_product_paid($userid , $activationDetails);

								}else{
									Flash::set("Your Loan is now Paid! Thank You!");
								}
								return redirect('FNProductBorrower/get_released_product_users/Approved');
							}

							/*Account Creation (BINARY SPREADYY)*/

						    if(in_array($activationCode->level , ['bronze' , 'silver' , 'gold']))
						    {
						        $accountMaker = new AccountMakerObj($purchaser->id , $activationCode->level);
						        $accountMaker->run();
						    }


						}else{
							return redirect('FNProductBorrower/get_released_product_users/Approved');
						}



			        }else if($result == 'ok'){

			        	   Flash::set("Payment Successfully Submitted");
			        	   redirect('FNProductBorrower/get_released_product_users/Approved');
			        }else
			        {
			           Flash::set("Error Please Try Again");
					   redirect('FNProductBorrower/get_released_product_users/Approved');

		           	}


		          /* if($result)
		           {

						redirect('FNProductBorrower/get_released_product_users/Approved');
		           }else
		           {
		            	Flash::set("Error Please Try Again");
						redirect('FNProductBorrower/get_released_product_users/Approved');

	           	   }*/
		       }



			}else{

				$data = [
	                'userInfo' => $this->FNProductBorrowerModel->loanInfo($_GET['loan_id'])
	            ];

	            $this->view('finance/product_advance/make_payment', $data);

			}

		}



		//advance payment---------------------------------------------------------------------------------------------

		public function search_user_advance_payment()
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

				$data = [
	                'userInfo' => $this->FNProductBorrowerModel->search_user($_POST['userid'])
	            ];

	            $this->view('finance/product_advance/search_user_advance_payment' , $data);

			}else{

	            $this->view('finance/product_advance/search_user_advance_payment');

			}

		}

		public function make_advance_payment()
		{
			$this->check_session();

			if($this->request() === 'POST')
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

			   $folderPath = PUBLIC_ROOT.DS.'assets/payment_image/';

			   $file = new File();
		       $file->setFile($_FILES['payment_picture'])
			   ->setPrefix('IMAGE')
			   ->setDIR($folderPath)
		       ->upload();

		       $errors = $file->getErrors();
		       $fileName = $file->getFileUploadName();

		       if(!empty($file->getErrors())){
		            Flash::set("Upload Image failed, PLease Try Again" , 'danger');
		            redirect('FNProductBorrower/search_user_advance_payment');
		       }

		       if(empty($fileName)){

		       	 	Flash::set("Upload Image failed, PLease Try Again" , 'danger');
		            redirect('FNProductBorrower/search_user_advance_payment');

		       }else
		       {
		       		//make product advance or loan
			    	$userid = $_POST['userId'];

			    	$result_explode = explode('|', $_POST['amount']);
					$amount = $result_explode[0];
		       		$Quantity = $result_explode[1];

		       		//activation or nonactivation.
		       		$category = $result_explode[2];
		       		$level = $result_explode[3];
		       		$product_name;

		       		if (strrpos($level, 'Rejuve Set') !== false) {
		       			$product_name = "Rejuve Set";
					}else{
						$product_name = "coffee";
					}


		       		$result = $this->FNProductBorrowerModel->make_advance_payment( $amount, $Quantity, $branchid,
		           				$_POST['userId'],  $fileName, $user_id, $category, $level, $_POST['delivery_fee'],$product_name);


			       	if(strlen($result)>3 AND strlen($result)<13)
		            {


		            	$activationCode = $result;
		            	$activationDetails = null;
		            	if($category == "activation")
		            	{
		            		$activationDetails = $this->activationCode->get_by_code($activationCode);

			            	//if no result
							if(empty($activationDetails)) {

								Flash::set("Code {$activationCode} does not exists" , 'danger');

								redirect('FNProductBorrower/get_released_product_users/Approved');

								return;
							}
							//check if used;

							if(strtolower($activationDetails->status) == 'used') {

								Flash::set("Code {$activationCode} already used" , 'danger');

								redirect('FNProductBorrower/search_user_advance_payment');

								return;
							}


		            	}else{

		            		$activationDetails = $this->activationCode->get_by_level($level);

		            	}


						//distrocommission;

						$submitCommission = $this->advance_payment_submit_commissions($userid , $activationDetails, $activationCode, $Quantity, $level);



						if($submitCommission)
						{
							if($category == "activation")
		            		{
								$useActivationcode = $this->activationCode->update_status($activationDetails->id , 'used');

								$this->userCodeModel->update_status($activationDetails->id , 'used');
							}

							$prefix = substr($activationCode, 0 , 2);

							if($prefix == 'PR' OR $prefix == 'RE')
							{
								Flash::set("Your Loan is now Paid! Thank You!");

							}else{

								Flash::set("Payment Successfully Submitted and Paid. Code {$activationCode} successfully registered");
								$this->accountModelInstance()->update_account_product_paid($userid , $activationDetails);
							}

							redirect('FNProductBorrower/get_released_product_users/Paid');

						}else{

							redirect('FNProductBorrower/search_user_advance_payment');
						}



			        }else if($result == 'ok'){

			        	   Flash::set("Payment Successfully Submitted");
			        	   redirect('FNProductBorrower/get_released_product_users/Approved');
			        }else
			        {
			           Flash::set("Error Please Try Again");
					   redirect('FNProductBorrower/search_user_advance_payment');

		           	}



		       }



			}else{

				$data = [
	                'userInfo' => $this->FNProductBorrowerModel->loanInfo($_GET['loan_id'])
	            ];

	            $this->view('finance/product_advance/make_payment', $data);

			}

		}
		//advance payment---------------------------------------------------------------------------------------------end





		public function get_user_loans()
		{
			$branchid = $this->check_session();

			if(Session::check('USERSESSION'))
			{
				$user_id = Session::get('USERSESSION')['id'];
			

				$data = [
						'result' => $this->FNProductBorrowerModel->get_user_loans($user_id)
				];

				return $this->view('finance/product_advance/user_loan_list', $data);
			}else
			{
				redirect('user/login');
			}
		}


		public function get_user_loans_details($user_id)
		{
		
			if(Session::check('USERSESSION'))
			{

				$data = [
						'result' => $this->FNProductBorrowerModel->get_user_loans($user_id)
				];

				return $this->view('finance/product_advance/user_loan_list', $data);
			}else
			{
				redirect('user/login');
			}
		}


		public function get_user_loans2($user_id)
		{
			
	
			$data = [
					'result' => $this->FNProductBorrowerModel->get_user_loans($user_id)
			];

			return $this->view('finance/product_advance/user_loan_list', $data);
			
		}

		public function get_payment_list_pending()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$data = [
					'title' => 'Pending Payments',
	                'result' => $this->FNProductBorrowerModel->get_payment_list_pending($branchid)
	            ];

	            $this->view('finance/product_advance/payment_list_pending',$data);

			}

		}

		public function get_payment_list_approved()
		{
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$data = [
					'title' => 'Approved Payments',
	                'result' => $this->FNProductBorrowerModel->get_payment_list_approved($branchid)
	            ];

	            $this->view('finance/product_advance/payment_list_approved',$data);

			}

		}

		public function preview_image()
		{
			$branchid = $this->check_session();
			$this->view('finance/product_advance/preview_image');
		}


		public function approve_payment()
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$userid = $_GET['userId'];

				$result = $this->FNProductBorrowerModel->approve_payment($_GET['loan_id'], $_GET['payment_id'], $_GET['amount'], $branchid,
																		 $_GET['userId'], $_GET['loan_number']);

				if(strlen($result)>1 AND strlen($result)<13)
	            {


	            	$activationCode = $result;

					$activationDetails = $this->activationCode->get_by_code($activationCode);

					//if no result
					if(empty($activationDetails)) {

						Flash::set("Code {$activationCode} does not exists" , 'danger');

						redirect('FNProductBorrower/get_payment_list_pending');

						return;
					}
					//check if used;

					if(strtolower($activationDetails->status) == 'used') {

						Flash::set("Code {$activationCode} already used" , 'danger');

						redirect('FNProductBorrower/get_payment_list_pending');

						return;
					}

					//distrocommission;


					$submitCommission = $this->submit_commissions($userid , $activationDetails, $activationCode);

					if($submitCommission)
					{
						$useActivationcode = $this->activationCode->update_status($activationDetails->id , 'used');

						$this->userCodeModel->update_status($activationDetails->id , 'used');

						if($useActivationcode) {

							Flash::set("Your Loan is now Paid. Code {$activationCode} successfully registered");

							$this->accountModelInstance()->update_account_product_paid($userid , $activationDetails);

							redirect('FNProductBorrower/get_payment_list_pending');
						}
					}else{

						redirect('FNProductBorrower/get_payment_list_pending');
					}



		        }else if($result == 'ok'){

		        	   Flash::set("Payment Successfully Approved");
		        	   redirect('FNProductBorrower/get_payment_list_pending');
		        }else
		        {
		           Flash::set("Error Please Try Again");
				   redirect('FNProductBorrower/get_payment_list_pending');

	           	}
			}
		}

		public function decline_payment()
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{
			}else{

				$result = $this->FNProductBorrowerModel->decline_payment($_GET['filename'], $_GET['payment_id']);
				if($result)
	            {
				   redirect('FNProductBorrower/get_payment_list_pending');
		        }else
		        {
		           Flash::set("Error Please Try Again");
				   redirect('FNProductBorrower/get_payment_list_pending');

	           	}
			}
		}

		//account activation ----------------------------------------------------------------------
		private function submit_commissions($purchaser , $activationDetails, $activationCode)
		{
			
			/*load payin model*/
			$payinModel = new LDPayinModel();
			/*load commissionModel*/
			$this->commissiontrigger_model = $this->model('commissiontrigger_model');

			$origin = $activationDetails->company ?? 'untag';//if no origin set to untag
			
			$commissions =
				array(
					'unilevelAmount'   => $activationDetails->unilevel_amount,
					'drcAmount'        => $activationDetails->drc_amount ,
					'binaryPoints'     => $activationDetails->binary_point,
					'level'  => $activationDetails->level
				);

			$orderid   = 0;
			$distribution = $activationDetails->distribution;

			/*add payinmodel*/
			$payinModel->make_payin($purchaser , $activationDetails->amount , 'code' , $origin);

			/*ddistribute commissions*/
			$distributeCommission =
				$this->commissiontrigger_model->submit_commissions($purchaser , $commissions ,
					$orderid , $distribution , $origin);

			if($distributeCommission)
				return true;
			return false;
		}


		//account activation ----------------------------------------------------------------------


		//account activation  advance payment !!!!----------------------------------------------------------------------
		private function advance_payment_submit_commissions($purchaser , $activationDetails, $activationCode = null, $quantity, $level)
		{
			/*load payin model*/
			$payinModel = new LDPayinModel();
			/*load commissionModel*/
			$this->commissiontrigger_model = $this->model('commissiontrigger_model');

			$origin = $activationDetails->company ?? 'untag';//if no origin set to untag
			if($level == 'Rejuve Set for Activated' OR $level == 'Rejuve Set')
			{
				$unilevelAmount = $activationDetails->unilevel_amount * $quantity;
				$amount = $activationDetails->amount * $quantity;
			}elseif($level == 'Product Repeat purchase'){
				$unilevelAmount = $activationDetails->unilevel_amount;
				$amount = $activationDetails->amount * $quantity;
			}else{
				$unilevelAmount = $activationDetails->unilevel_amount;
				$amount = $activationDetails->amount;
			}


			$commissions =
				array(
					'unilevelAmount'   => $unilevelAmount,
					'drcAmount'        => $activationDetails->drc_amount ,
					'binaryPoints'     => $activationDetails->binary_point
				);

			$orderid   = 0;
			$distribution = $activationDetails->distribution;

			/*add payinmodel*/
			$payinModel->make_payin($purchaser , $amount , 'code' , $origin);

			/*ddistribute commissions*/
			$distributeCommission =
				$this->commissiontrigger_model->submit_commissions($purchaser , $commissions ,
					$orderid , $distribution , $origin);

			if($distributeCommission)
				return true;
			return false;
		}

		private function accountModelInstance()
		{
			return new AccountActivationModel();
		}
		private function branch_vault_model_instance()
		{
			return new BranchVaultModel();
		}

		//account activation ----------------------------------------------------------------------


		public function export()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['users']));


                $result = objectAsArray($exportData);

                $header = [
                    'username'  => 'Username',
                    'fullname' => 'Full Name',
                    'email'  => 'Email',
                    'mobile'  => 'Phone #',
                    'address' => 'Address',
                    'reason' => 'Remarks',
                    'total_valid_id' => 'Total Valid ID',
                    'total_valid_link' => 'Total Valid Social Media Link'

                ];

                export($result , $header);

               // redirect('FNProductBorrower/get_product_borrower');
            }
        }



        public function cancel_qualification_product($userid)
        {
        	$result = $this->FNProductBorrowerModel->cancel_qualification_product($userid);
			if($result)
			{
				Flash::set("User Qualification is now Canceled");
				redirect('/FNProductBorrower/get_product_borrower');

			}else
			{
				Flash::set("Error Please Try Again");
				redirect('/FNProductBorrower/get_product_borrower');
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

		public function get_released_product_cash_collection($status)
		{

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{

			}else
			{

				$results = $this->FNProductBorrowerModel->get_released_product_users($branchid, $status);
				
				$data = [
					'status' => $status,
					'title'  => "Released Product ( Client List ) '$status'",
	                'result' => $results 
	            ];

	            $this->view('finance/product_advance/cash_collection_view' , $data);

			}

		}

	}
