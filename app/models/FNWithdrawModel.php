<?php 	

	class FNWithdrawModel extends Base_model
	{

		private $table_name = 'fn_deposits';

		public function __construct()
		{
			parent::__construct();

			$this->cashInventoryModel = new FNCashInventoryModel();

			$this->branchModel        = new FNBranchModel();
			$this->FNCashierModel        = new FNCashierModel();
		}



	      public function make_withdraw($branchid_from , $branch_to, $amount , $cashier_id , $description)
	    {
	  		
	  		//$branchTotalInventoryAmount = $this->cashInventoryModel->get_branch_total($branchid_from);


	    	/*
	    	*Description will be sent to 
	    	*fn_deposits
	    	*/
	    	
	    	$cashier_balance =  $this->FNCashierModel->get_cashier_balance($cashier_id);
	    
		    if($cashier_balance < $amount) 
		    {	
		      	Flash::set("Insufficient Cashier Wallet Balance" , 'danger');

		      	return false;
		    }

		    $data = [
		        $this->table_name ,
		        [
		        	'branchid' => $branch_to ,
		        	'cashier_id' =>  $cashier_id,
		        	'branch_origin' => $branchid_from ,
		        	'amount'   => $amount ,
		        	'description' => $description,
		        	'type' => 'Withdraw',
		        	'status' => "confirmed"
		        ]
		    ];

	        
	        $this->dbHelper->insert(...$data);

	      	//get branches;
	      	$beneficiary = $this->branchModel->get_branch($branch_to);
	      	$depositor   = $this->branchModel->get_branch($branchid_from);

	      	//create message;
	      	$beneficiaryData = [
	      		'branchid' => $branch_to,
	      		'amount' => $amount,
	      		'description' => "Transfered successfull: {$amount} recieved from {$beneficiary->name}",
	      		'notes'  => "{$description}"
	      	];

	      	//create message;
	      	$depositorData = [
	      		'branchid' => $branchid_from,
	      		'cashier_id' =>  $cashier_id,
	      		'amount' => ($amount * -1),
	      		'description' => "Transfered successfull: {$amount} sent by {$depositor->name}"	,
	      		'notes'  => "{$description}"
	      	];
	      	/*beneficiary*/
	        $this->cashInventoryModel->make_cash($beneficiaryData);

	      	return
	        $this->cashInventoryModel->make_cash($depositorData);
	    }

	}