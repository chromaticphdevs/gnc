<?php 	
	use PeraE\Checkout\IndividualToBusiness\Checkout;

	require_once LIBS.DS.'perabusiness/individual_to_business/Checkout.php';

	class FNCashAdvancePaymentOnline extends Controller
	{

		public function __construct()
		{
			parent::__construct();

			$this->cashInventoryModel = model('FNCashInventoryModel');

			$this->cashAdvanceModel = model('FNCashAdvancePaymentModel');

			$this->userModel  = model('User_model');
		}
		public function pay()
		{
			$q = request()->inputs();

			$userId  = $q['user_id'];
			$loanId = $q['loan_id'];

			$payerAuth = $q['payer'];
			$payeeAuth = $q['payee'];

			$amount = preg_replace("/a-Z -_@/" , '' , $q['amount']);

			$user = $this->userModel->get_user($q['user_id']);

			$checkout = new Checkout();


			$links = [
				'success' => 'www.google.com',
				'failed'  => 'www.stackoverflow.com'
			];

			$checkout->setPayer([
				'key' => $payerAuth['key'],
				'secret' => $payerAuth['secret']
			]);

			$checkout->setPayee([
				'key' => $payeeAuth['key'],
				'secret' => $payeeAuth['secret'],
			]);	

			
			$checkout->setBody([
				'amountBreakdown' => [
					'amount' => $amount,
					'description' => 'Cash Advance Payment'
				],
				'referenceId'  => 1,
				'domain'    => 'www.pera-e.com',
				'origin'    => 'www.breakthrough-e.com',
				'links'     => [
					'www.accept.com',
					'www.cancel.com'
				]
			]);

			$isCheckedOut = $checkout->send();

			if($isCheckedOut)
			{
				$payloads = [
					'payerFullname' => $user->fullname,
					'userId'     => $userId,
					'loanId'     => $loanId,
					'amount'     => $amount,
					'cashierId' => '0',
					'branchId'  => $user->branchId,
					'category'   => $this->cashAdvanceModel::$category[2],
					'amount'     => $amount,
					'path'       => 'ca_payments',
				];

				$paid = $this->cashAdvanceModel->pay($payloads);

				$checkoutResponse = $checkout->response->data;

				$checkoutData = json_decode($checkoutResponse);

				Flash::set("Paid Failed !" , 'danger');
				if($isCheckedOut && $paid){
					Flash::set("Payment Successful, Pera-E Reference# : {$checkoutData->controlNumber} ");
				}
				
			}else{
				Flash::set( $checkout->getErrorString() , 'danger');
			}
			
			return request()->return();
		}
	}