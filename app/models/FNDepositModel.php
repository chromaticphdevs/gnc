<?php 	

	class FNDepositModel extends Base_model
	{

		private $table_name = 'fn_deposits';

		public function __construct()
		{
			parent::__construct();

			$this->cashInventoryModel = new FNCashInventoryModel();

			$this->branchModel        = new FNBranchModel();
		}

		public function make_deposit($branchid , $branch_origin, $amount , $description,$cashier_id)
	    {
		   
		    $branchTotalInventoryAmount = $this->cashInventoryModel->get_branch_total($branch_origin);


		    if($branchTotalInventoryAmount < $amount) 
		    {	
		      	Flash::set("Insufficient branch inventory amount" , 'danger');

		      	return false;
		    }

		    $data = [
		        $this->table_name ,
		        [
		        	'branchid' => $branchid ,
		        	'cashier_id' => $cashier_id ,
		        	'branch_origin' => $branch_origin ,
		        	'amount'   => $amount ,
		        	'description' => $description,
		        	'type' => 'Deposit'
		        ]
		    ];

	        return
	          $this->dbHelper->insert(...$data);
	  	}

	  	public function get_list($params = null)
	  	{
	  		$this->db->query(
	  			"SELECT deposit.* , 
	  				depositor.name as depositor_name ,
	  				beneficiary.name as beneficiary_name

	  			 	FROM $this->table_name as deposit

	  			 	LEFT JOIN fn_branches as depositor 

	  			 	on depositor.id = deposit.branch_origin

	  			 	LEFT JOIN fn_branches as beneficiary 

	  			 	on beneficiary.id = deposit.branchid

	  			 	$params"
	  		);
	  		return $this->db->resultSet();
	  	}

	  	public function get_branch_list($branchid)
	  	{
	  		$where = " WHERE deposit.branch_origin = '$branchid'";

	  		return 	
	  			$this->get_list( $where );
	  	}

	  	public function get_branch_list_withdraw($branchid, $userid)
	  	{	
	  		$where = " WHERE deposit.branch_origin = '$branchid'
	  				   AND type = 'Withdraw' AND cashier_id = '$userid'  
	  				   ORDER BY `created_at` DESC";

	  		return 	
	  			$this->get_list( $where );
	  	}
	  	public function get_branch_list_deposit($branchid, $userid)
	  	{
	  		$where = " WHERE deposit.branch_origin = '$branchid' 
	  				   AND type = 'Deposit' AND cashier_id = '$userid'
	  				    ORDER BY `created_at` DESC";

	  		return 	
	  			$this->get_list( $where );
	  	}
	  	
		public function confirm($depositid, $cashier_id)
	    {
	      $deposit = $this->get_deposit($depositid);

	      $data = [
	        $this->table_name,
	        [
	          'status' => 'confirmed'
	        ],
	        "id = '{$depositid}'"
	      ];

	      if($this->dbHelper->update(...$data))
	      {	

	      	//get branches;
	      	$beneficiary = $this->branchModel->get_branch($deposit->branchid);
	      	$depositor   = $this->branchModel->get_branch($deposit->branch_origin);

	      	//create message;
	      	$beneficiaryData = [
	      		'branchid' => $deposit->branchid,
	      		'amount' => $deposit->amount,
	      		'description' => "Transfered successfull: {$deposit->amount} recieved from {$depositor->name}"	
	      	];

	      	//create message;
	      	$depositorData = [
	      		'branchid' => $deposit->branch_origin,
	      		'cashier_id' =>  $cashier_id,
	      		'amount' => ($deposit->amount * -1),
	      		'description' => "Transfered successfull: {$deposit->amount} sent to {$beneficiary->name}"	
	      	];
	      	/*beneficiary*/
	        $this->cashInventoryModel->make_cash($beneficiaryData);

	        $this->cashInventoryModel->make_cash($depositorData);

	      }
	      return
	        $this->dbHelper->update(...$data);
	    }

	    public function decline($depositid)
	    {
	      $data = [
	        $this->table_name,
	        [
	          'status' => 'declined'
	        ],
	        "id = '{$depositid}'"
	      ];

	      return
	        $this->dbHelper->update(...$data);
	    }

	    public function get_deposits()
	    {
		    $this->db->query(

		    	"SELECT deposit.* ,
		    	(SELECT fn_branches.name from fn_branches 
		    		WHERE fn_branches.id = deposit.branchid) as beneficiary,
		    	(SELECT fn_branches.name from fn_branches 
		    		WHERE fn_branches.id = deposit.branch_origin) as remitter
		    		FROM $this->table_name as deposit"
		    );

	      return $this->db->resultSet();
	    }
	    public function get_deposit($depositid)
	    {
	    	 $this->db->query(

		    	"SELECT deposit.* ,
		    	(SELECT fn_branches.name from fn_branches 
		    		WHERE fn_branches.id = deposit.branchid) as beneficiary,
		    	(SELECT fn_branches.name from fn_branches 
		    		WHERE fn_branches.id = deposit.branch_origin) as remitter
		    		FROM $this->table_name as deposit 
		    		WHERE deposit.id = '$depositid'"
		    );

	      return $this->db->single();
	    }

	    private function branchVaultModelInstance()
	    {
	      return new BranchVaultModel();
	    }
	}