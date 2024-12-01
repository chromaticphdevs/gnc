<?php

  class VaultModel extends Base_model
  {
    public $table_name = 'vaults';

    public function get_vaults()
    {
      $this->db->query(
        "SELECT * ,
          (SELECT ifnull(sum(amount) , 0) as vault_amount
            FROM $this->table_name
            WHERE branchid = branch.id
            GROUP BY branchid) as vault_amount,

          (
            SELECT ifnull(sum(amount) , 0) as deposit_amount
            FROM vault_deposits
            WHERE branchid = branch.id and status = 'on-queue'
            GROUP BY branchid
          ) as deposit_amount

         FROM ld_branch as branch"
      );

      return $this->db->resultSet();
    }

    public function withdraw($branchid , $amount)
    {
      $mainBranch = $this->branchModelInstance()->get_main_branch();
      /*add on mainbranch*/
      $add_cash = $this->branchVaultInstance()->add_cash($mainBranch->id , $amount , 'Main Branch Withdraw');
      /*deduct on branch*/
      $deduct_cash = $this->branchVaultInstance()->deduct_cash($branchid , $amount , 'Main Branch Withdraw');

      if($add_cash && $deduct_cash) {
        return true;
      }
      return false;
    }

    public function branchModelInstance()
    {
      return new LDBranchModel();
    }

    public function branchVaultInstance()
    {
      return new BranchVaultModel();
    }

    // public function make_logs()
    // {
    //   $this->db->query(
    //     "INSERT INTO vault_logs()"
    //   );
    // }
  }
