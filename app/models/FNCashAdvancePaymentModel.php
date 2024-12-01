<?php

	class FNCashAdvancePaymentModel extends Base_model
	{

		public $table = 'fn_cash_advance_payment';

		public static $category = [
			'Regular Payment',
			'Available Earnings',
			'Online Payment , Pera-E'
		];
		
		public static $forPaymentName = 'CA_PAYMENT';

		public function create_payment_code($userId, $amount)
		{
			$amount = $amount / 100;
			$sql = "
					INSERT INTO `fn_cash_advance_code_payment`( `userId`, `code`, `amount`, `status`)VALUES";


			for($i=1; $i<=100; $i++)
			{
				$code1=random_number();
				$code2=random_number();
				$code3=random_number();

				$payment_code=substr($code1,0,2).'-'.substr($code2,0,2).'-'.substr($code3,0,3);
				if($i==100)
				{
					$sql .= "('$userId' ,'$payment_code', '$amount' , 'unused')";

				}else
				{
					$sql .= "('$userId' ,'$payment_code', '$amount' , 'unused'),";
				}

			}


			if(!empty($sql))
			{
				$this->db->query($sql);

				$this->db->execute();

			}

			return true;

		}

		public function get_unused_code_by_user($userId)
		{
			$this->db->query(
				"SELECT * FROM fn_cash_advance_code_payment where userId = '$userId'  and status = 'unused' "
			);

			return $this->db->resultSet();
		}

		public function get_used_code_by_user($userId)
		{
			$this->db->query(
				"SELECT * FROM fn_cash_advance_code_payment where userId = '$userId' and status = 'used' order by created_at desc"
			);

			return $this->db->resultSet();
		}


		public function code_validation($code)
		{

			$this->db->query("SELECT code FROM fn_cash_advance_code_payment where code = '$code' and status = 'unused'");

			return $this->db->single();


		}

		public function get_user_cash_advance_payments($userid)
		{

			$this->db->query(
				"SELECT * FROM `fn_cash_advance_payment` WHERE userid='$userid'"
							);

			return $this->db->resultSet();

		}

		/*public function make_payment($userId, $code )
		{
			$date = date('Y-m-d');

			$time = date('h:i:s');

			$this->db->query("UPDATE `fn_cash_advance_code_payment` SET `status`='used',`accepted_by`='$userId',`date`='$date',`time`='$time' WHERE code='$code' and status = 'unused'");

			if($this->db->execute()){

				Flash::set("Payment Approved!");
				redirect("/FNCashAdvancePayment/search_code");

			}else{
				Flash::set("ERROR");
				redirect("/FNCashAdvancePayment/search_code");
			}


		}*/

		public function make_payment($loanId, $amount, $branchid, $userId, $filename, $cashier_id)
		{

			$code = $this->make_code();

			$this->db->query("INSERT INTO `fn_cash_advance_payment`(`userid`, `loanid`, `code`, `amount`, `image`, `cashier_id`)
							  VALUES ('$userId', '$loanId', '$code', '$amount', '$filename', '$cashier_id')");

			if($this->db->execute())
			{
				$this->db->query("INSERT INTO `fn_cash_inventories`(`branchid`, `amount`, `description`)
							  VALUES ('$branchid','$amount','Cash Advance Payment code $code')");
				$this->db->execute();


			    $this->db->query(
	            "UPDATE `fn_cash_advances` SET `status`='Paid' WHERE (SELECT SUM(amount) FROM fn_cash_advance_payment WHERE loanId = $loanId) >= (SELECT amount FROM fn_cash_advances WHERE id = $loanId) AND id = $loanId"
	        	);
	       		$this->db->execute();

	       		$this->db->query(
	            "SELECT status
				 FROM `fn_cash_advances`
				 WHERE id = '$loanId'"
	       		 );

	       		 $status =  $this->db->single()->status;

	       		 if($status == "Paid")
	       		 {

					return 'ok1';

			     }else{

			     	return 'ok2';
			     }
			}


		}


		public function make_code()
		{
			$prefix = random_number(2);
			$middle = random_number(4);
			$suffix = random_number(3);
			return "{$prefix}-{$middle}-{$suffix}";
		}


		public function getByBranch($branch_id)
		{
			$this->db->query(
				"SELECT p.* , concat(firstname , ' ',lastname) as fullname , username
				 FROM $this->table as p
					LEFT JOIN users as u on u.id = p.userid
					WHERE p.branch_id = '{$branch_id}'"
			);
			return $this->db->resultSet();
		}


		/*
		*userid
		*loadid
		*code
		*amount
		*path
		*cashier_id
		*branch_id
		*category
		*/
		public function pay( $params )
		{

			$this->CashAdvanceModel = model('FNCashAdvanceModel');
			$this->cashInventoryModel = model('FNCashInventoryModel');

			$code = $this->make_code();

			//insert payment to advance payment
			$payment = parent::store([
				'userid' => $params['userId'],
				'loanid' => $params['loanId'],
				'code'    => $code,
				'amount'  => $params['amount'],
				'path'    => 'ca_payments',
				'cashier_id' => $params['cashierId'],
				'branch_id'  => $params['branchId'],
				'category'  => self::$category[1]
			]);

			/*INSERT LOGS*/
			$logs = $this->cashInventoryModel->make_cash([
				'branchid' => $params['branchId'],
				'amount'   => $params['amount'],
				'description' => "Cash Advance Payment code $code , Payment by : <b>{$params['payerFullname']}</b> using Available earnings"
			]);

			/*UPDATE CASH ADVANCE REQUEST*/
			$userCashAdvance = new FNCashAdvanceUserModel($params['userId'],null);

			/*CHECK IF USER HAS NO OUTSTANDING BALANCE*/
			if($userCashAdvance->getBalance() <= 0) {
				/*UPDATE ALL USERS CASH ADVANCE REQUEST TO PAID*/
				$this->CashAdvanceModel->setAllApprovedToPaid($params['userId']);
			}

			if(!$payment || !$logs)
				return false;

			$this->code = $code;
			return true;
		}
	}
