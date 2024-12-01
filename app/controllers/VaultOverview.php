
<?php

  class VaultOverview extends Controller
  {

    public function __construct()
    {
      $this->branchModel = $this->model('LDBranchModel');
      $this->branchVaultModel = $this->model('BranchVaultModel');
      $this->vaultModel  = $this->model('VaultModel');
    }
    public function index(){
      $this->dashboard();
    }

    public function dashboard()
    {
      /*load models*/
      $branchModel = $this->model('LDBranchModel');

      $data = [
        'title' => "Vault Over View",
        'branchList' => $this->branchModel->get_sub_branches()
      ];

      $data['vault'] = [
        'main'     => [
          'total_amount' => $this->branchVaultModel->get_main_branch_total()
        ],
        'branches' => $this->vaultModel->get_vaults(),
      ];

      $this->view('vaultmanagement/overview' , $data);
    }

  }
