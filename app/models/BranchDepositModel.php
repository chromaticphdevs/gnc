<?php

  class BranchDepositModel extends Base_model
  {

    private $table_name = 'vault_deposits';

    public function get_list($branchid)
    {
      $this->db->query(
        "SELECT deposit.* , branch_name
          FROM $this->table_name as deposit
          left join ld_branch on
          ld_branch.id = branchid
          Where branchid  = '$branchid'"

      );

      return $this->db->resultSet();
    }

    public function make_deposit($branchid , $amount , $description)
    {
      $this->db->query(
        "SELECT sum(amount) as prev_amount FROM `vaults` WHERE branchid= '$branchid '"
      );

      $result = $this->db->single();
   
      if($result->prev_amount >= $amount)
      {
            $data = [
              $this->table_name ,
              [
                'branchid' => $branchid ,
                'amount'   => $amount ,
                'description' => $description
              ]
            ];

            return
              $this->dbHelper->insert(...$data);

      }else
      {

        return false;

      }

  }

    public function confirm($depositid)
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
        $this->branchVaultModelInstance()->deduct_cash($deposit->branchid ,$deposit->amount ,'Confirmed Deposit Deposit' );
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

    public function get_deposit($depositid)
    {
      $this->db->query(
        "SELECT deposit.* , branch_name
          FROM $this->table_name as deposit
          left join ld_branch on
          ld_branch.id = branchid
          Where deposit.id  = '$depositid'"
      );

      return $this->db->single();
    }

    private function branchVaultModelInstance()
    {
      return new BranchVaultModel();
    }
  }
