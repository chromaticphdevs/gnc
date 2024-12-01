<?php

use Mpdf\Shaper\Sea;

use function PHPSTORM_META\map;

	class CashAdvance extends Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->cashAdvanceModel = $this->model('FNCashAdvanceModel');
			$this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
			$this->cashAdvanceReleaseModel = model('CashAdvanceReleaseModel');
			$this->caCoBorrowerModel = model('CashAdvanceCoBorrowerModel');
			$this->userNotificationModel = model('UserNotificationModel');
			$this->cashAdvanceAttrModel = $this->model('FNCashAdvanceAttributeModel');
			$this->RFID_Attendance_Check_Modal = $this->model('RFID_Attendance_Check_Modal');
			$this->user_model = $this->model('user_model');
			$this->userIdVerificationModel = model('UserIdVerificationModel');
			$this->loanlogModel = model('LoanlogModel');

			if(empty(whoIs())) {
				return redirect('users/login');
			}
		}
		//LOAN PROCESS
		
		/**
		 * if id is present that show
		 * filed agreement
		 */
		public function agreement($id = null) {
			$req = request()->inputs();
			
			if(isSubmitted()) {
				$post = request()->posts();

				if(isset($post['btn_agree'])) {
					if(isset($post['cbox_agree'])) {
						$resp = $this->cashAdvanceModel->agreementApproval($post['loan_id']);

						if($resp) {
							Flash::set("Agreement Approved!");
							return redirect('/CashAdvance/loan/'.seal($post['loan_id']));
						} else {
							Flash::set($this->cashAdvanceModel->getErrorString(), 'danger');
							return request()->return();
						}
					}
				}

				if(isset($post['btn_file_loan_request'])) {
					if(empty($post['loan']['cbox_agreement'])) {
						Flash::set("You must verify all confirmations are correct, by checking the checkbox");
						return request()->return();
					}
	
					$validCoBorrowers = [];
					if($post['coborrower']) {
						foreach($post['coborrower'] as $key => $row) {
							if(!empty($row['add']) && (!empty($row['name']) && !empty($row['mobile_number']))) {
								$validCoBorrowers[] = $row;
							}
						}
					}
	
					if(count($validCoBorrowers) < 1) {
						Flash::set('Atleast one Co-borrower must be present', 'danger');
						return request()->return();
					}
	
					/**
					 * check for borrowers if users exists.
					 * arrange loan data
					 */
					$loanData = [
						'userid' => $post['user_id'],
						'amount' => $post['loan']['amount'],
						'net'    => $post['loan']['amount'],
						'interest_rate' => $post['loan']['interest_rate'],
						'payment_method' => $post['loan']['payment_method'],
						'borrower_name'  => $post['borrower_name'],
						'borrower_address' => $post['borrower_address'],
						'coborrower' => $validCoBorrowers
					];
	
					$response = $this->cashAdvanceModel->addNewLoan($loanData);
	
					if($response) {
						Flash::set("Loan request Submitted");
						return redirect('/CashAdvance/agreement/'.seal($this->cashAdvanceModel->loanId));
					} else {
						Flash::set($this->cashAdvanceModel->getErrorString(), 'danger');
						return request()->return();
					}
				}
			}

			if(is_null($id)) {
				$user = $this->user_model->get_user(unseal($req['userId']));
				$data = [
					'loanInterestRate' => '10%',
					'amount' => unseal($req['amount']),
					'user' => $user,
					'borrowerName' => "{$user->firstname} {$user->lastname}",
					'loanTerms' => '60 Days',
					'loanPaymentMethod' => '100 pesos per day or 3,000per month',
					'userId' => $user->id,
					'req' => $req
				];
				return $this->view('cash_advance/agreement', $data);
			} else {
				// view agreement form
				$loanId = unseal($id);
				$loan = $this->cashAdvanceModel->getLoan($loanId);

				$borrowerSelfie =  $this->userIdVerificationModel->get([
					'where' => [
						'upi.type' => listOfValidIds()[17],
						'upi.userid' => $loan->userid
					]
				]);
				
				return $this->view('cash_advance/agreement_view', [
					'loanId' => $id,
					'loan'   => $loan,
					'loanTerms' => '60 Days',
					'loanPaymentMethod' => '100 pesos per day or 3,000per month',
					'borrowerSelfie' => $borrowerSelfie,
					'req' => $req
				]);
			}
		}

		public function notifications() {
			$coborrowers = $this->caCoBorrowerModel->getAll();
			$notifications = $this->userNotificationModel->getAll([
				'where' => [
					'user_id' => whoIs()['id']
				]
			]);
			
			$data = [
				'notifications' => $notifications
			];

			return $this->view('cash_advance/coborrowers', $data);
		}
		/**
		 * if id is present that show
		 * loan details
		 */
		public function loan($id = null) {
			$id = unseal($id);
			$coborrowers = $this->caCoBorrowerModel->getAll([
				'where' => [
					'cacb.fn_ca_id' => $id
				]
			]);

			$data = [
				'loan' => $this->cashAdvanceModel->getLoan($id),
				'coborrowers' => $coborrowers,
				'navigationHelper' => $this->navigationHelper,
				'payments' => $this->cashAdvancePaymentModel->getAll([
					'where' => [
						'payment.ca_id' => $id
					],
					'order' => 'payment.id desc'
				]),
				'cashAdvanceRelease' => $this->cashAdvanceReleaseModel->get([
					'where' => [
						'cdr.ca_id' => $id
					]
				]),
				'navigationHelper' => $this->navigationHelper,
				'penalties' => $this->loanlogModel->getLoanPenalties($id)
			];

			return $this->view('cash_advance/loan', $data);
		}

		public function coborrower() {
			$data = [
				'coBorrowers' => $this->caCoBorrowerModel->getAll([
					'where' => [
						'cacb.co_borrower_id' => whoIs()['id']
					],
				])
			];
			return $this->view('cash_advance/coborrower', $data);
		}
		//LOAN PROCESS
		public function create()
		{
			$userid = Session::get('USERSESSION')['id'];

			/*ADD AUTHORIZATION*/
			if($this->request() === 'POST')
			{
				$result = $this->cashAdvanceModel->create_auto_loan(new LDCashAutoLoanObj , $userid);

				if($result)
				{
					Flash::set("Cash Advance Sent");
				}

				redirect('CashAdvance/create');
			}else
			{
				$data = [
					'title' => 'Cash Advances' , 
					'cashAdvances' => $this->cashAdvanceModel->get_list($userid)
				];

				$list = $this->cashAdvanceModel->get_list($userid);

				if(empty($list))
				{

					$result = $this->cashAdvanceModel->create_auto_loan(new LDCashAutoLoanObj , $userid);

					if($result)
					{
						Flash::set("Cash Advance Sent");
						redirect('CashAdvance/create');
					}

				}

				$this->view('cashadvances/create' , $data);
			}
			
		}

		public function attendance_list()
		{
			$userid = Session::get('USERSESSION')['id'];

			/*ADD AUTHORIZATION*/
			if($this->request() === 'POST')
			{
				
			}else
			{
				$data = [
					'title' => 'Cash Advances' , 
					'attendance_list' => $this->RFID_Attendance_Check_Modal->list($userid)
					
				];

				$this->view('cashadvances/attendance_list' , $data);
			}	
		}

		public function modifyloanAmount($loanId) {
			$loanId = unseal($loanId);
			if(isSubmitted()) {
				$post = request()->posts();
				$resp = $this->cashAdvanceModel->modifyLoanAmountAutoCompute($loanId, $post['loan_amount']);

				if(!$resp) {
					Flash::set($this->cashAdvanceModel->getErrorString(), 'danger');
					return request()->return();
				} else {
					Flash::set("Loan Amount updated");
					return redirect('CashAdvance/loan/'.seal($loanId));
				}
			}
			$loan = $this->cashAdvanceModel->getLoan($loanId);

			$data = [
				'loan' => $loan,
				'navigationHelper' => $this->navigationHelper
			];

			return $this->view('cash_advance/modify_loan', $data);
		}
	}