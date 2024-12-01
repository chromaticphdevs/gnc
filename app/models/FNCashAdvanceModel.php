<?php
	load(['CashAdvanceService'], APPROOT.DS.'services');
	use Services\CashAdvanceService;

	class FNCashAdvanceModel extends Base_model
	{
		public $table = 'fn_cash_advances';
		public $_fillables = [
			'userid',
			'amount',
			'service_fee',
			'attornees_fee',
			'interest_rate_amount',
			'net',
			'balance',
			'date',
			'time',
			'approved_by',
			'status',
			'notes',
			'interest_rate',
			'payment_method'
		];

		const SKIP_LOAN_DATA_CALCULATION = 'SKIP_LOAN_DATA_CALCULATION';
		const SKIP_COBORROWER_VALIDATION = 'SKIP_COBORROWER_VALIDATION';
		
		public function agreementApproval($loanId) {
			$loan = $this->getLoan($loanId);
			if($loan->is_agreement_check) {
				$this->addError("Agreement is already approved");
				return false;
			}

			$resp = parent::dbupdate([
				'is_agreement_check' => true
			], $loanId);
			
			return $resp;
		}

		public function setLoanOptions($options = []){
			if(!empty($options)) {
				$this->loanOptions = $options;
			} else {
				$this->loanOptions = [];
			}
		}
		/**
		 * method to add new loan
		 * coborrowers are array with values of [mobile_number, name]
		 */
		public function addNewLoan($loanData = []) {
			if(!isset($this->userModel)) {
				$this->userModel = model('User_model');
			}
			$user = $this->userModel->get_user($loanData['userid']);
			/**
			 * check coborrower information 
			 * if data is correct
			 */
			if(!isset($this->caCoBorrowModel)) {
				$this->caCoBorrowModel = model('CashAdvanceCoBorrowerModel');
			}
			$this->userNotificationModel = model('userNotificationModel');

			$skipCoborrowerCheck =  isset($this->loanOptions[self::SKIP_COBORROWER_VALIDATION]);
			$skipAmountAutoCalcuation = isset($this->loanOptions[self::SKIP_LOAN_DATA_CALCULATION]);
			
			if(!$skipCoborrowerCheck) {
				$coBorrowers = [];
				if($loanData['coborrower']) {
					foreach($loanData['coborrower'] as $key => $row) {
						$borrower = $this->userModel->getSingle([
							'where' => [
								'user.mobile' => $row['mobile_number']
							]
						]);

						if($borrower) {
							$coBorrowers[] = $borrower;
						}
					}
				}
				if(empty($coBorrowers)) {
					$this->addError("There are no valid coborrowers, unable to continue loan");
					return false;
				}
			}

			if(!empty($this->getErrors())) {
				return false;
			}

			$_fillableDatas = parent::getFillables($loanData);
			$_fillableDatas['code'] = $this->make_code();
			$loanAmount = $_fillableDatas['amount'];

			$cashAdvanceService = new CashAdvanceService();
			$calcData = $cashAdvanceService->calculate($loanAmount);

			/**
			 * set option to 
			 * keep the fillable data as it is
			 */
			if(!$skipAmountAutoCalcuation) {
				$_fillableDatas['service_fee'] = $calcData['serviceFee'];
				$_fillableDatas['attornees_fee'] = $calcData['attorneesFee'];
				$_fillableDatas['interest_rate_amount'] = $calcData['loanInterestFee'];
				$_fillableDatas['interest_rate'] = LOAN_CHARGES['LOAN_INTEREST_FEE_RATE'].'%';

				//net amount is 10% interest and service fee
				$netAmount = $calcData['net'];
				$_fillableDatas['net'] = $netAmount;
				$_fillableDatas['balance'] = $netAmount;	
			}
			
			$loans = $this->getUserLoans($user->id);
			if($loans) {
				// _unitTest(true, "User in qualified for cash advance but has existing loan userid = {$user->id}");
				$this->addError("User {$user->username} has currently have pending loan");
				return false;
			}

			$loanInsert = parent::store($_fillableDatas);
			// _unitTest($loanInsert, "loan request created". get_class($this) . ' ' . debug_backtrace()['line']);
			
			/**
			 * add to loan coborrowers
			 */
			if($loanInsert && !$skipCoborrowerCheck) {
				// _unitTest(true, "Trying to create loan coborrowers". get_class($this) . ' ' . debug_backtrace()['line']);
				foreach($coBorrowers as $key => $row) {
					$resp = $this->caCoBorrowModel->addNew([
						'fn_ca_id' => $loanInsert,
						'co_borrower_id' => $row->id,
						'benefactor_id' => $user->id,
						'co_borrower_approval' => 'verified',
						'staff_approval' => 'pending'
					]);
					
					$link = "/CACoBorrowerController/showInvite/".seal($resp);
					$message = "{$user->firstname} is inviting you to become his co-borrower on his loan click here to take action";
					if($resp) {
						// _unitTest($loanInsert, "create loan coborrowers created loan id {$loanInsert}". get_class($this) . ' ' . debug_backtrace()['line']);
						$this->userNotificationModel->store([
							'message' => $message,
							'link'    => $link,
							'user_id'  => $user->id
						]);
					} else {
						// _unitTest($loanInsert, "failed to add co-borrower {$row->id}". get_class($this) . ' ' . debug_backtrace()['line']);
					}
				}
			}
			$this->_addRetval('loanId', $loanInsert);
			$this->loanId = $loanInsert;

			//add page reload
			$this->userModel->dbupdate([
				'page_auto_focus' => PAGE_AUTO_FOCUS['CASH_ADVANCE_PAGE']
			], $user->id);
			
			return $loanInsert;
		}

		public function modifyLoanAmountAutoCompute($loanId, $amount) {
			$amount = convert_to_number($amount);

			$errors = [];
			if(!is_numeric($amount)) {
				$errors[] = "Invalid Amount";
			} else {
				if($amount > 300000) {
					$errors [] = "Amount is too big for a " . WordLib::get('cashAdvance');
				} elseif($amount < 500) {
					$errors [] = "Amount is too small for a " . WordLib::get('cashAdvance');
				}
			}

			if(!empty($errors)) {
				$this->addError(implode(',', $errors));
				return false;
			}
			
			$cashAdvanceService = new CashAdvanceService();
			$calcData = $cashAdvanceService->calculate($amount);

			$caOkay = parent::dbupdate([
				'amount' => $amount,
				'net' => $calcData['net'],
				'service_fee' => $calcData['serviceFee'],
				'balance' => $calcData['net'],
				'interest_rate_amount' => $calcData['loanInterestFee'],
				'attornees_fee' => $calcData['attorneesFee']
			], $loanId);

			return $caOkay;
		}

		/**
		 * padd cashadvance loanid
		 */
		public function terminate($loanId, $createNewLoan = false, $attorneesFee = null) {
			/**
			 * get current Loan
			 */
			$loan = $this->getLoan($loanId);
			$loanService = new CashAdvanceService();
			
			if(is_null($attorneesFee)) {
				$newLoanData = $loanService->calculationForTerminatedLoan($loan->balance, $loan->attornees_fee);
			} else {
				$newLoanData = $loanService->calculationForTerminatedLoan($loan->balance, $attorneesFee);
			}

			if($loan->balance < 0) {
				$this->addError("Invalid Loan amount");
				return false;
			}
			/**
			 * terminate old loan
			 */

		 	parent::dbupdate([
				'status' => 'terminated'
			], $loanId);

			$this->setLoanOptions([
				self::SKIP_LOAN_DATA_CALCULATION => true,
				self::SKIP_COBORROWER_VALIDATION => true
			]);

			if($createNewLoan) {
				$resp = $this->addNewLoan([
					'service_fee' => $newLoanData['serviceFee'],
					'attornees_fee' => $newLoanData['attorneesFee'],
					'loan_interest_rate_amount' => $newLoanData['loanInterest'],
					'interest_rate' => 0,
					'net' => $newLoanData['net'],
					'balance' => $newLoanData['balance'],
					'amount' => $newLoanData['amount'],
					'userid' => $loan->userid,
					'date' => get_date(today())
				]);
				return $resp;
			} else {
				return true;
			}
		}

		public function getLoan($id) {
			$this->db->query(
				"SELECT ca_tbl.*,
					concat(user.firstname, ' ',user.lastname) as borrower_fullname,
					user.username,
					user.esig,
					user.address as borrower_address
					FROM {$this->table} as ca_tbl

					LEFT JOIN users as user 
						ON user.id = ca_tbl.userid
					WHERE ca_tbl.id = '{$id}'"
			);

			return $this->db->single();
		}

		public function get_list_register_just_now()
		{
			date_default_timezone_set('Asia/Manila');
			//$date= date('Y-m-d') ;

			//$time_from = date('H:i:s');
			$date = date("Y-m-d H:i:s",strtotime("-24 hours"));// subtract 60 mins;

			$this->db->query(
				"SELECT username,concat(firstname,' ',lastname) as fullname,
				(SELECT name from fn_branches WHERE id = branchId) as branch,
				 email,mobile,created_at
				 FROM `users`
				 WHERE  created_at >= '$date' ORDER BY created_at DESC"
			);

			return $this->db->resultSet();
		}

		public function cash_advance_list($branchid)
		{

			$this->db->query(
				"SELECT *,ifnull((SELECT SUM(amount) FROM `fn_cash_advance_payment` WHERE loanid =CA.id), '0')as payment,
				(SELECT CONCAT(firstname,' ', lastname ) FROM users WHERE id= CA.userid ) as fullname,
				(SELECT username FROM users WHERE id= CA.userid ) as username,
				(SELECT email FROM users WHERE id= CA.userid ) as email,
				(SELECT mobile FROM users WHERE id= CA.userid ) as phone
				FROM `fn_cash_advances` as CA WHERE status='Approved' AND branch_id = '$branchid' ORDER BY created_on DESC"
							);

			return $this->db->resultSet();

		}

		public function getByBranch($branch_id)
		{
			$data = [
				'fn_cash_advances',
				'*',
				" status = 'Approved' and branch_id = '{$branch_id}'"
			];

			$results = $this->dbHelper->resultSet(...$data);

			foreach($results as $key => $row)
			{
				$userCashAdvance = new FNCashAdvanceUserModel($row->userid,$row->id);
				$userPaymentAdvance = new FNCashAdvancePaymentUserModel($row->userid,$row->id);

				$row->balance = $userCashAdvance->getBalance();
				$row->payment = $userPaymentAdvance->getTotal();
				$row->user    = $userCashAdvance->getUser();
			}

			return $results;
		}

		public function get_user_loan($userid)
		{

			$data = [
				'fn_cash_advances',
				'*',
				" (status = 'Approved' OR status = 'Paid') AND userid = '{$userid}'"
			];

			$results = $this->dbHelper->resultSet(...$data);

			foreach($results as $key => $row)
			{
				$userCashAdvance = new FNCashAdvanceUserModel($row->userid,$row->id);
				$userPaymentAdvance = new FNCashAdvancePaymentUserModel($row->userid,$row->id);

				$row->balance = $userCashAdvance->getBalance();
				$row->payment = $userPaymentAdvance->getTotal();

			}

			return $results;
		}

		public function getPendingByUser($user_id , $amount = null)
		{
			/*ALSO SAME AMOUNT*/
			if(!is_null($amount))
			{
				return $this->getAll(
					"WHERE cd.userid = '{$user_id}' and cd.status = 'pending' and cd.amount = '$amount'"
				);
			}
			return $this->getAll(
				"WHERE cd.userid = '{$user_id}' and cd.status = 'pending'"
			);
		}

		public function getApprovedByUser($user_id , $amount = null)
		{
			/*ALSO SAME AMOUNT*/
			if(!is_null($amount))
			{
				return $this->getAll(
					"WHERE cd.userid = '{$user_id}' and cd.status = 'approved' and cd.amount = '$amount'"
				);
			}
			return $this->getAll(
				"WHERE cd.userid = '{$user_id}' and cd.status = 'approved'"
			);
		}

		public function fetchAll($params = []) {
			$where = null;
			$order = null;
			$limit = null;

			if(!empty($params['where'])) {
				$where = " WHERE " . parent::convertWhere($params['where']);
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY {$params['order']} ";
			}
			
			if(!empty($params['limit'])) {
				$limit = " LIMIT {$params['limit']} ";
			}

			$this->db->query(
				"SELECT
				cd.id as ca_id , cd.amount as ca_amount, cd.date as ca_date, 
				cd.service_fee as service_fee, cd.attornees_fee as attornees_fee, cd.net as net, cd.status as ca_status,
				cd.is_shown as ca_is_shown, cd.approved_by as ca_approved_by,
				cd.userid as ca_userid, 
				cd.balance as ca_balance,
				cd.is_released as ca_is_released,
				cd.release_date as ca_release_date,
				cd.code as ca_reference,
				branches.name as branch ,
				concat(u.firstname , ' ' , u.lastname) as fullname,
				u.mobile as mobile_number,
				u.id as user_id , u.username, staff.username as staff_username,
				concat(direct_sponsor.firstname, ' ', direct_sponsor.lastname) as direct_sponsor_name



				FROM fn_cash_advances as cd
				LEFT JOIN fn_branches as branches
					ON branches.id = cd.branch_id
				LEFT JOIN users as u
					ON cd.userid = u.id
				LEFT JOIN users as staff
					ON cd.approved_by = staff.id
				LEFT JOIN users as direct_sponsor
					ON direct_sponsor.id = u.direct_sponsor
					$where $order $limit
				"
			);

			return $this->db->resultSet();
		}

		public function fetchOne($params = []) {
			return $this->fetchAll($params)[0] ?? false;
		}

		/**
		 * for refactoring
		 */
		public function getAll($where = null , $orderBy = null , $limit = null)
		{	

			if(!is_null($limit))
				$limit = " LIMIT {$limit}";

			$this->db->query(
				"SELECT
				cd.id as ca_id , cd.amount as ca_amount,
				cd.service_fee as service_fee, cd.net as net, cd.status as ca_status,
				cd.is_shown as ca_is_shown, cd.approved_by as ca_approved_by,
				branches.name as branch ,
				concat(u.firstname , ' ' , u.lastname) as fullname,
				u.id as user_id , u.username, staff.username as staff_username
				FROM fn_cash_advances as cd
				LEFT JOIN fn_branches as branches
					ON branches.id = cd.branch_id
				LEFT JOIN users as u
					ON cd.userid = u.id
				LEFT JOIN users as staff
					ON cd.approved_by = staff.id

					$where $orderBy $limit
				"
			);

			return $this->db->resultSet();
		}

		public function getUserLoans($userId)
		{
			return $this->getAll(" WHERE userid = '{$userId}' and cd.status in ('pending','released','approved') " , ' order by amount asc');
		}

		public function getByUsername($username)
		{
			return $this->getAll(" WHERE u.username = '{$username}' ");
		}

		/*
		*search username or firstname or lastname
		*/
		public function getByUserMeta($meta)
		{
			$usernameSearch = $this->getAll(" WHERE u.username = '{$meta}' ");

			if(!$usernameSearch)
				return $this->getAll( " WHERE u.firstname like '%$meta' OR u.lastName like '%$meta' ");

			return $usernameSearch;
		}

		public function unapproved_request_list($limit = null)
		{
			return $this->getAll(" WHERE cd.status = 'pending' " , " Order by  amount asc , cd.id desc" , $limit);
		}

		public function approved_list_all($limit = null)
		{
			//old code
			//return $this->getAll(" WHERE cd.status = 'approved' " , " Order by  amount asc , cd.id desc" , $limit);

			$data = [
				'fn_cash_advances as CA',
				"*,ifnull((SELECT SUM(amount) FROM `fn_cash_advance_payment` WHERE loanid =CA.id), '0')as payment,
				(SELECT CONCAT(firstname,' ', lastname ) FROM users WHERE id= CA.userid ) as fullname,
				(SELECT name FROM fn_branches WHERE id= CA.branch_id ) as branch,
				(SELECT username FROM users WHERE id= CA.userid ) as username,
				(SELECT name FROM fn_accounts WHERE id= CA.approved_by ) as approved_by,
				(SELECT email FROM users WHERE id= CA.userid ) as email,
				(SELECT mobile FROM users WHERE id= CA.userid ) as phone",
				" status = 'Approved'"
			];

			$results = $this->dbHelper->resultSet(...$data);

			foreach($results as $key => $row)
			{
				$userCashAdvance = new FNCashAdvanceUserModel($row->userid,$row->id);
				$userPaymentAdvance = new FNCashAdvancePaymentUserModel($row->userid,$row->id);

				$row->balance = $userCashAdvance->getBalance();
				$row->payment = $userPaymentAdvance->getTotal();
			}

			return $results;

		}


		public function get_user_cash_advance($userid)
		{
			$this->db->query(
				"SELECT *,ifnull((SELECT SUM(amount) FROM `fn_cash_advance_payment` WHERE loanid =CA.id), '0')as payment,
				(SELECT CONCAT(firstname,' ', lastname ) FROM users WHERE id= CA.userid ) as fullname,
				(SELECT username FROM users WHERE id= CA.userid ) as username,
				(SELECT email FROM users WHERE id= CA.userid ) as email,
				(SELECT mobile FROM users WHERE id= CA.userid ) as phone
				FROM `fn_cash_advances` as CA WHERE status='Approved'
				AND fn_cash_advances.userid = '{$userid}'
				ORDER BY created_on DESC"
							);

			return $this->db->single();
		}
		
		/*automated cash loan*/
		public function create_auto_loan($loanObj , $userid, $branchid)
		{
			/*load this amount*/
			$sql = "
				INSERT INTO fn_cash_advances(userid , branch_id , amount, status , notes)VALUES";

			$loanList = $loanObj->generate_cash_loan();

			$counter = 0;

			foreach($loanList as $key => $row)
			{
				if($counter < $key)
				{
					$sql .= ",";
				}

				$sql .= "('$userid' ,'$branchid', '$row' , 'pending' , 'Automated Loan')";
			}


			if(!empty($sql))
			{
				try{

					$this->db->query($sql);

					$this->db->execute();

					return true;
				}catch(Exception $e)
				{
					return false;
				}
			}

			return true;
		}


		public function get_list_by_user($userid)
		{
			$this->db->query(
				"SELECT DISTINCT * FROM fn_cash_advances where userid = '$userid' order by id desc"
			);

			return $this->db->resultSet();
		}


		public function qualification_get_list_all()
		{

			$this->db->query(
						"SELECT id,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' "
					);

	    	$data = $this->db->resultSet();

			$UserList = [];

			foreach ($data as $key => $value)
			{


				$this->db->query(" SELECT * FROM `users` WHERE id = '$value->id' and status != 'pre-activated' ");

	    	 	$result = $this->db->single();

				if(!empty($result))
				{

					$this->db->query(
						"SELECT id,L_R  FROM `users` WHERE direct_sponsor = '$value->id' and status != 'pre-activated' "
					);

	    	 		$DRS_info = $this->db->resultSet();

	    	 		$left_counter = 0;
	    	 		$right_counter = 0;

	    	 		foreach ($DRS_info as $key2 => $value2)
					{

						if($value2->L_R == "LEFT"){

							$left_counter += 1;

						}else{

							$right_counter += 1;
						}
					}

					if($left_counter > 0 && $right_counter > 0){

						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Qualified") );

					}else{

						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Not Qualified") );
					}


				}else{

					array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Not Qualified") );
				}




			}

			return $UserList;

		}

		public function qualification_get_list_by_branch($branch_id)
		{

			$this->db->query(
						"SELECT id,firstname,lastname,mobile,email,address  FROM `users`  WHERE id != '1' and branchId = '$branch_id' "
					);

	    	$data = $this->db->resultSet();

			$UserList = [];

			foreach ($data as $key => $value)
			{


				$this->db->query(" SELECT * FROM `users` WHERE id = '$value->id' and status != 'pre-activated' ");

	    	 	$result = $this->db->single();

				if(!empty($result))
				{

					$this->db->query(
						"SELECT id,L_R  FROM `users` WHERE direct_sponsor = '$value->id' and status != 'pre-activated' "
					);

	    	 		$DRS_info = $this->db->resultSet();

	    	 		$left_counter = 0;
	    	 		$right_counter = 0;

	    	 		foreach ($DRS_info as $key2 => $value2)
					{

						if($value2->L_R == "LEFT"){

							$left_counter += 1;

						}else{

							$right_counter += 1;
						}
					}

					if($left_counter > 0 && $right_counter > 0){

						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Qualified") );

					}else{

						array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Not Qualified") );
					}


				}else{

					array_push($UserList, array($value->firstname,$value->lastname,$value->mobile,$value->email,$value->address, "Not Qualified") );
				}




			}

			return $UserList;

		}





		//listing all users that has a complete 3th lvl downline that is all activated
		public function approval_list_all()
		{

			$this->db->query(
						"SELECT id as loanID, userid,amount,status FROM `fn_cash_advances` WHERE amount = '5000' and status = 'Pending'"
					);

	    	$data = $this->db->resultSet();

			$UserList = [];

			if(empty($data))
			{

				return false;
			}

			foreach ($data as $key => $value)
			{
				$this->db->query(" SELECT * FROM `users` WHERE id = '$value->userid'  ");
				$userInfo = $this->db->single();


				if(empty($userInfo))
				{

					return false;
				}

				$this->db->query(" SELECT * FROM `users` WHERE upline = '$value->userid'  ");

	    	 	$result = $this->db->resultSet();

				$left_counter = 0;
	    	 	$right_counter = 0;
				$left_counter2 = 0;
	    	 	$right_counter2 = 0;
				if(!empty($result))
				{
					foreach ($result as $key2 => $value2)
					{
						if($value2->L_R == "LEFT")
						{
							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' and status != 'pre-activated'  ");
	    	 				$left_result = $this->db->resultSet();

	    	 				if(!empty($left_result))
							{
								foreach ($left_result as $key3 => $value3)
								{

									if($value3->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id' and status != 'pre-activated'  ");
				    	 				$left_counter = $this->db->single()->number;
									}else
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value3->id' and status != 'pre-activated' ");
				    	 				$right_counter = $this->db->single()->number;

									}


								}
							}

						}else
						{

							$this->db->query(" SELECT * FROM `users` WHERE upline = '$value2->id' and status != 'pre-activated' ");
	    	 				$right_result = $this->db->resultSet();

	    	 				if(!empty($right_result))
							{
								foreach ($right_result as $key4 => $value4)
								{
									if($value4->L_R == "LEFT")
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id' and status != 'pre-activated'  ");
				    	 				$left_counter2 = $this->db->single()->number;
									}else
									{
										$this->db->query(" SELECT COUNT(*) as number FROM `users` WHERE upline = '$value4->id' and status != 'pre-activated' ");
				    	 				$right_counter2 = $this->db->single()->number;

									}


								}
							}

						}

					}

					if(($left_counter == 2 && $right_counter == 2) && ($left_counter2 == 2 && $right_counter2 == 2))
					{

						array_push($UserList, array($userInfo->firstname,$userInfo->lastname,$userInfo->mobile,$userInfo->username,$value->amount,$value->status,$value->loanID) );
					}

				}

			}

			return $UserList;

		}

		// public function approved_list_all()
		// {
		//
		// 	$this->db->query(
		// 		"SELECT U.`username`, U.`firstname`, U.`lastname`,
		// 		(SELECT name FROM fn_branches WHERE id = CD.branch_id) as branch,
		// 		CD.`amount`,CD.`date`,CD.`time`,CD.`status`,
		// 		(SELECT concat(firstname,' ',lastname) FROM users WHERE id =CD.`approved_by` ) as approved_name
		// 		FROM `fn_cash_advances` as CD INNER JOIN `users` as U
		// 		WHERE CD.status = 'Approved' and CD.`userid` = U.`id`"
		// 	);
		//
		// 	return $this->db->resultSet();
		//
		// }

		/*
		*@params
		*id is the cashadvance id
		*approvedBy user who approved the loan
		*/
		public function approveLoan($id , $approvedBy)
		{
			$data = [
				$this->table,
				[
					'date' => today(),
					'time' => getTime(),
					'approved_by' => $approvedBy,
					'status'  => 'Approved',
					'code' => $this->make_code()
				],
				"id = '$id'"
			];

			return $this->dbHelper->update(...$data);
		}

		public function update_status_approve($LoanID, $userId , $request = null)
		{
			$link = "/FNCashAdvance/approval_list_all/";
			if($request == 1)
			{
				$this->db->query("UPDATE `fn_cash_advance_request` SET `status`='Approved' WHERE loanID = '$LoanID' ");

				$this->db->execute();

				$link = "/FNCashAdvance/request_list_all/";
			}

			$date = date('Y-m-d');

			$time = date('h:i:s');

			$this->db->query("UPDATE `fn_cash_advances` SET `date`='$date',`time`='$time',
				`approved_by`='$userId',`status`='Approved' WHERE id = '$LoanID' ");

			if($this->db->execute()){

				Flash::set("Cash Advance Approved");
				redirect($link);

			}else{
				Flash::set("ERROR");
				redirect($link);
			}


		}

		public function get_balance_by_user($userId)
		{

			$loan =0;
			$payment = 0;

			$this->db->query(
				"SELECT amount FROM fn_cash_advances WHERE userId = '$userId' and status= 'Approved'"
			);

			$loan = $this->db->single()->amount;

			$this->db->query(
				"SELECT sum(amount) as amount FROM `fn_cash_advance_code_payment` WHERE userId= '$userId' and status = 'used'"
			);

			$payment = $this->db->single()->amount;

			return $loan - $payment;

		}

		public function request_approval($LoanID)
		{
			$this->db->query(
					"SELECT loanID FROM `fn_cash_advance_request` WHERE loanID = '$LoanID' "
				);

			if(!empty($this->db->resultSet()))
			{
				Flash::set("Its Already Requested. Please wait for the Approval");
				redirect("/FNCashAdvance/create/");
				return false;
			}


			$this->db->query("INSERT INTO `fn_cash_advance_request`(`loanID`) VALUES ('$LoanID')");

			if($this->db->execute()){

				Flash::set("Cash Advance Requested");
				redirect("/FNCashAdvance/create/");

			}else{
				Flash::set("ERROR");
				redirect("/FNCashAdvance/create/");
			}
		}



		/*
		* this method updates all customer cash advance request
		* when the customer has no outsanding balance
		*
		** CONDITION **
		* Only approved status cash_advances will be converted
		** this method plays a very crucial role to validate cash advance requests **
		*/
		public function setAllApprovedToPaid($user_id)
		{
			$data = [
				'fn_cash_advances',
				[
					'time' => getTime(),
					'date' => today(),
					'status' => 'paid',
				],
				" status = 'approved' and userid = '{$user_id}'"
			];

			return $this->dbHelper->update(...$data);
		}


		/*
		*If Reloaning currently paid cash advance amount
		*then hide the paid cash advance with same amount
		*/

		public function isReloan($amount , $user_id)
		{
			$data = [
				'fn_cash_advances',
				[
					'id' , 'amount' , 'userid'
				],
				" amount = '$amount' and
					userid = '$user_id' and
					status = 'paid' "
			];

			$cashAdvance = $this->dbHelper->single(...$data);

			/*IF RELOANING SAME AMOUNT*/
			if($cashAdvance) {
				return $this->dbupdate([
					'is_shown' => FALSE
				], $cashAdvance->id);
			}

			/*IF IS NOT RELOAN*/
			return false;
		}

		/*Get loan with branch*/


		public function getWithBranch($loanId)
		{
			$this->db->query(
				"SELECT cash.* , branch.name as branch_name ,
				branch.id as branch_id 

				FROM $this->table as cash 
				
				LEFT JOIN fn_branches as branch 
				ON branch.id = cash.branch_id

				WHERE cash.id = '{$loanId}' "
			);

			return $this->db->single();
		}

		public function process_ca($data)
		{	
			extract($data);

			$data = [
				'fn_cash_advances',
				[
					'service_fee' => $service_fee,
					'net' => $net
				],
				" id = '{$ca_id}'"
			];

			return $this->dbHelper->update(...$data);
		}

		public function get_payment_history($userid)
		{
			$this->db->query(
				"SELECT * FROM `fn_cash_advance_payment` 
				 WHERE `userid` = '$userid' 
				 ORDER BY `date_time` ASC"
			);

			return $this->db->resultSet();
		}

		public function make_code()
		{
			$day = date("d");
			$month = date("m");
			$year = date("Y");
			$suffix = random_number(3);
		    return "C{$day}{$month}{$year}-{$suffix}";
		}

		/**
		 * loan attributes can be used on next implementation
		 * possible keys[loanAmount, loanInterest, loanTerms, $serviceFee]
		 */
		public function autoloan($user, $loanAttributes = []) {
			if(!isset($this->userModel)) {
				$this->userModel = model('User_model');
			}
			/**
			 * add loan check,
			 * single loan per user
			 */
			$referrals = $this->userModel->getDirectsVerifiedAccounts($user->id);
			if(count($referrals) >= 2) {
				$coBorrowers = [];
				/**
				 * get emidiate referrals and assign as co-borrowers
				 */
				foreach($referrals as $key => $row) {
					$coBorrowers[] = [
						'mobile_number' => $row->mobile,
						'name' => $row->firstname . ' '. $row->lastname
					];
					
					if(count($coBorrowers) == 2) {
						break;
					}
				}
				/**
				 * create new loan
				 */
				$response = $this->addNewLoan([
					'userid' => $user->id,
					'amount' => $loanAttributes['amount'] ?? 5000,
					'date' => today(),
					'coborrower' => $coBorrowers,
					'is_agreement_check' => true
				]);

				if($response) {
					$this->_addRetval('loanId', $response);
					return true;
				}return false;
			}
			$this->addError("Unable to create auto loan, verified referrals not reached the requirement");
			_unitTest(true, "Unable to create auto loan verified referrals not over 2 userid = {$user->id}");
			return false;
		}

		public function addAttorneeFeePenalty($loanId, $penaltyAmount) {
			$loan = $this->getLoan($loanId);
			$attorneeFeePenaltyAmount = ($loan->attornees_fee ?? 0) + $penaltyAmount;
			$updatedBalanceAmount = ($loan->balance ?? 0) + $penaltyAmount;
			$response = parent::dbupdate([
				'attornees_fee' => $attorneeFeePenaltyAmount,
				'balance' => $updatedBalanceAmount
			], $loanId);

			_unitTest(true, "attorfee penalty added {$penaltyAmount} loan: # {$loan->code}");
			return $response;
		}

		public function getActiveLoanSummary() {

			$this->db->query(
				"SELECT user.id as user_id, fcd.id as loan_id, net, balance,
					due_date, due_date_no_of_days,
					concat(firstname, ' ' ,lastname) as borrower_fullname

					FROM fn_cash_advances as fcd
					
					LEFT JOIN users as user
						ON fcd.userid = user.id

					LEFT JOIN cash_advance_releases as car
						ON car.ca_id = fcd.id 
					
					WHERE fcd.status = 'released'
					and fcd.is_released = TRUE
					and fcd.is_shown = TRUE

					ORDER BY user.firstname asc
					"
			);

			return $this->db->resultSet();
		}
	}
