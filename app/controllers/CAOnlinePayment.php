<?php
	use Bank\Pera;

	require_once CLASSES.DS.'banks/Pera.php';

	class CAOnlinePayment extends Controller
	{

		private $account_types = [
			'stock-manager' , 'cashier' , 'branch-manager','cashier-assistance'
		];

		public function __construct()
		{
			$this->CashAdvancePaymentModel   = $this->model('FNCashAdvancePaymentModel');
			$this->CashAdvanceModel          = $this->model('FNCashAdvanceModel');
			$this->cashInventoryModel        = $this->model('FNCashInventoryModel');
			$this->mgPayoutModel             = $this->model('MGPayoutModel');
			$this->userModel                 = $this->model('User_model');
			$this->User_Account_Model        = $this->model("UserAccountModel");
			$this->mgPayoutItemModel         = $this->model('MGPayoutItemModel');

			$this->bank = $this->model('BankPeraModel');
		}


		/* CUSTOMER MAKING PAYMENT */
		public function customer_payment($loanId)
		{	

			$user_id = Session::get('USERSESSION')['id'];

			$bank_account = $this->bank->getByUser($user_id);

			if(empty($bank_account))
				return redirect("bank/create/");

			/*
			*loan_id is id from fn_cash_advances
			*/
			$loan_id = unseal($loanId);

			$user = $this->userModel->get_user($user_id);
			$userCashPayment = new FNCashAdvancePaymentUserModel($user_id,$loan_id);
			$userCashAdvance = new FNCashAdvanceUserModel($user_id,$loan_id);

			$data = [
				'title' => 'Customer Payment',
				'user'  => [
					'balance'  => $userCashAdvance->getBalance(),
					'payments' => $userCashPayment->getTotal(),
					'totalCashAdvance' => $userCashAdvance->getTotal(),
					'payments_history' => $userCashPayment->getPaymentHistory(),
					'info' => $user,
					'loan_info' =>  $userCashAdvance->getLoanInfo(),
					'bank_account' => $bank_account->account_number
				],
				'loan_id' => $loan_id
			];

			return $this->view('finance/cash_advance_payment/online_payment' , $data);
		}


		/*  MAKING ONLINE PAYMENT ACTION */
		public function store()
		{
			$post = request()->inputs();
		
			$user_id = $post['user_id'];

			$user = $this->userModel->get_user($user_id);

		    $amount = preg_replace("/a-Z -_@/" , '' , $post['amount']);

			if(!is_numeric($amount)) {
				Flash::set("Amount must be a valid number" , 'danger');
				return request()->return();
			}

			// proccess to pera e *****************
			$pera_class = new Pera();

			$peraAccount = $this->bank->getByUser($user_id);

			/**
			 * Validate if user has pera account
			 */
			if(!$peraAccount)
				return $this->addError("{$user->fullname} ,No pera account , your payout request is subject for confirmation");
			
			/**
			 * Try connecting account to 
			 * Pera-E API
			 */
			$isConnected = $pera_class->connectAuth($peraAccount->api_key , $peraAccount->api_secret);

			if(!$isConnected)
				return $this->addError("{$user->fullname} Cannot connect to pera-e.com!");

			$description = "Online Payment for Cash Advance #{$post['loan_code']}";
			
			//access pera e payment
			$result = $pera_class->deductMoney(...[$amount,$post['loan_code'],$description]);

			if(!$result)
			{	
				Flash::set(" Something wen't wrong to the third party", 'danger');
				return request()->return();
			}else
			{	
			    $bank_res = json_decode($result);

				if($bank_res->status == 'false')
				{
					Flash::set($bank_res->data, 'danger');
					return request()->return();
				}
			}


			$code = $this->CashAdvancePaymentModel->make_code();

			$payment = $this->CashAdvancePaymentModel->store([
				'userid'     => $user_id,
				'loanid'     => $post['loan_id'],
				'code'       => $code,
				'amount'     => $amount,
				'path'       => 'N/A',
				'cashier_id' => $user_id,
				'branch_id'  => $user->branchId,
				'category'   => "Online Payment"
			]);


			/*INSERT LOGS*/
			$payment_info = "Cash Advance Payment code $code using Pera-e ref# {$bank_res->data} ,Payment by : <b>{$user->fullname}</b>";
			$logs = $this->cashInventoryModel->make_cash([
				'branchid' => $user->branchId,
				'amount'   => $amount,
				'description' =>$payment_info
			]);


			/*UPDATE CASH ADVANCE REQUEST*/
			$userCashAdvance = new FNCashAdvanceUserModel($user_id,$post['loan_id']);

			/*CHECK IF USER HAS NO OUTSTANDING BALANCE*/
			if($userCashAdvance->getBalance() <= 0) {
				/*UPDATE ALL USERS CASH ADVANCE REQUEST TO PAID*/
				$this->CashAdvanceModel->setAllApprovedToPaid($user_id);
			}

			$msg = "Payment Successfully Processed ref# {$bank_res->data}";
			if($payment && $logs) {

				$phoneNumber = $post['bank_account'];
	            $content = "Your payment of P{$amount} to Breakthrough Cash Advance has been successfully processed ref# {$bank_res->data}";

             	$sendSmsData = [
	                'mobile_number' => $phoneNumber,
	                'content'      => $content,
	                'category' => 'SMS'
              	];

	            //send sms
	            $sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $sendSmsData);
	            $sms = json_decode($sms);

				Flash::set($msg);
				return redirect("FNAccount/loan_payments_info");
			}else{
				die("Something went wrong");
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


	}
?>
