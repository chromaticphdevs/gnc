<?php

  class BranchVault extends Controller
  {

    public function __construct()
    {
      $this->branchVaultModel= $this->model('BranchVaultModel');

      $this->branchDepositModel = $this->model('BranchDepositModel');
    }
    public function get_logs()
    {
      if(isset($_GET['branchid']))
      {
        $branchid = $_GET['branchid'];

        $data = [
          'branchid' => $branchid,
          'logs'     => $this->branchVaultModel->get_logs($branchid),
          'deposits'  => $this->branchDepositModel->get_list($branchid)
        ];

        $this->view('branchvault/list' , $data);
      }
    }
  }
