<?php 
	
	class Migration extends Controller
	{
		public function __construct()
		{
			$this->stepModel = model("FNUserStepsModel");
			$this->toc = model('TOCModel');
			$this->loan = model('LoanModel');

			$this->fnCashAdvanceModel = model('FNCashAdvanceModel');
			$this->cashAdvancePaymentModel = model('CashAdvancePaymentModel');
			$this->ledgerModel = model('LedgerModel');
			$this->loanLogModel = model('LoanlogModel');
		}
		
		public function rollBackPenalty()
		{
			$date = '2024-08-15';
			$dateNow = date('Y-m-d');
			$this->loanLogModel->db->query(
				"SELECT * FROM accounts_ledger
					WHERE category = 'PENALTY_ATTORNEES_FEE'
					AND ledger_source = 'CASH_ADVANCE_LEDGER'
					AND date(entry_dt) = '{$date}'"
			);

			$appliedPenalties = $this->loanLogModel->db->resultSet();
			foreach($appliedPenalties as $key => $row) {
				$paymentExist = $this->cashAdvancePaymentModel->get([
					'where' => [
						'ca_id' => $row->ledger_source_id, // represents loan_id	
						'entry_date' => $date 
					]
				]);
				//rollback payment
				if($paymentExist) {
					$description = "Reimbursement of attorney's fee penalty for date {$date}";
					//add ledger info
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $row->ledger_source_id,
						'ledger_user_id' => $row->ledger_user_id,
						'ledger_entry_amount' => $row->ledger_entry_amount,
						'ledger_entry_type' => 'deduction',
						'description' => $description,
						'entry_dt' => $dateNow,
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => 'REIMBURSE_PENALTY_ATTORNEES_FEE',
					];
					$ledgerInfo = array_values($ledgerInfo);
					$ledgerResponse = $this->ledgerModel->addLedgerEntry(...$ledgerInfo);
					//update loan balance
					$attFeeResponse = $this->fnCashAdvanceModel->addAttorneeFeePenalty($row->ledger_source_id, 
					($row->ledger_entry_amount * -1));
				}
			}
		}
		public function migrateCashAdvanceLedger() {
			$itemsToMigrate = [];
			$cash_advances = $this->fnCashAdvanceModel->fetchAll([
				'where' => [
					'cd.status' => 'released',
					'cd.id'  => 207
				]
			]);
			$payments  = [];
			$penalties = [];

			foreach($cash_advances as $key => $row) {

				$totalPayment = $this->cashAdvancePaymentModel->getTotalPayment($row->ca_id);
				$payment = $this->cashAdvancePaymentModel->get([
					'where' => [
						'ca_id' => $row->ca_id,
						'payment.payment_status' => 'approved',
					],
					'order' => 'id desc'
				]);

				$paymentDate = $payment->entry_date ?? $row->ca_release_date;
				$penalty = $this->loanLogModel->getLoanPenalties($row->ca_id);
				$penaltyTotalAmount = $penalty['totalAmount'];
				array_push($itemsToMigrate,[
					'loan_amount'   => [
						'amount' => $row->net,
						'date' => get_date($row->ca_release_date),
						'description'     => 'CASH-ADVANCE First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['CASH_ADVANCE'],
					],
					'total_payment' => [
						'amount' => $totalPayment,
						'date' => get_date($paymentDate),
						'description'     => 'PAYMENT First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['PAYMENT'],
					],
					'total_penalty' => [
						'amount' => $penaltyTotalAmount,
						'date' => get_date(today()),
						'description'     => 'PENALTY First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['PENALTY_ATTORNEES_FEE'],
					],
					'balance'       => ($row->net + $penaltyTotalAmount) - $totalPayment,
					'loan_id' => $row->ca_id,
					'user_id' => $row->user_id
				]);
			}

			foreach($itemsToMigrate as $key => $row) {
				$loan = $row['loan_amount'];
				$payment = $row['total_payment'];
				$penalty = $row['total_penalty'];
				$loanId = $row['loan_id'];
				$userId = $row['user_id'];

				if($loan) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $loan['amount'],
						'ledger_entry_type' => 'addition',
						'description' => $loan['description'],
						'entry_dt' => $loan['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $loan['category'],
					];

					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}

				if($penalty) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $penalty['amount'],
						'ledger_entry_type' => 'addition',
						'description' => $penalty['description'],
						'entry_dt' => $penalty['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $penalty['category'],
					];
					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}


				if($payment) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $payment['amount'],
						'ledger_entry_type' => 'deduction',
						'description' => $payment['description'],
						'entry_dt' => $payment['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $payment['category'],
					];

					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}
			}
		}

		public function migrateLedger()
		{
			//arrange by date
			$itemsToMigrate = [];
			$cash_advances = $this->fnCashAdvanceModel->fetchAll([
				'where' => [
					'cd.status' => 'released',
					'cd.id' => 153
				]
			]);

			$payments  = [];
			$penalties = [];
			foreach($cash_advances as $key => $row) {
				$totalPayment = $this->cashAdvancePaymentModel->getTotalPayment($row->ca_id);
				$payment = $this->cashAdvancePaymentModel->get([
					'where' => [
						'ca_id' => $row->ca_id,
						'payment.payment_status' => 'approved',
					],
					'order' => 'id desc'
				]);

				$paymentDate = $payment->entry_date ?? $row->ca_release_date;
				$attorneesFee = $row->attornees_fee;

				array_push($itemsToMigrate,[
					'loan_amount'   => [
						'amount' => $row->ca_amount,
						'date' => get_date($row->ca_release_date),
						'description'     => 'CASH-ADVANCE First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['CASH_ADVANCE'],
					],
					'total_payment' => [
						'amount' => $totalPayment,
						'date' => get_date($paymentDate),
						'description'     => 'PAYMENT First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['PAYMENT'],
					],
					'total_penalty' => [
						'amount' => $attorneesFee,
						'date' => get_date(today()),
						'description'     => 'PENALTY First Ledger Recording - date might be slightly off',
						'category' => LEDGER_CATEGORIES['PENALTY_ATTORNEES_FEE'],
					],
					'balance'       => ($row->net + $attorneesFee) - $totalPayment,
					'loan_id' => $row->ca_id,
					'user_id' => $row->user_id
				]);
			}

			 
			// const LEDGER_SOURCES = [
			// 	'CASH_ADVANCE_LEDGER' => 'CASH_ADVANCE_LEDGER',
			// 	'CASH_ADVANCE_LEDGER' => 'MEMBER_ACCOUNT_LEDGER'
			// ];

			foreach($itemsToMigrate as $key => $row) {
				$loan = $row['loan_amount'];
				$payment = $row['total_payment'];
				$penalty = $row['total_penalty'];
				$loanId = $row['loan_id'];
				$userId = $row['user_id'];

				if($loan) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $loan['amount'],
						'ledger_entry_type' => 'addition',
						'description' => $loan['description'],
						'entry_dt' => $loan['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $loan['category'],
					];

					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}

				if($penalty) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $penalty['amount'],
						'ledger_entry_type' => 'addition',
						'description' => $penalty['description'],
						'entry_dt' => $penalty['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $penalty['category'],
					];
					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}


				if($payment) {
					$ledgerInfo = [
						'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
						'ledger_source_id' => $loanId,
						'ledger_user_id' => $userId,
						'ledger_entry_amount' => $payment['amount'],
						'ledger_entry_type' => 'deduction',
						'description' => $payment['description'],
						'entry_dt' => $payment['date'],
						'status' => 'approved',
						'created_by' => 1,
						'updated_by' => 1,
						'category' => $payment['category'],
					];

					$ledgerInfo = array_values($ledgerInfo);
					$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
				}
			}
		}

		public function ledgerTest() {
			$ledgerInfo = [
				'ledger_source' => LEDGER_SOURCES['CASH_ADVANCE_LEDGER'],
				'ledger_source_id' => '194',
				'ledger_user_id' => '13074',
				'ledger_entry_amount' => 500,
				'ledger_entry_type' => 'addition',
				'description' => 'penaty',
				'entry_dt' => today(),
				'status' => 'approved',
				'created_by' => 1,
				'updated_by' => 1,
				'category' => 'penalty',
			];
			$ledgerInfo = array_values($ledgerInfo);
			$this->ledgerModel->addLedgerEntry(...$ledgerInfo);
		}

		public function migrateToStepPayment()
		{
			$usersWithloan = $this->loan->getAll();
			
			$migratedUsers = [];

			dump($usersWithloan);

			foreach($usersWithloan as $key => $user)
			{
				$paymentCheck = $user->payment_total <= 1399 && $user->payment_total >= 280;

				if(floatval($user->balance) < 1 && $paymentCheck) {
					if($this->migrate($user->id , $user->loan_id , 2)) {
						$migratedUsers [] = $user;
					}
				}
			}

			dump($migratedUsers);
		}


		//real

		public function migrateWithParam()
		{
			if( !isset( $_GET['position' ]))
				die("Request ERROR");

			$position = $_GET['position'];

			$usersWithloan = $this->loan->getAll();
			
			$migratedUsers = [];


			foreach($usersWithloan as $key => $user)
			{
				$paymentTotal = $user->payment_total;
				$loanAmount = $user->loan_amount;

				$balance = floatval($loanAmount - $paymentTotal);

				$condition = $this->condition( $balance ,  $paymentTotal , $position);

				if($condition){
					// $migrate = $this->migrate( $user->id , $user->loan_id , $position );
					// if($migrate)
						$migratedUsers [] = $user;
				}			
			}

			dump($migratedUsers);
		}

		private function condition( $balance , $paymentTotal , $position)
		{
			$retVal = false;

			if($balance > 0)
				return false;
				
			switch ($position) {
				case '3':
					if( $paymentTotal > 1405 && $paymentTotal <= 2485)
						$retVal = true;
					break;
				case '4':
					if( $paymentTotal > 2485 && $paymentTotal <= 3445 )
						$retVal = true;
					break;
				case '5':
				if( $paymentTotal > 3445 && $paymentTotal <= 4565 )
					$retVal = true;
				break;

				case '6':
				if( $paymentTotal > 4565 && $paymentTotal <= 5845 )
					$retVal = true;
				break;

				case '7':
				if( $paymentTotal > 5845 && $paymentTotal <= 7285 )
					$retVal = true;
				break;

				case '8':
				if( $paymentTotal > 7285 && $paymentTotal <= 8885 )
					$retVal = true;
				break;

				case '9':
				if( $paymentTotal > 8885 && $paymentTotal <= 10805 )
					$retVal = true;
				break;

				case '10':
				if( $paymentTotal > 10805 && $paymentTotal <= 13045 )
					$retVal = true;
				break;

				case '11':
				if( $paymentTotal > 13045 && $paymentTotal <= 15605 )
					$retVal = true;
				break;
				case '12':
				if( $paymentTotal > 15605 && $paymentTotal <= 18485 )
					$retVal = true;
				break;

				case '13':
				if( $paymentTotal > 18485 && $paymentTotal <= 21685 )
					$retVal = true;
				break;

				case '14':
				if( $paymentTotal > 21685 && $paymentTotal <= 25525 )
					$retVal = true;
				break;

				case '15':
				if( $paymentTotal > 25525 && $paymentTotal <= 30005 )
					$retVal = true;
				break;

				case '16':
				if( $paymentTotal > 30005 && $paymentTotal <= 34805 )
					$retVal = true;
				break;

				case '17':
				if( $paymentTotal > 34805 && $paymentTotal <= 40565 )
					$retVal = true;
				break;

				case '18':
				if( $paymentTotal > 40565 && $paymentTotal <= 46325 )
					$retVal = true;
				break;
			}
			
			return $retVal;
		}

		//migrate to step3
		public function migrateToStepThreeWithPayment()
		{
			$usersWithloan = $this->loan->getAll();
			
			$migratedUsers = [];

			foreach($usersWithloan as $key => $user)
			{
				// if(floatval($user->balance) < 1 && $user->payment_total >= 1400 && <= 2645) {
				// 	if($this->migrate($user->id , $user->loan_id , 3)) {
				// 		$migratedUsers [] = $user->id;
				// 	}
				// }
			}

			dump($migratedUsers);

		}
		public function migrateToStepTwo()
		{
			$stepOneUsers = $this->stepModel->get_position1(1);
			
			$recentLoan = null;
			$loanList = [];
				
			$jobs = [];

			$pumasok = [];

			$balanse = [];


			foreach($stepOneUsers as $key => $row) 
			{

				$balance = $row->amount + $row->delivery_fee - $row->payment['total'];

				if($balance > 0) 
				{
					$pumasok[] = $row;

					$loanList = $row->payment->list ?? [];

					if( empty($loanList) )
						$recentLoan = end($loanList);

					
				}
			}


			dump($pumasok);
		}

		private function migrate($userId , $loanId , $position = 2)
		{
			$res = false;

			$isExists = $this->toc->getByUser($userId);

			if($isExists) {
				//update

				$isUpdated = $this->toc->update([
						'position' => $position,
						'loanId'   => $loanId,
						'is_paid'  => 1
					], $userId);

				if($isUpdated)
					$res = true;
			}else {

				$isSaved = $this->toc->store([
					'position' => $position,
					'loanId'   => $loanId,
					'userid'   => $userId,
					'is_paid'  => 1
				]);

				if($isSaved)
					$res = true;
			}

			return $res;
		}


	}