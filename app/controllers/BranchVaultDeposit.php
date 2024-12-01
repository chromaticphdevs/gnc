<?php

  class BranchVaultDeposit extends Controller
  {

    public function __construct()
    {
      $this->vaultDepositModel = $this->model('BranchDepositModel');
    }
    public function make_deposit()
    {
      if($this->request() === 'POST')
      {
        $branchid    = $_POST['branchid'];
        $amount      = $_POST['amount'];
        $description = $_POST['description'];

        $result =
          $this->vaultDepositModel->make_deposit($branchid , $amount , $description);

        if($result) {
          Flash::set("Deposit made , wait for main-branch confirmation");
        }else{

          Flash::set("Sorry, Insufficient Balance");

        }

        redirect("cashier/vault_deposit");
      }
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
      
      redirect('branchVault/get_logs/?branchid='.$_POST['branchid']);
    }

    public function confirm()
    {
      $result =
        $this->vaultDepositModel->confirm($_POST['depositid']);

        if($result) {
          Flash::set("Vault Deposit Confirmed" , 'danger');
        }
    }

    public function decline()
    {
      $result =
        $this->vaultDepositModel->decline($_POST['depositid']);

        if($result) {
          Flash::set("Vault Deposit Declined" , 'danger');
        }
    }
  }
