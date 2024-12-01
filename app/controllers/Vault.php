<?php

  class Vault extends  Controller
  {
    public function __construct()
    {
      $this->vaultModel = $this->model('VaultModel');
    }
    public function withdraw()
    {
      if($this->request() === 'POST')
      {
        $branchid = $_POST['branchid'];
        $amount   = $_POST['amount'];

        $result = $this->vaultModel->withdraw($branchid , $amount);

        if($result){
          Flash::set("Amount {$amount} successfuly withdrawn.");
        }

        redirect('VaultOverview');
      }
    }
  }
