<?php

  class FNCashAdvancePaymentUserModel extends Base_model
  {

    public $table = 'fn_cash_advance_payment';

    public function __construct($user_id,$loan_id)
    {
      parent::__construct();

      $this->user_id = $user_id;
      $this->loan_id = $loan_id;
    }

    public function getUser()
    {
      $user = new User_model();

      return $user->get_user($this->user_id);
    }

    public function getAll()
    {
      $this->db->query(
        "SELECT * FROM $this->table
          WHERE userid = '{$this->user_id}'"
      );
      return $this->db->resultSet();
    }

    public function getTotal()
    {
      $this->db->query(
        "SELECT sum(amount) as total FROM
          $this->table
          WHERE userid = '{$this->user_id}' and loanid='{$this->loan_id}'"
      );
      return $this->db->single()->total ?? 0;
    }

    public function getPaymentHistory()
    {
      $this->db->query(
        "SELECT * FROM $this->table
          WHERE loanid = '{$this->loan_id}'"
      );
      return $this->db->resultSet();
    }
  }
