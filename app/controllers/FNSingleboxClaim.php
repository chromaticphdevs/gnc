<?php 	

	class FNSingleboxClaim extends Controller
	{
		public function __construct()
		{
			$this->itemInventoryModel = $this->model('FNItemInventoryModel');

			$this->singleboxModel     = $this->model('FNSingleboxModel');

			$this->branchSession      = Session::get('BRANCH_MANAGERS');
		}

		public function do_action()
		{
			if(isset($_POST['claim']))
			{
				$this->claim_box();
			}

			if(isset($_POST['pay']))
			{
				$this->pay_box();
			}

			// if(isset($_POST['withpayment']))
			// {
			// 	$this->claim_pay_box();
			// }
		}

		private function claim_box()
		{
			if($this->request() === 'POST')
			{
				$boxid = $_POST['boxid'];

				$branch = $this->branchSession;

				$code = $this->singleboxModel->get_code($boxid);
				/*validate claim*/

				/*update code status*/
				$updateCodeStatus = 
					$this->singleboxModel->update_code($boxid , 'claimed');

				$data = [
					'quantity' => -1,
					'description' => "Product Assistance Claim , assistance code :#{$code->code}",
					'branchid'   => $branch->branchid
				];

				$branchInventory = $this->itemInventoryModel->get_branch_inventory($branch->branchid);

				if($branchInventory < 1) 
				{
					Flash::set("Insufficient branch stocks");
					redirect("FNSinglebox/preview/{$boxid}");
					return false;
				}

				$result = $this->itemInventoryModel->make_item($data);

				if($result) {
					Flash::set("Box #{$code->code} has been claimed");
				}

				redirect("FNSinglebox/preview/{$boxid}");
			}
		}

		public function pay_box()
		{
			if($this->request() === 'POST')
			{
				$branch = $this->branchSession;
				
				$boxid = $_POST['boxid'];

				$code = $this->singleboxModel->get_code($boxid);
				/*update code status*/
				$updateCodeStatus = 
					$this->singleboxModel->update_code($boxid , 'paid');

				$data = [
					'branchid'      => $branch->branchid,
					'amount'        => $code->amount,
					'description'   => "Code Payment #{$code->code}"
				];
				/*release of code*/

				$paidLoanCount = $this->singleboxModel->get_paid_count($code->userid);

				$receiveCode = $this->receive_code($paidLoanCount);

				if($receiveCode) {

					$result = $this->inventoryCodeInstance()->release_code($code->userid);
					/*if the branch code inventory has no stock dont proceed*/
					if(!$result) {

						$this->singleboxModel->update_code($boxid , $code->status);
						
						redirect("FNSinglebox/preview/{$_POST['boxid']}");
						return false;
					}
				}

				$result = $this->add_cash($data);

				if($result) {
					Flash::set("Box #{$code->code} has been paid.");
				}

				redirect("FNSinglebox/preview/{$_POST['boxid']}");
			}
		}

		// public function claim_pay_box()
		// {
		// 	if($this->request() === 'POST')
		// 	{
		// 		$boxid = $_POST['boxid'];

		// 		$code = $this->singleboxModel->get_code($boxid);
		// 		/*update code status*/
		// 		$updateCodeStatus = 
		// 			$this->singleboxModel->update_code($boxid , 'paid');

		// 		$branchInventory = $this->itemInventoryModel->get_branch_inventory($code->branchid);

		// 		if($branchInventory < 1) 
		// 		{
		// 			Flash::set("Insufficient branch stocks");
		// 			redirect("FNSinglebox/preview/{$boxid}");
		// 			return false;
		// 		}

		// 		$errors = false;

		// 		$data = [
		// 			'quantity' => -1,
		// 			'description' => "Product Assistance Claim , assistance code :#{$code->code}",
		// 			'branchid'   => $code->branchid
		// 		];

		// 		if(!$this->deduct_inventory($data)){
		// 			$errors = true;
		// 		}

		// 		$data = [
		// 			'branchid'      => $code->branchid,
		// 			'amount'        => $code->amount,
		// 			'description'   => "Code Payment #{$code->code}"
		// 		];

		// 		$receiveCode = $this->receive_code($paidLoanCount);

		// 		if($receiveCode) {

		// 			$result = $this->inventoryCodeInstance()->release_code($boxid , $code->userid);
		// 			/*if the branch code inventory has no stock dont proceed*/
		// 			if(!$result) {
		// 				$this->singleboxModel->update_code($boxid , $code->status);
		// 				redirect("FNSinglebox/preview/{$_POST['boxid']}");

		// 				return false;
		// 			}
		// 		}

		// 		if(!$this->add_cash($data)){
		// 			$errors = true;
		// 		}

		// 		/*release of code*/

		// 		$paidLoanCount = $this->singleboxModel->get_paid_count($code->userid);

		// 		$receiveCode = $this->receive_code($paidLoanCount);
				
		// 		if($receiveCode) {

		// 			$this->inventoryCodeInstance()->release_code($code->userid);
		// 		}


		// 		if(!$errors) {
		// 			Flash::set("Box #{$code->code} has been claimed and paid.");
		// 		}

		// 		redirect("FNSinglebox/preview/{$_POST['boxid']}");
		// 	}
		// }

		private function deduct_inventory($data)
		{
			return 	$this->itemInventoryModel->make_item($data);
		}

		private function add_cash($data)
		{
			$cashInventoryModel = new FNCashInventoryModel();

			return $cashInventoryModel->make_cash($data);
		}

		private function receive_code($paidCount)
		{
			if( $paidCount >= 4 ) {
				if(($paidCount % 4) == 0) 
					return true;
			}
			
			return false;
		}

		private function inventoryCodeInstance()
		{
			return new FNCodeInventoryModel();
		}
	}