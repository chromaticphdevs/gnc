<?php

  class FNCashAdvanceAdmin extends Controller
  {
    public function __construct()
    {
      $this->cashAdvance = $this->model('FNCashAdvanceModel');
      $this->userModel = $this->model('User_model');

      /*Admin access only*/
      Authorization::setAccess(['admin']);

    }

    public function index()
    {

      $data = [];

      return $this->view('finance/cash_advance_admin/create' , $data);
    }

    public function create()
    {
      $data = [];

      return $this->view('finance/cash_advance_admin/create' , $data);
    }

    /*
    *Show Selected users loans
    */
    public function show()
    {
      $user_id = request()->input('userid');

      $userCashAdvance = new FNCashAdvanceUserModel($user_id,null);
      $cashAdvanceRecent = $userCashAdvance->getRecent();

      $userInfo = $this->userModel->get_user($user_id);
      
      //if user has recent cash-advance
      if($cashAdvanceRecent){
        $userCashAdvance = new FNCashAdvanceUserModel($user_id,$cashAdvanceRecent->id);
        $balance = $userCashAdvance->getBalance();
      }else{
        //no recent cash-advance
        $balance = $userCashAdvance->getBalance();
      }

      $amounts = [
        '5000','10000','20000',
        '40000','80000','160000',
        '320000','640000','1280000',
        'others'
      ];

      $data = [
        'loans' => $this->cashAdvance->get_list_by_user($user_id),
        'balance'   => $balance,
        'recent'    => $cashAdvanceRecent,
        'user_id'   => $user_id,
        'userInfo'  => $userInfo,
        'amounts'   => $amounts
      ];

      return $this->view('finance/cash_advance_admin/show' , $data);
    }

    /*
    *Apply Loan by admin
    */
    public function applyLoan()
    {
      /*
      *get correct loan amount
      *if customer amount is selected and it is not empty
      */
      if(!empty($_POST['custom_amount']) && $_POST['amount'] == 'others') {
        $amount = $_POST['custom_amount'];
      }else{
        $amount = $_POST['amount'];
      }

      /*validated amount*/
      if(!is_numeric($amount)) {
        Flash::set("Amount must be numeric" , 'danger');
        return request()->return();
      }

      $user_id = $_POST['user_id'];
			$userCashAdvance = new FNCashAdvanceUserModel($user_id,null);
			$user            = $this->userModel->get_user($user_id);

			/*check if user has
			*un-settled loan
			*/
			$balance = $userCashAdvance->getBalance();

			if($balance > 0) {
				Flash::set("User have an outstanding balance of {$balance}." , 'warning');
				return request()->return();
			}
			/*
			*check if has pending
			*/
			$hasPending = $this->cashAdvance->getPendingByUser($user_id , $amount);
			if($hasPending)
			{
				Flash::set("User Have a pending request, check your cash advance list for details" , 'warning');
				return request()->return();
			}

      /*check if user has an unpaid loan*/

      $hasApproved = $this->cashAdvance->getApprovedByUser($user_id);

      if($hasApproved)
      {
        Flash::set("User have an unsetelled loan" , 'warning');
				return request()->return();
      }
			/*
			*check if re-loaning currenly paid cash-advance
			*/
			// $isReloan = $this->CashAdvanceModel->isReloan($amount , $user_id);
			/*
			*if no balance then create loan
			*/
			$loanResult = $this->cashAdvance->store([
				'userid' => $user->id,
				'branch_id' => $user->branchId,
        'status'  => 'approved',
				'amount' => $amount,
				'date'   => today(),
				'time'   => getTime(),
				'notes'  => 'Admin triggered loan'
			]);

			Flash::set("Loan success");

			if(!$loanResult) {
				Flash::set("Something went wrong report to webmaster" , 'danger');
			}

			return redirect("FNCashAdvanceAdmin/show/userid={$user->id}");
    }

  }
