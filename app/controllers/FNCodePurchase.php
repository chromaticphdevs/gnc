<?php 	

	class FNCodePurchase extends Controller
	{

		public function __construct()
		{
			$this->codeInventoryModel = $this->model('FNCodeInventoryModel');
			$this->branchModel = $this->model('FNBranchModel');

			$this->codePurchaseModel = $this->model('FNCodePurchaseModel');
			$this->userModel = $this->model('User_model');
		}

		public function make_purchase()
		{
			if($this->request() === 'POST') 
			{
				$codeid = $_POST['codeid'];
				$userid = $_POST['userid'];
				$cashierId =Session::get('BRANCH_MANAGERS')->id;

				// dd($codeid);

				for($row = 0; $row < count($codeid); $row++)
                {
					$code = $this->codeInventoryModel->get_code($codeid[$row]);

					/*check if there is available code*/
					$give_code_to_user = $this->codeInventoryModel->releaseToUser($code,$userid);
					
					if(!$give_code_to_user) 
						return redirect('FNCodeInventory/purchase_code');

					/*insert into code purchase*/
					$purchase_code = $this->codePurchaseModel->make_purchase($userid , $codeid[$row] , $code->branchid);
					/*
					*This code is redundunt code update to released already on 
					***codeInventoryModel::release code
					*$release_code = $this->codeInventoryModel->update_status($codeid[$row] , 'released');
					*/
					$user = $this->userModel->get_user($userid);
					/*addCash*/
					$data = [
						'branchid'      => $code->branchid,
						'amount'        => $code->amount,
						'cashier_id'    => $cashierId,
						'description'   => "Code #{$code->code} was purchased by {$user->fullname}"
					];

					$make_cash = $this->cashInventoryModelInstance()->make_cash($data);
					//deduct box quantity of a code purchased

					/*
					*Not called function
					*$branchInventoryTotal = $this->itemInventoryModelInstance()->get_branch_inventory();
					*/

					$this->codePurchaseModel->update_status_search_codeid($codeid[$row] , 'claimed');
					/*deduct to inventory*/

					/*
					*Redundunt call
					*$code = $this->codeInventoryModel->get_code($codeid[$row]);
					*/
					$data = [
						'quantity' => ($code->box_eq * -1),
						'description' => "Code purcase item claim , Activation code: {$code->code}",
						'branchid'   => $code->branchid
					];

					$inventoryDeduct = $this->itemInventoryModelInstance()->make_item($data);
					//deduct box quantity of a code purchased end

				}
				
				if($purchase_code && $give_code_to_user && $make_cash)
				{	
					Flash::set("Purchase done successfully, PLease Open your account to view  claiming codes" , 'success');
					redirect('FNCodeInventory/purchase_code');	
				}
			}
		}


		public function claim_purchase() 
		{
			if($this->request() === 'POST')
			{
				$branchSession = Session::get('BRANCH_MANAGERS');

				$purchaseid = $_POST['purchaseid'];
				/*claim*/
				$purchasedCode = $this->codePurchaseModel->get_purchase($purchaseid);

				$branchInventoryTotal = $this->itemInventoryModelInstance()->get_branch_inventory;

				$this->codePurchaseModel->update_status($purchaseid , 'claimed');
				/*deduct to inventory*/

				$code = $this->codeInventoryModel->get_code($purchasedCode->codeid);

				$data = [
					'quantity' => ($code->box_eq * -1),
					'description' => "Code purcase item claim , purchase reference :#{$purchasedCode->reference}",
					'branchid'   => $branchSession->branchid
				];

				$inventoryDeduct = $this->itemInventoryModelInstance()->make_item($data);


				if($inventoryDeduct) {

					Flash::set("Trasnaction Complete..");
					redirect('FNCodeInventory/purchase_code');
				}

			}else{

				$data = [
					'title' => 'Code Item Claim Area'
				];

				if(isset($_GET['reference']))
				{
					$reference = $_GET['reference'];

					$data['reference'] = $reference;

					$codePurchased = $this->codePurchaseModel->get_by_reference($reference);

					$data['codePurchased'] = $codePurchased;
					
					if(!empty($codePurchased)) {

						$code = $this->codeInventoryModel->get_code($codePurchased->codeid);
						$user = $this->userModel->get_user($codePurchased->userid);

						$data['code']  = $code; 
						$data['userinfo']  = $user;
					}
				}

				$this->view('finance/singlebox/claim_assistance_search' , $data);
			}	
		}

		public function preview($purchaseid) 
		{
			$purchaseid = unseal($purchaseid);

			$purchase = $this->codePurchaseModel->get_purchase($purchaseid);

			$data = [
				'codepurchase' => $purchase , 
				'code'         => $this->codeInventoryModel->get_code($purchase->codeid) ,
				'userinfo'      => $this->userModel->get_user($purchase->userid)
			];

			return $this->view('finance/code_purchase/view' , $data);
		}

		private function cashInventoryModelInstance()
		{
			return new FNCashInventoryModel();
		}

		private function itemInventoryModelInstance()
		{
			return  new FNItemInventoryModel();
		}
	}