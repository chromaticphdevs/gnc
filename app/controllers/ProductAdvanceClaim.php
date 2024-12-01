<?php 	

	class ProductAdvanceClaim extends Controller
	{

		public function __construct()
		{
			$this->productAdvanceClaimModel = $this->model('ProductAdvanceClaimModel');
		}
		public function claim_product()
		{
			$data = [
				'title' => 'Claim Product Advance'
			];

			if($this->request() === 'POST')
			{

				if(isset($_POST['searchandclaim']))
				{
					$result = $this->productAdvanceClaimModel->claim_product($_POST['code']);

					if($result) {
						Flash::set("Product Allowance Claimed code {$_POST['code']}");
					}
				}

				if(isset($_POST['searchonly']))
				{
					$result = $this->productAdvanceClaimModel->get_code($_POST['code']);

					$userModel = $this->model('User_model');

					if(!empty($result))
					{
						$data['loanProduct'] = $result;

						$data['borrower']    = $userModel->get_user($result->userid);
					}
				}

				if(isset($_POST['claimandpay']))
				{

					$result = $this->productAdvanceClaimModel->claim_pay_product($_POST['code']);

					if($result) {
						Flash::set("Product Advance Paid #{$_POST['code']}");
					}
				}

				if(isset($_POST['pay']))
				{
					$result = $this->productAdvanceClaimModel->pay_product($_POST['code']);

					if($result) {
						Flash::set("Product Advance Paid #{$_POST['code']}");
					}
				}
				

				redirect('stockManager/get_codes');
			}
		}
	}
