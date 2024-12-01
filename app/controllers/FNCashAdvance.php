<?php
	use Classes\Loan\LoanService;
	use Services\CashAdvanceService;

	load(['LoanService'], CLASSES.DS.'Loan');
    load(['CashAdvanceService'], APPROOT.DS.'services');

	class FNCashAdvance extends Controller
	{
		private $account_types = [
			'stock-manager' , 'cashier' , 'branch-manager','cashier-assistance'
		];


		public function __construct()
		{
			parent::__construct();
			$this->CashAdvanceModel = $this->model('FNCashAdvanceModel');
			$this->userModel = $this->model('user_model');
			$this->userLog = model('UserLoggerModel');
			$this->identificationModel = model('IdentificationModel');
			$this->loanModel = model('LoanModel');
			$this->loanQualifierModel = model('LoanQualifierModel');
			$this->userBankModel = model('UserBankModel');
			$this->cashAdvanceReleaseModel = model('CashAdvanceReleaseModel');

			$this->caCoBorrowerModel = model('CashAdvanceCoBorrowerModel');
            $this->userIdVerificationModel = model('UserIdVerificationModel');
			$this->loanProcessorVideoModel = model('LoanProcessorVideoModel');

			authRequired();
		}

		/**
		 * display qualifiers if page isset to qualifier
		 * initially show user with loans
		 */
		public function index() {
			$req  = request()->inputs();

			$itemsPerPage = 10;
			$curPage = $req['page'] ?? 1;
			$offset = ($curPage - 1) * $itemsPerPage;

			if(isEqual(whoIs('type'), USER_TYPES['MEMBER'])) {
				$loans = $this->CashAdvanceModel->fetchAll([
					'order' => 'cd.id desc',
					'limit' => "{$offset}, {$itemsPerPage}",
					'where' => [
						'cd.userid' => whoIs('id')
					]
				]);
	
				$loansTotal = $this->CashAdvanceModel->count([
					'where' => [
						'userid' => whoIs('id')
					]
				]);
			} else {
				$loans = $this->CashAdvanceModel->fetchAll([
					'order' => 'cd.id desc',
					'limit' => "{$offset}, {$itemsPerPage}",
					'where' => [
						'cd.status' => 'pending'
					]
				]);
	
				$loansTotal = $this->CashAdvanceModel->count([
					'where' => [
						'status' => 'pending'
					]
				]);
			}
			

			$data = [
				'loans' => $loans,
				'pagination' => [
					'totalItemCount' => $loansTotal,
					'itemsPerPage'    => $itemsPerPage
				]
			];
			return $this->view('cash_advance/index', $data);
		}

		public function approveQualifier() {
			$req = request()->inputs();
			if(isSubmitted()) {
				$result = $this->loanQualifierModel->approve($req);
				if($result) {
					Flash::set("Qualifier approved");
					return redirect('FNCashAdvance/index?page=qualifiers_approved');
				}
			}
		}

		public function apply() {

			$req = request()->inputs();
			$user  = whoIs();
			$userId = $user['id'];

			if(isSubmitted()) {
				$loanId = $this->loanModel->addLoan([
					'user_id' => $userId,
					'amount'  => $req['amount_to_borrow'],
					'entry_date' => today(),
					'entry_origin' => LoanService::CASH_ADVANCE 
				]);

				if($loanId) {
					Flash::set("Loan Applied");
					return redirect('FnCashAdvance');
				}
			}

			if(empty($req['amount'])) {
				Flash::set("Invalid request");
				return redirect('FnCashAdvance/apply_now');
			}
			$amount = unseal($req['amount']);

			$qrLogins = $this->userLog->getLogs([
				'where' => [
					'userid' => $userId,
					'type' => 'QR_CODE'
				]
			]);

			$uploadedIds = $this->identificationModel->getByUser($userId);
			$referrals = $this->userModel->getDirects($userId);
			$loans = $this->loanModel->getAll([
				'where' => [
					'loan.user_id' => $userId,
					'entry_origin' => LoanService::CASH_ADVANCE
				]
			]);
			
			$data = [
				'amountApply' => $req['amount'],
				'userId' => $userId,
				'requirements' => [
					'uploadedIds' => $uploadedIds,
					'referrals' => $referrals,
					'qrLogins' => $qrLogins
				],
				'loans' => $loans,
				'amount' => $amount
			];

			return $this->view('cash_advance/apply', $data);
		}

		private function loanView() {
			$whoIs = whoIs();
			$loans = $this->CashAdvanceModel->get_list_by_user($whoIs['id']);

			return $this->view('');
		}
		public function apply_now()
		{	

			return $this->loanView();
				
			$this->check_session();
			$userid = Session::get('USERSESSION')['id'];
			$branchid = Session::get('USERSESSION')['branchId'];
			$userCashPayment = new FNCashAdvancePaymentUserModel($userid,null);
			/*ADD AUTHORIZATION*/

			$data = [
				'title' => 'Cash Advances'
			];

			$loans = $this->CashAdvanceModel->get_list_by_user($userid);

			// if(empty($loans))
			// {
			// 	$result = $this->CashAdvanceModel->create_auto_loan(new LDCashAutoLoanObj , $userid, $branchid);
			// 	if($result)
			// 	{
			// 		Flash::set("Cash Advance Sent");
			// 		redirect('FNCashAdvance/create');
			// 	}
			// }

			$data['payments'] = $userCashPayment->getTotal();
			$data['userid']     = Session::get('USERSESSION')['id'];
			$data['loans'] = $loans;

			return $this->view('finance/cash_advance/apply_now' , $data);
		}

		public function findForRelease() {
			$req = request()->inputs();
			$previousId = unseal($req['previous']);
			
			$loans = $this->CashAdvanceModel->fetchAll([
				'order' => 'RAND()',
				'limit' => 1,
				'where' => [
					'cd.status' => 'pending',
					'cd.id' => [
						'condition' => 'not equal',
						'value' => $previousId
					]
				]
			]);

			if(!$loans) {
				Flash::set("No more loans to process");
				return redirect('FnCashAdvance/index');
			} else {
				Flash::set("Proess new loan");
				return redirect('FNCashAdvance/release/'.seal($loans[0]->ca_id));
			}
		}


		/**
		 * BELLOW CODES ARE SUBJECTED TO CLEAN-UP
		 */


		public function register_just_now()
		{

			$data = [
				'title'       => 'Register Just Now',
				'register_just_now' => $this->CashAdvanceModel->get_list_register_just_now()

			];

			return $this->view('finance/cash_advance/login_now' , $data);

		}



		public function create()
		{	
			$this->check_session();
			$userid = Session::get('USERSESSION')['id'];
			$branchid = Session::get('USERSESSION')['branchId'];
			$userCashPayment = new FNCashAdvancePaymentUserModel($userid,null);
			/*ADD AUTHORIZATION*/

			$data = [
				'title' => 'Cash Advances' ,
				'cashAdvances' => $this->CashAdvanceModel->get_list_by_user($userid)
			];

			$list = $this->CashAdvanceModel->get_list_by_user($userid);

			if(empty($list))
			{

				$result = $this->CashAdvanceModel->create_auto_loan(new LDCashAutoLoanObj , $userid, $branchid);
				if($result)
				{
					Flash::set("Cash Advance Sent");
					redirect('FNCashAdvance/create');
				}

			}

			$data['payments'] = $userCashPayment->getTotal();
			$data['userid']     = Session::get('USERSESSION')['id'];

			return $this->view('finance/cash_advance/create' , $data);
		}

		public function qualification_list_by_branch()
		{

			$user = Session::get('BRANCH_MANAGERS');
			$branchid = $user->branchid;

			$data = [
				'title'       => 'Qualification Status List',
				'user_list' => $this->CashAdvanceModel->qualification_get_list_by_branch($branchid)

			];

			return $this->view('finance/cash_advance/qualification' , $data);
		}

		public function qualification_list_all()
		{

			$data = [
				'title'       => 'Qualification Status List',
				'user_list' => $this->CashAdvanceModel->qualification_get_list_all()

			];

			$this->view('finance/cash_advance/qualification' , $data);

		}

		public function approval_list_all()
		{

			$data = [
				'title'       => 'Approval List',
				'results'     => $this->CashAdvanceModel->approved_list_all()

			];
			return $this->view('finance/cash_advance/approval' , $data);
		}

		/*
		*OLD VERSION
		*New function approve
		*/
		public function update_status_approve($loanID)
		{
			 $user = Session::get('USERSESSION');
			 $userid = $user['id'];

			 $class  = $this->CashAdvanceModel->update_status_approve($loanID, $userid);
		}


		/**
		*NEW VERSION OF update_status_approve method
		*
		*/
		public function approve()
		{
			//check if redirecto to is set
			$redirectTo = request()->input('redirectTo') ?? '';




			/*$data = [
				$sponsorid ,
				$purchaser,
				'UNILEVEL',
				$unilvl,
				$origin
			];
			CommissionTransactionModel::make_commission(...$data);
			*/

			$user = Session::get('USERSESSION');
			$cashAvanceId = $_POST['ca_id'];
			/*get loan info*/
			$loan         = $this->CashAdvanceModel->dbget($cashAvanceId);

			$approvedBy =  $user['id'];

			/***
			** LOAN VALIDATION**
			****/

			/*
			*check if user has s
			*/
			$hasApproved = $this->CashAdvanceModel->getApprovedByUser($loan->userid);

			if($hasApproved) {
				Flash::set("User has approved loans , cannot create loan" , 'warning');
				return request()->return();
			}


			$approveLoan = $this->CashAdvanceModel->approveLoan($cashAvanceId , $approvedBy);
			
			$loan        = $this->CashAdvanceModel->getWithBranch($cashAvanceId);


			$data = [
				$loan->userid,
				$approvedBy,
				'CASH-ADVANCE',
				$loan->net,
				$loan->branch_name
			];

			CommissionTransactionModel::make_commission(...$data);

			Flash::set("Loan has been approved by {$user['username']}");

			if(!$approveLoan)
				Flash::set("Something went wrong report to webmasters");

			if(!empty($redirectTo))
				return redirect($redirectTo);

			return redirect("FNCashAdvance/request_list_all");
		}


		public function update_status_approve_request($loanID)
		{
			 $user = Session::get('USERSESSION');
			 $userid = $user['id'];

			 $class  = $this->CashAdvanceModel->update_status_approve($loanID, $userid, 1);

		}

		/*
		*Apply for cash advance
		**/
		public function requestCashAdvance()
		{
			$user_id = $_POST['user_id'];
			$amount  = $_POST['amount'];

			$userCashAdvance = new FNCashAdvanceUserModel($user_id,null);
			$user            = $this->userModel->get_user($user_id);

			/*check if user has
			*un-settled loan
			*/
			$balance = $userCashAdvance->getBalance();

			if($balance > 0) {
				Flash::set("You have an outstanding balance of {$balance}." , 'warning');
				return redirect("FNCashAdvance/create");
			}
			/*
			*check if has pending
			*/
			$hasPending = $this->CashAdvanceModel->getPendingByUser($user_id , $amount);
			if($hasPending)
			{
				Flash::set("You have a pending request, check your cash advance list for details" , 'warning');
				return redirect("FNCashAdvance/create");
			}

			/*
			*check if re-loaning currenly paid cash-advance
			*/
			// $isReloan = $this->CashAdvanceModel->isReloan($amount , $user_id);
			/*
			*if no balance then create loan
			*/
			$loanResult = $this->CashAdvanceModel->store([
				'userid' => $user->id,
				'branch_id' => $user->branchId,
				'amount' => $amount,
				'date'   => today(),
				'time'   => getTime(),
				'notes'  => 'Self Loan'
			]);

			Flash::set("Loan success");
			if(!$loanResult) {
				Flash::set("Something went wrong report to webmaster" , 'danger');
			}
		
			return redirect("FNCashAdvance/create");
		}

		public function request_approval($loanID)
		{

			$class  = $this->CashAdvanceModel->request_approval($loanID);

		}

		public function release($id = null) {
			if(!isEqual(whoIs('type'), [USER_TYPES['ADMIN'], USER_TYPES['ENCODER_A']])) {
				Flash::set('Unauthorized access', 'danger');
				return request()->return();
			}

			$req = request()->inputs();

			if(is_null($id)) 
			{
				// $data = [
				// 	'releases' => $this->cashAdvanceReleaseModel->getAll([
				// 		'order' => 'id desc'
				// 	])
				// ];
				// return $this->view('cash_advance/release', $data);
			} else {
				$loanId = unseal($id);
				
				if(isSubmitted()) {
					$post = request()->posts();
					/**
					 * check if amount is changed 
					 * then update the loan amount
					 */
					$loan = $this->CashAdvanceModel->fetchOne([
						'where' => [
							'cd.id' => unseal($post['loan_id'])
						]
					]);

					$amount = convert_to_number($post['loan_amount']);
					$serviceFeeAmount = convert_to_number($post['service_fee']);
					$attorneeFeeAmount = convert_to_number($post['attornees_fee']);
					$interestRateFeeAmount = convert_to_number($post['interest_rate_amount']);
					$interestRateSetting = convertInterestRateToDecimal(abs($post['interest_rate_interest_setting']));
					if(!is_numeric($amount) || $amount < 1) {
						Flash::set("Invalid Amount", 'danger');
						return request()->return();
					}

					if(!empty($serviceFeeAmount) && !is_numeric($serviceFeeAmount)) {
						Flash::set("Invalid Service Fee Amount", 'danger');
						return request()->return();
					}

					if(!empty($attorneeFeeAmount) && !is_numeric($attorneeFeeAmount)) {
						Flash::set("Invalid Attornee Fee Amount", 'danger');
						return request()->return();
					}

					if(!empty($interestRateFeeAmount) && !is_numeric($interestRateFeeAmount)) {
						Flash::set("Invalid Loan Interest Fee", 'danger');
						return request()->return();
					}

					$totalBalance = $amount + $serviceFeeAmount + $attorneeFeeAmount + $interestRateFeeAmount;
					
					$this->CashAdvanceModel->dbupdate([
						'amount' => $amount,
						'service_fee' => $serviceFeeAmount,
						'attornees_fee' => $attorneeFeeAmount,
						'interest_rate_amount' => $interestRateFeeAmount,
						'net' => $totalBalance,
						'balance' => $totalBalance,
						'interest_rate' => $interestRateSetting
					], $loan->ca_id);
					
					$resp = $this->cashAdvanceReleaseModel->release(unseal($post['loan_id']), $post['external_reference']);

					if($resp) {
						Flash::set("loan released");
						return redirect('CashAdvanceReleaseController/show/'.$resp);
					} else {
						echo die('unable to post cash advance reelase');
					}
				}
				$selfieWithId = listOfValidIds()[17];

				$loan = $this->CashAdvanceModel->fetchOne([
					'where' => [
						'cd.id' => $loanId
					]
				]);
				
				if(isEqual($loan->ca_status, 'released')) {
					Flash::set("Invalid Action", 'danger');
					return request()->return();
				}

				$borrower = $this->userModel->get_user($loan->user_id);
				$directSponsor = $this->userModel->get_user($borrower->direct_sponsor);
				$loanProcessor = $this->userModel->get_user($borrower->loan_processor_id);

				$gotymeBank = $this->userBankModel->getGotyme($loan->user_id);
				
				$coBorrowers = $this->caCoBorrowerModel->getAll([
					'where' => [
						'fn_ca_id' => $loanId
					]
				]); 

				$borrowerSelfie =  $this->userIdVerificationModel->get([
					'where' => [
						'upi.type' => $selfieWithId,
						'upi.userid' => $loan->user_id
					]
				]);

				$directSponsorSelfie =  $this->userIdVerificationModel->get([
					'where' => [
						'upi.type' => $selfieWithId,
						'upi.userid' => $directSponsor->id
					]
				]);

				
				if($loanProcessor) {
					$loanProcessorSelfie = $this->userIdVerificationModel->get([
						'where' => [
							'upi.type' => $selfieWithId,
							'upi.userid' => $loanProcessor->id
						]
					]);
				}
				

				$borrowerIds = $this->userIdVerificationModel->getAll([
					'where' => [
						'upi.userid' => $loan->user_id,
						'upi.type'   => [
							'condition' => 'not equal',
							'value'     => $selfieWithId
						]
					]
				]);

				$resources = [
					'borrowerResources' => [
						'ids' => $borrowerIds,
						'video' => $borrower
					], 
					'cobborrowerResources' => [],
					'financialAdvisorResources' => [],
					'loanProcessorResources' => []
				];

				//selfie with id
				$coBorrowerids = [];
				if(!empty($coBorrowers)) {
					foreach($coBorrowers as $key => $row) {
						$coBorrowerids[$row->co_borrower_id] = $this->userIdVerificationModel->get([
							'where' => [
								'upi.status' => 'verified',
								'upi.type' => $selfieWithId,
								'upi.userid' => $row->co_borrower_id
							]
						]);
					}
				}
	
				foreach($coBorrowers as $key => $row) {
					$resources['cobborrowerResources'][$row->co_borrower_id] = [
						'ids' => $this->userIdVerificationModel->getAll([
							'where' => [
								'upi.userid' => $row->co_borrower_id,
								'upi.status' => 'verified',
								'upi.type'   => [
									'condition' => 'not equal',
									'value'     => $selfieWithId
								]
							]
						]),
						'video' => $this->userModel->get_user($row->co_borrower_id)
					];
				}
				
				if($directSponsor) {
					$resources['financialAdvisorResources'] = [
						'ids' => $this->userIdVerificationModel->getAll([
							'where' => [
								'upi.userid' => $directSponsor->id,
								'upi.status' => 'verified',
								'upi.type'   => [
									'condition' => 'not equal',
									'value'     => $selfieWithId
								]
							]
						]),
						'video' => $this->userModel->get_user($directSponsor->id)
					];
				}

				// if(!$gotymeBank) {
				// 	Flash::set("User has no Gotyme Bank, Unable to process loan releasing", 'danger');
				// 	return redirect('AccountProfile/index/?userid='.$loan->ca_userid);
				// }

				$data['loanProcessor'] = $loanProcessor;
				if($loanProcessor) {
					$resources['loanProcessorResources'] = [
						'ids' => $this->userIdVerificationModel->getAll([
							'where' => [
								'upi.status' => 'verified',
								'upi.userid' => $loanProcessor->id,
								'upi.type'   => [
									'condition' => 'not equal',
									'value'     => $selfieWithId
								]
							]
						]),
						'video' => $this->loanProcessorVideoModel->get([
							'where' => [
								'lp_video.loan_processor_id' => $loanProcessor->id
							]
						])
					];
				}

				$data = [
					'loan' => $loan,
					'gotymeBank' => $gotymeBank,
					'navigationHelper' => $this->navigationHelper,
					'borrower' => $borrower,
					'coBorrowers' => $coBorrowers,
					'resources' => $resources,
					'borrowerSelfie' => $borrowerSelfie,
					'coBorrowerids' => $coBorrowerids,
					'directSponsor' => $directSponsor,
					'directSponsorSelfie' => $directSponsorSelfie,
					'loanProcessor' => $loanProcessor,
					'loanProcessorSelfie' => $loanProcessorSelfie ?? false,
					'DUE_DATE_NO_OF_DAYS_DEFAULT' => CashAdvanceService::DUE_DATE_NO_OF_DAYS_DEFAULT
				];

				return $this->view('cash_advance/release_form', $data);
			}
		}

		public function process_ca()
		{
			$result =  $this->CashAdvanceModel->process_ca($_POST);

			if($result)
			{
				Flash::set("Cash Advance Sent");
				return request()->return();

			}else{
				Flash::set("Cash Advance Sent","danger");
				return request()->return();
			}
		}
		public function request_list_all()
		{

			$limit = 100;

			$data = [
				'title'       => 'Cash Advance Request List',
				'type'        => $_GET['show'] ?? 'pending'
			];

			if(isset($_GET['show']))
			{
				if($_GET['show'] == 'pending')
					$data['results'] = $this->CashAdvanceModel->unapproved_request_list($limit);
				if($_GET['show'] == 'approved')
					$data['results'] = $this->CashAdvanceModel->approved_list_all($limit);
			}else{
				$data['results'] = $this->CashAdvanceModel->unapproved_request_list($limit);
			}

			if(isset($_GET['searchUserMeta']))
				$data['results'] = $this->CashAdvanceModel->getByUserMeta(trim($_GET['userMeta']));


			return $this->view('finance/cash_advance/requests' , $data);
		}


		public function showByUser($userId)
		{
			$data = [
				'results' => $this->CashAdvanceModel->getUserLoans($userId)
			];

			return $this->view('finance/cash_advance/show_by_user' , $data);
		}

		public function cash_advance_list()
		{
			$branchid = $this->check_session();

			$data = [
				'title'       => 'Cash Advance List',
				'results' => $this->CashAdvanceModel->getByBranch($branchid)
			];

			return $this->view('finance/cash_advance/cash_advance_list' , $data);
		}

		public function api_fetch_all() {
			$req = request()->inputs();
			$keyword = $req['keyword'] ?? '';

			if(empty($keyword)) {
				$loans = $this->CashAdvanceModel->fetchAll([
					'order' => 'cd.id desc',
					'limit' => 10
				]);
			} else {
				$groupedCondition =  $this->CashAdvanceModel->convertWhere([
					'GROUP_CONDITION' => [
						'u.lastname' => [
							'condition' => 'like',
							'value'     => "%{$keyword}%",
							'concatinator' => 'OR'
						],
	
						'u.firstname' => [
							'condition' => 'like',
							'value'     => "%{$keyword}%",
							'concatinator' => 'OR'
						],
					]
				]);
	
				$groupedConditionB =  $this->CashAdvanceModel->convertWhere([
					'cd.code' => $keyword
				]);
	
				$loans = $this->CashAdvanceModel->fetchAll([
					'order' => 'cd.id desc',
					'limit' => "10",
					'where' => "{$groupedCondition} OR {$groupedConditionB}"
				]);
	
			}
			
			if($loans) {
				foreach($loans as $key => $row) {
					$row->id_sealed = seal($row->ca_id);
					$row->txt_amount = ui_html_amount($row->ca_amount);
					$row->txt_balance = ui_html_amount($row->ca_balance);
				}
			}
			echo api_response([
				'loans' => $loans
			]);
			
			return;
		}

		/**
		 * create autoloan for user
		 * use only when something went wrong in the system
		 * this can only be used for loan renewal
		 */
		public function autoloan() {
			if(isSubmitted()) {
				$post = request()->posts();

				$user = $this->userModel->getSingle([
					'where' => [
						'user.username' => $post['username']
					]
				]);

				if(!$user) {
					Flash::set("Unable to find user", 'danger');
					return request()->return();
				}

				$autoloan = $this->CashAdvanceModel->autoloan($user);

				if(!$autoloan) {
					Flash::set($this->CashAdvanceModel->getErrorString(),'danger');
					return request()->return();
				} else {
					Flash::set("Loan Created");
				}

				return redirect('FNCashAdvance/release/'. seal($this->CashAdvanceModel->_getRetval('loanId')));
			}
			
			$data = [];
			return $this->view('cash_advance/autoloan', $data);
		}
		
		public function loan($userId) {
			if(!isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
				return false;
			}
			$this->CashAdvanceModel->setLoanOptions([
				'bypass' => true
			]);
			$resp = $this->CashAdvanceModel->addNewLoan([
				'userid' => $userId,
				'amount' => 5000,
				'service_fee' => 500,
				'date' => today(),
				'interest_rate' => '10%',
				'coborrower' => [],
				'is_agreement_check' => true
			]);

			dump([
				$resp,
				'test',
				$this->CashAdvanceModel->getErrors()
			]);
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
