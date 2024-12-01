<?php 	

	class FNWithdraw extends Controller
	{

		public function __construct()
	    {
	      $this->withdrawModel = $this->model('FNWithdrawModel');

	      $this->branchModel  = $this->model('FNBranchModel');

	      $this->cashInventoryModel =  $this->model('FNCashInventoryModel'); 
	      $this->FNCashierModel = $this->model('FNCashierModel');
	    }


	    public function make_withdraw()
	    {

	      if(!Session::check('USERSESSION'))
	      {
	      	die("Admin must be logged in");
	      }

	      $user = Session::get('USERSESSION');
	 
	      if($this->request() === 'POST')
	      {

	      	$result_explode = explode('|', $_POST['cashier_id']);  
	        $cashier_id    = $result_explode[0];
	        $branch_from    = $result_explode[1];

	        $amount      = $_POST['amount'];
	        $description = $_POST['description'];

	        $branch_to = $user['branchId'];

	        $result =
	          $this->withdrawModel->make_withdraw($branch_from , $branch_to ,$amount , $cashier_id , $description);

	        if($result) {
	          Flash::set("Withdraw has been successfully made ");
	        }

	      }

	      //'branch_total_cash'=> $this->cashInventoryModel->get_branch_all_total(),
	      $data = [
	      	'title' => 'Deposit',
	      	'branchid' => $user['branchId'],
	      	'branches' => $this->branchModel->get_list(),
			'cashier_wallet' => $this->FNCashierModel->get_cashier_wallet_info(),
	      	'branch_logs' => $this->cashInventoryModel->get_list_descending()
	      ];

	      $this->view('finance/withdraw/make_withdraw' , $data);
	    }
	   


	}