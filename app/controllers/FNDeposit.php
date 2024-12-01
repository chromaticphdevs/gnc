<?php

	class FNDeposit extends Controller
	{

		public function __construct()
	    {
	      $this->depositModel = $this->model('FNDepositModel');

	      $this->branchModel  = $this->model('FNBranchModel');
	    }
	    public function make_deposit()
	    {

	      if(!Session::check('BRANCH_MANAGERS'))
	      {
	      	die("Branch Manger must be logged in");
	      }

	      $user = Session::get('BRANCH_MANAGERS');


	      if($this->request() === 'POST')
	      {
	        $branchid    = $_POST['branchid'];
	        $amount      = $_POST['amount'];
	        $description = $_POST['description'];
	        $cashier_id  = $user->id;
	        $branchorigin = $user->branchid;

	        $result =
	          $this->depositModel->make_deposit($branchid , $branchorigin ,$amount , $description,$cashier_id);

	        if($result) {
	          Flash::set("Deposit made , wait for main-branch confirmation");
	        }

	      }

	      $data = [
	      	'title' => 'Deposit',
	      	'branchid' => $user->branchid,
	      	'branches' => $this->branchModel->get_main_branch(),
	      	'withdraw' => $this->depositModel->get_branch_list_withdraw($user->branchid,$user->id),
	      	'deposits' => $this->depositModel->get_branch_list_deposit($user->branchid,$user->id)
	      ];

	      return $this->view('finance/deposit/make_deposit' , $data);
	    }

	    public function get_transactions()
	    {

	      $data = [
	      	'title' => 'Deposit',
	      	'deposits' => $this->depositModel->get_deposits()
	      ];

	      $this->view('finance/deposit/get_transactions' , $data);
	    }

		public function do_action()
	    {
	      if(isset($_POST['confirm']))
	       {
	         $this->confirm();
	       }

	      if(isset($_POST['decline']))
	      {
	        $this->decline();
	      }

	      redirect('FNDeposit/get_transactions/?branchid='.$_POST['branchid']);
	    }

	    public function confirm()
	    {
	      $result =
	        $this->depositModel->confirm($_POST['depositid'],$_POST['cashier_id']);

	        if($result) {
	          Flash::set("Vault Deposit Confirmed" , 'danger');
	        }
	    }

	    public function decline()
	    {
	      $result =
	        $this->depositModel->decline($_POST['depositid']);

	        if($result) {
	          Flash::set("Vault Deposit Declined" , 'danger');
	        }
	    }

	}
