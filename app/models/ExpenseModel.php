<?php 	

	class ExpenseModel extends Base_model
	{
		public $table = 'expense_request';

		public function __construct()
		{
			parent::__construct();

			$this->cashInventoryModel = new FNCashInventoryModel();

			$this->branchModel        = new FNBranchModel();
			$this->FNCashierModel        = new FNCashierModel();
		}

		public function get_user_request($userid)
		{	
			$this->db->query(
				"SELECT *
				 FROM expense_request  
				 WHERE userid = '$userid'"
			);

			return $this->db->resultSet();
		}

		public function change_status($id, $status, $note, $processed_by)
		{
	
			if(!empty($note))
			{
				$note = ",`status_note`='$note'";
			}else
			{
				$note = "";
			}

			$this->db->query(
				"UPDATE expense_request 
				 SET `status`='$status',`processed_by`='$processed_by'
				      {$note}
				 WHERE id='$id'
				");
			return $this->db->execute();
		}

		public function get_list_all($branchid, $status)
		{	
			$this->db->query(
				"SELECT *,expense.id as expenseID
				 FROM `expense_request` as expense INNER JOIN fn_accounts as u 
				 WHERE expense.userid = u.id 
				 AND expense.status = '$status'
				 AND expense.branchid = '$branchid'"
			);

			return $this->db->resultSet();
		}

		public function process_request($id, $status, $processed_by)
		{
			$this->db->query(
				"INSERT INTO `expense_request_meta`(`request_id`, `status`, `processed_by`) 
				 VALUES ('$id', '$status', '$processed_by')"
			);

			return $this->db->execute();
		}

		public function wallet_deduction($id, $processed_by)
		{
			$request_info = $this->get_request_info($id);

	    	$cashier_balance =  $this->FNCashierModel->get_cashier_balance($processed_by);

		    if($cashier_balance < $request_info->amount) 
		    {	
		      	Flash::set("Insufficient Cashier Wallet Balance" , 'danger');

		      	return request()->return();
		    }

		    $deduction = [
	      		'branchid' => $request_info->branchid ,
	      		'cashier_id' =>  $processed_by,
	      		'amount' => ($request_info->amount * -1),
	      		'description' => "Released Cash for Expense Request #{$request_info->id}"	
	      	];

	      	return
	        	$this->cashInventoryModel->make_cash($deduction);

		    die($cashier_balance);
		}

		public function get_request_info($id)
		{
			$this->db->query(
				"SELECT *
				 FROM `expense_request`
				 WHERE id = '$id'"	
			);

			return $this->db->single();
		}

		public function get_released($branchid, $cashier_id)
		{
			$this->db->query(
				" SELECT *, SUBSTRING(description , 36, 11) as expense_id,
				 (SELECT userid FROM `expense_request` WHERE id = TRIM(expense_id) ) as userID,
                 (SELECT name FROM fn_accounts WHERE id = userID) as fullname
                  FROM fn_cash_inventories
                  WHERE  branchid = '$branchid' AND cashier_id = '$cashier_id' 
                  AND SUBSTRING(description , 19, 15) ='Expense Request'  
                  ORDER BY id DESC"	
			);

			return $this->db->resultSet();
		}

		public function get_approved_history($branchid, $status)
		{	
			$this->db->query(
				"SELECT *,expense.id as expenseID,
				 (SELECT name FROM fn_accounts WHERE id = expense.userid) as  fullname,
				 (SELECT name FROM fn_accounts WHERE id = expense_meta.processed_by) as  processed_by_name
				 FROM `expense_request` as expense INNER JOIN expense_request_meta as expense_meta 
				 WHERE expense.id = expense_meta.request_id 
				 AND expense_meta.status = '$status'
				 AND expense.branchid = '$branchid'"
			);

			return $this->db->resultSet();
		}


		public function get_all_records()
		{	
			$this->db->query(
				"SELECT *,expense.id as expenseID,
				 (SELECT name FROM fn_accounts WHERE id = expense.userid) as  fullname,
				 (SELECT name FROM fn_accounts WHERE id = expense_meta.processed_by) as  processed_by_name,
                 (SELECT name FROM fn_branches WHERE id =  expense.branchid) as  branch_name
				 FROM `expense_request` as expense INNER JOIN expense_request_meta as expense_meta 
				 WHERE expense.id = expense_meta.request_id 
				 ORDER BY expense_meta.status"
			);

			return $this->db->resultSet();
		}

	}