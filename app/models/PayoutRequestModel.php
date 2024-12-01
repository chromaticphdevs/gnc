<?php 	
	use Bank\Pera;
	use Business\Business;

	require_once CLASSES.DS.'banks/Pera.php';
	require_once LIBS.DS.'perabusiness'.DS.'Business.php';

	class PayoutRequestModel extends Base_model 
	{

		public $table = 'payout_request';

		public $error = '';
		public $errors = [];

		public $minRequestAmount = 1500;
		
		public function __construct()
		{
			parent::__construct();

			/*
            *Initiate pera -e business account
            */    
            $pera = THIRD_PARTY['pera']['business_auth'];


			$this->user = model('User_model');
			$this->banklog = model('BankTransferLogModel');
        	$this->pera = model('BankPeraModel');
        	$this->mgPayout = model('MGPayoutItemModel');

        	$this->peraBusinessAuth = [
                'key' => $pera['key'],
                'secret' => $pera['secret']
            ];
		}


		private function checkPeraAccount($userId)
		{
			$peraAccount = $this->pera->getByUser($userId);

			if(!$peraAccount)
			{
				$this->addError("You must connect your pera-e account , create one  
				<a href='https://pera-e.com/' class='btn btn-sm btn-danger'>here</a> then go to enroll accounts page ,
				and copy and paste the keys on your pera-e account.");

				return false;
			}

			return $peraAccount;
		}
		public function timesheetEarningRequest($userId , $accountType , $amount)
		{
			$this->timesheet = model('CSR_TimesheetModel');

			$user = $this->user->get_user($userId);

			$peraAccount = $this->checkPeraAccount( $userId );

			if(!$peraAccount)
				return false;

			$business = new Business();

            /**
			 * Try connecting account to 
			 * Pera-E API
			 */
			$business->init([
                'key' => $this->peraBusinessAuth['key'],
                'secret' => $this->peraBusinessAuth['secret']
            ]);

            $businessIsValid = $business->isAuthenticated();

            if(!$businessIsValid)
            	return $this->addError( " Pera business account is not authenticated ");

            $amountHTML = to_number($amount);

			$description = "A cash amounting to <strong> {$amountHTML} </strong> is transfered to 
					account #{$peraAccount->account_number} of PERA-E";

			/**
			 * Insert amount to payout before transfering 
			 * money to pera-e
			 * this is to deduct customers wallet
			 */

			//check if may pera

			if( isEqual($accountType , 'user'))
				$totalTimesheetAmount = $this->timesheet->getUserTotal($userId);
			if( isEqual($accountType , 'manager'))
				$totalTimesheetAmount = $this->timesheet->getStaffTotal($userId);

			if($totalTimesheetAmount < $amount) {
				$this->addError("Insuficient csr income to perform such request.");
				return false;
			}

			$this->timesheet->store([
				'user_id' => $userId,
				'amount'  => (-1 * $amount),
				'status'  => 'approved',
				'account_type' => $accountType
			]);


            $business->setRecipient([
                'mobileNumber' => $peraAccount->account_number,
                'firstname' =>  $user->firstname,
                'lastname' => $user->lastname
            ]);

            $business->setMeta([
                'description' => $description,
                'controlNumber' => 'no log timesheet payout'
            ]);


            $business->setAmount($amount);
            
            $isSent = $business->send();

			$date = today();
			/* check api response if error*/
			if(! $isSent)
				return $this->addError( $business->getErrorString() );
			//sms
			$smsData = [
				'mobile_number' => $peraAccount->account_number,
				'code' => "We sent your breakthrough PHP {$amount} earning ,  to your pera-e account , account number : {$peraAccount->account_number}",
				'category' => 'SMS'
			];

			SMS($smsData);

			return true;
		}

		public function requestAndMoveToPeraBank($userid , $amount)
		{	

			$validPeraAccount = $this->checkPeraAccount($userId);
				
			if(!$validPeraAccount)
				return false;

			if($amount < $this->minRequestAmount)
			{
				$this->addError("Amount must be greater than {$this->minRequestAmount}");
				return false;
			}

			$payoutRequestId = parent::store([
				'userId' => $userid,
				'amount' => $amount,
				'status' => 'pending'
			]);

			return $this->moveRequesToPeraBankAsBusiness($payoutRequestId);
		}


		public function moveRequesToPeraBankAsBusiness($payoutRequestId)
		{
			$payout = parent::dbget($payoutRequestId);

			$userid = $payout->userId;

			$amount = $payout->amount;

			$user = $this->user->get_user($userid);

			if($amount < $this->minRequestAmount)
				return $this->addError(" Amount must be greater than {$this->minRequestAmount}");

			/**
			 * Validate payout request status
			 * only pending payout request can be transfered to bank
			 */
			if( !isEqual($payout->status , 'pending') )
				return $this->addError(" Payout request is already {$payout->status} ");

			$peraAccount = $this->pera->getByUser($userid);
			/**
			 * Validate if user has pera account
			 */
			if(!$peraAccount)
				return $this->addError("{$user->fullname} ,No pera account , your payout request is subject for confirmation");

			$amountHTML = to_number($amount);

			$description = "A cash amounting to <strong> {$amountHTML} </strong> is transfered to 
					account #{$peraAccount->account_number} of PERA-E";

			$dateNow = today();

            $business = new Business();

            /**
			 * Try connecting account to 
			 * Pera-E API
			 */
			$business->init([
                'key' => $this->peraBusinessAuth['key'],
                'secret' => $this->peraBusinessAuth['secret']
            ]);

            $businessIsValid = $business->isAuthenticated();

            if(!$businessIsValid)
            	return $this->addError( " Pera business account is not authenticated ");

			/**
			 * Insert amount to payout before transfering 
			 * money to pera-e
			 * this is to deduct customers wallet
			 */
			$mgPayoutId = $this->mgPayout->store([
				'userid' => $userid,
				'amount' => $amount,
				'status'   => 'released'
			]);

			if(!$mgPayoutId)
				return $this->addError("Failed to save payout release");
			/**
			 * Save bank transfer logs
			 * this comes first to save the transaction
			 * and we can run roll back
			 */

			//save bank log
            $bankLog = $this->banklog->save( $mgPayoutId ,  $userid , $description );

			if(!$bankLog)
				return $this->addError("Transaction failed to logged");

			

            $business->setRecipient([
                'mobileNumber' => $peraAccount->account_number,
                'firstname' =>  $user->firstname,
                'lastname' => $user->lastname
            ]);

            $business->setMeta([
                'description' => $description,
                'controlNumber' => $this->banklog->controlNumber
            ]);


            $business->setAmount($amount);


            $isSent = $business->send();

			$date = today();


			/* check api response if error*/
			if(! $isSent)
				return $this->addError( $business->getErrorString() );

			/**
			 * update payout status to released
			 */
			$released = parent::dbupdate([
				'status' => 'released',
			], $payoutRequestId);

			if(!$released)
				return $this->addError('Payout release failed! status not changed');

			if(!$bankLog && !$mgPayoutId)
				return $this->addError("Something went wrong pera did not delivered to pera-e");

			//sms
			$smsData = [
				'mobile_number' => $peraAccount->account_number,
				'code' => "We sent your breakthrough PHP {$amount} earning ,  to your pera-e account , account number : {$peraAccount->account_number}",
				'category' => 'SMS'
			];

			SMS($smsData);

			return true;
		}
		public function moveRequesToPeraBank($payoutRequestId)
		{
			$payout = parent::dbget($payoutRequestId);

			$userid = $payout->userId;

			$amount = $payout->amount;

			$user = $this->user->get_user($userid);

			if($amount < $this->minRequestAmount)
				return $this->addError(" Amount must be greater than {$this->minRequestAmount}");
			/**
			 * Validate payout request status
			 * only pending payout request can be transfered to bank
			 */
			if( !isEqual($payout->status , 'pending') )
				return $this->addError(" Payout request is already {$payout->status} ");

			$peraAccount = $this->pera->getByUser($userid);

			/**
			 * Validate if user has pera account
			 */
			if(!$peraAccount)
				return $this->addError("{$user->fullname} ,No pera account , your payout request is subject for confirmation");
				
			$pera = new Pera();

			/**
			 * Try connecting account to 
			 * Pera-E API
			 */
			$isConnected = $pera->connectAuth($peraAccount->api_key , $peraAccount->api_secret);


			if(!$isConnected)
				return $this->addError("{$user->fullname} Cannot connect to pera-e.com!");

			$date = today();

			/**
			 * update payout status to released
			 */
			$released = parent::dbupdate([
				'status' => 'released',
			], $payoutRequestId);

			if(!$released)
				return $this->addError('Payout release failed! status not changed');

			/**
			 * Insert amount to payout before transfering 
			 * money to pera-e
			 * this is to deduct customers wallet
			 */
			$mgPayoutId = $this->mgPayout->store([
				'userid' => $userid,
				'amount' => $amount,
				'status'   => 'released'
			]);

			if(!$mgPayoutId)
				return $this->addError("Failed to save payout release");

			$amountHTML = to_number($amount);

			$description = "A cash amounting to <strong> {$amountHTML} </strong> is transfered to 
					account #{$peraAccount->account_number} of PERA-E";

			/**
			 * Save bank transfer logs
			 * this comes first to save the transaction
			 * and we can run roll back
			 */
			$bankLog = $this->banklog->save( $mgPayoutId ,  $userid , $description );

			if(!$bankLog)
				return $this->addError("Transaction failed to logged");

			if(!$isConnected || !$bankLog && !$mgPayoutId)
				return $this->addError("Something went wrong pera did not delivered to pera-e");

			/**
			 * Transfer cash to pera-e
			 */
			$moneySent = $pera->sendMoney(...[$amount,$this->banklog->controlNumber ,$description]);

			if(!$moneySent)
				return $this->addError('Something went wrong money transfer did not went through');

			return true;
		}

		public function addError($error)
		{
			$this->errors[] = $error;
			//recent error
			$this->error = $error;
			return false;
		}

		public function getWithMeta($condition = null , $orderBy = 'id desc')
		{

			$payouts = $this->dbHelper->resultSet(...[
				$this->table , 
				'*',
				$condition,
				$orderBy
			]);


			foreach($payouts as $key => $row) 
			{
				if(!$row->userId){
					unset($payouts[$key]);
					continue;
				}

				$row->user = $this->user->get_user($row->userId);

				$row->pera_account = $this->pera->getByUser($row->userId);
			}

			return $payouts;
		}

		public function getPending()
		{
			return $this->getWithMeta(" status = 'pending' ");
		}

		public function getMeta($id)
		{
			$payout = $this->dbHelper->single(...[
				$this->table , 
				'*',
				" id = '$id' "
			]);

			$payout->user = $this->user->get_user( $payout->userId );

			return $payout;
		}

	}