<?php

  class BranchVaultModel extends Base_model
  {
    private $table_name = 'vaults';

    public function add_cash($branchid , $amount , $description)
    {
      $data = [
        $this->table_name ,
        [
          'branchid' => $branchid ,
          'amount' => $amount,
          'description' => $description
        ]
      ];
      return
        $this->dbHelper->insert(...$data);
    }

    public function deduct_cash($branchid , $amount , $description)
    {
      $amount = $amount * -1;//make amount negative
      $data = [
        $this->table_name ,
        [
          'branchid' => $branchid ,
          'amount' => $amount,
          'description' => $description
        ]
      ];
      return
        $this->dbHelper->insert(...$data);
    }
    public function get_logs($branchid)
    {
      $this->db->query(
        "SELECT *
          FROM $this->table_name
          WHERE branchid = '$branchid'"
      );

      return $this->db->resultSet();
    }

    public function get_vault_total($branchid)
    {
      $this->db->query(
        "SELECT SUM(amount) as vault_total
          FROM $this->table_name
          WHERE branchid = '$branchid'"
      );


      $result = $this->db->single();

      if(!empty($result)) {

        return $result->vault_total;
      }

      return 0; 
    }

    public function get_main_branch_total()
    {
      $this->db->query(
        "SELECT ifnull(SUM(amount) , 0) as vault_total
          FROM $this->table_name as vault
          LEFT JOIN ld_branch on vault.branchid = ld_branch.id

          WHERE ld_branch.type = 'main-branch'"
      );

      $result = $this->db->single();

      if(!empty($result)){
        return $result->vault_total;
      }
      return 0;
    }
    //get vault list
  }
