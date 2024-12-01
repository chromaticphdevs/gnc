<?php

	use Classes\Loan\LoanService;
	load(['LoanService'],CLASSES.DS.'Loan');
	class LoanModel extends Base_model
	{
		public $table = 'loans_and_payments';
		public $table_credit_limit = 'loan_credit_limit';
		public $table_loan_record = 'loan_records';

		public $recordId;

		public $_fillables = [
			'reference',
			'user_id',
			'parent_id',
			'amount',
			'remaining_balance',
			'entry_date',
			'entry_type',
			'is_verified',
			'is_invalid',
			'created_by',
			'source_id',
			'entry_origin'
		];
		
		public function getUserBalance($userId)
		{
			$this->db->query(
				"SELECT sum(amount) as total
					FROM {$this->table} 
					WHERE user_id = '{$userId}' "
			);

			return $this->db->single()->total ?? 0;
		}

		public function getAll($params = [])
		{
			$where = null;
			$order = null;
			$limit = null;

			if(isset($params['where'])) {
				$where = " WHERE ".$this->dbParamsToCondition($params['where']);
			}
			if(isset($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}
			if(isset($params['limit'])) {
				$limit = " LIMIT {$params['limit']}";
			}

			$this->db->query(
				"SELECT loan.* , loan_record.remarks as record_remarks,
					user.firstname , user.lastname, 
					concat(user.firstname, ' ',user.lastname) as fullname
					FROM {$this->table} as loan

					LEFT JOIN {$this->table_loan_record} as loan_record
					ON loan_record.loan_id = loan.id

					LEFT JOIN {$this->table_credit_limit} as loan_credit_limit
					ON loan_credit_limit.user_id = loan_record.user_id

					LEFT JOIN users as user 
					ON loan.user_id = user.id
					{$where}{$order}{$limit}"
			);

			return $this->db->resultSet();
		}

		public function getUserCreditLimit($userId, $loanType)
		{
			$this->db->query(
				"SELECT * FROM {$this->table_credit_limit}
					WHERE user_id = '{$userId}' AND 
					loan_type = '{$loanType}'
					"
			);
			
			$response = $this->db->single() ?? false;
			if(!$response) 
				return 1;

			return $response->loan_limit;
		}

		public function save($loanData)
		{
			$loanData['reference'] = get_token_random_char(15,date('m'));
			$this->reference = $loanData['reference'];
			$loanData = parent::getFillables($loanData);
			return parent::store($loanData);
		}

		public function addLoan($loanData) {
			$paymentData['entry_type'] = LoanService::ENTRY_TYPE_LOAN;
			$res = $this->save($loanData);

			if($res) {
				$this->addMessage("Loan {$this->reference} Added");
			}
			return $res;
		}

		public function addPayment($paymentData)
		{
			$paymentData['amount'] = $paymentData['amount'] * -1;
			$paymentData['entry_type'] = LoanService::ENTRY_TYPE_PAYMENT;

			$res = $this->save($paymentData);

			if($res) {
				$this->addMessage("Payment {$this->reference} Added");
			}

			return $res;
		}


		public function addPaymentWithLoanId($paymentData)
		{
			if (empty($paymentData['loan_id'])) {
				$this->addError("There must be an existing loan to add payment");
				return false;
			}

			$loan = parent::dbget($paymentData['loan_id']);
			$remaining_balance = $loan->remaining_balance ?? $loan->amount;

			if ($remaining_balance < $paymentData['amount']) {
				$this->addError("Invalid payment amount, payment must not be greater than loan amount");
				return false;
			}

			/**
			 * inject remaining_balance
			 */
			$paymentData['remaining_balance'] = $loan->remaining_balance - $paymentData['amount'];
			
			$res = $this->addPayment([
				'user_id' => $paymentData['user_id'],
				'parent_id' => $paymentData['loan_id'],
				'amount' => $paymentData['amount']
			]);

			//update loan

			$isUpdated = parent::dbupdate([
				'remaining_balance' => $paymentData['remaining_balance']
			],$paymentData['loan_id']);


			//increase credit limit
			if ($paymentData['remaining_balance'] == 0) {
				$this->updateLimit([
					'user_id' => $paymentData['user_id'],
					'loan_type' => LoanService::LOAN_TYPE_BOX_OF_COFFEE
				],1);
			}
			if($isUpdated) {
				$this->addMessage("Loan balance updated");
			}
			return $res;
		}

		public function addRecord($recordData)
		{
			return $this->dbHelper->insert($this->table_loan_record,$recordData);
		}

		public function updateLimit($limitData,$increase = null)
		{
			$record = $this->dbHelper->single($this->table_credit_limit,'*',$this->dbParamsToCondition([
				'user_id' => $limitData['user_id'],
				'loan_type' => $limitData['loan_type']
			]));

			if (!$record) {

				if(!is_null($increase)) {
					$limitData['loan_limit'] = $increase + 1;
				}

				$retVal = $this->dbHelper->insert($this->table_credit_limit,$limitData);
				$this->recordId = $retVal;
			} else {
				$limitData['loan_limit'] = $record->loan_limit += $increase;
				$retVal = $this->dbHelper->update($this->table_credit_limit,$limitData,$this->dbParamsToCondition([
					'user_id' => $limitData['user_id'],
					'loan_type' => $limitData['loan_type']
				]));
				$this->recordId = $record->id;
			}

			return $retVal;
		}

		public function getDebtors($params = [])
		{
			$where = null;
			$order = null;
			$limit = null;

			if (isset($params['where'])) {
				$where = " WHERE ".$this->dbParamsToCondition($params['where']);
			}

			$order = " ORDER BY ifnull(SUM(l_and_p.amount),0) desc";
			if (isset($params['order'])) {
				$order .= " ,{$params['order']}";
			}

			if (isset($params['limit'])) {
				$limit = "LIMIT {$params['limit']}";
			}

			$this->db->query(
				"SELECT user.id as user_id, username, firstname, lastname,
					concat(firstname, ' ', lastname) as fullname, user.email,
					user.mobile, user.address, ifnull(SUM(l_and_p.amount),0) as total_loan_amount,
					ifnull(l_credit_limit.loan_limit,1) as loan_limit, l_credit_limit.loan_type

					FROM users as user 
					
					LEFT JOIN {$this->table} as l_and_p
					ON user.id = l_and_p.user_id

					LEFT JOIN {$this->table_credit_limit} as l_credit_limit
					ON user.id = l_credit_limit.user_id

					{$where} 
					GROUP BY user.id
					{$order} {$limit}
				"
			);
			return $this->db->resultSet();
		}

		public function getUserLoanBalance($userId)
		{
			$this->db->query(
				"SELECT sum(remaining_balance) as total_balance
					FROM {$this->table}
					WHERE user_id = '{$userId}'
					AND entry_type = '".LoanService::ENTRY_TYPE_LOAN."' "
			);

			return $this->db->single()->total_balance ?? 0.0;
		}
		
		/**
		 * fetch user with logins only
		 */
		public function getQualifierCreditors($params = []) 
		{	
			$order = null;

			$where = [
				'ull.type' => 'QR_CODE',
				'lq.user_id' => [
					'condition' => 'is null'
				]
			];

			if (isset($params['where']) && !is_null($params['where'])) {
				$where = array_merge($where, $params['where']);
			}

			if (isset($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}

			$where = " WHERE ".parent::convertWhere($where);
			$this->db->query(
				"SELECT user.*,
					concat(u_upline.firstname , ' ', u_upline.lastname) as upline_name,
					concat(u_direct.firstname , ' ', u_direct.lastname) as direct_name,
					max(ull.date_time) as last_log

					FROM user_login_logger as ull
					JOIN users as user ON
					user.id = ull.userid

					LEFT JOIN users as u_upline
					ON u_upline.id = user.upline
					LEFT JOIN users as u_direct
					ON u_direct.id = user.direct_sponsor

					LEFT JOIN loan_qualifiers as lq 
					ON lq.user_id = user.id 
					{$where} 
						GROUP BY user.id
					{$order}"
			);

			$users = $this->db->resultSet();

			if($users) {
				$userLog = model('UserLoggerModel');
				$identificationModel = model('IdentificationModel');
				$userModel = model('User_model');

				foreach ($users as $key => $row) {
					$row->logs = $userLog->getLogs([
						'where' => [
							'userid' => $row->id,
							'type' => 'QR_CODE'
						]
					]);
					$row->uploadIds = $identificationModel->getByUser($row->id);
					$row->directs   = $userModel->getDirects($row->id);
					$row->directTotal = count($row->directs);
				}
			}
			return $users;
		}
	}