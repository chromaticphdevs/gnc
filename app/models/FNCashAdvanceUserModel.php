<?php

  class FNCashAdvanceUserModel extends Base_model
  {

    /**
    *fn_cash_advance_payment
    *fn_product_release
    *fn_cash_advances
    *users
    */

    public function __construct($user_id, $loan_id )
    {
      parent::__construct();
      $this->user_id = $user_id;
      $this->loan_id = $loan_id;
    }

    /*
    *Balance Should not contain paid
    *paid cash advance is not a balance
    *User will have a un-ending balance if the paid loan being fetched as a loan balance
    *Previous Jul/4/2020
    */

    // public function getBalancek()
    // {
    //   $user_id = $this->user_id;
    //
    //   $this->db->query(
    //     "SELECT ( SELECT ifnull(sum(amount) , 0) FROM fn_cash_advances
    //       WHERE userid = '$user_id' and status in('approved' , 'paid')) -
    //     (SELECT ifnull(sum(amount) , 0)
    //     FROM fn_cash_advance_payment
    //     WHERE userid = '$user_id' and loanid='{$this->loan_id}')
    //     as balance"
    //   );
    //   return $this->db->single()->balance ?? 0;
    // }

    public function getBalance()
    {
      $user_id = $this->user_id;

      $this->db->query(
        "SELECT ( SELECT ifnull(sum(amount) , 0) FROM fn_cash_advances
          WHERE userid = '$user_id' and status in('approved')) -
        (SELECT ifnull(sum(amount) , 0)
        FROM fn_cash_advance_payment
        WHERE userid = '$user_id' and loanid='{$this->loan_id}')
        as balance"
      );
      return $this->db->single()->balance ?? 0;
    }


    /*
    *IMPORTANT!!!
    *An issue will occur if the admin approved a loan on the user
    *wherein user still have an approved cash advance
    */

    /*
    *Get Recent Loan
    *which is accepted
    */
    public function getRecent()
    {
      $user_id = $this->user_id;

      $this->db->query(
        "SELECT * from fn_cash_advances
          WHERE userid = '{$user_id}' and status = 'approved'
          limit 1"
      );
      return $this->db->single();
    }


    public function getUser()
    {
      $user = new User_model();

      return $user->get_user($this->user_id);
    }

    public function getTotal()
    {
      $user_id = $this->user_id;

      $this->db->query(
        "SELECT ifnull(sum(amount) , 0) as total
          FROM fn_cash_advances
          WHERE userid = '{$user_id}'  and status = 'approved'"
      );

      return $this->db->single()->total ?? 0;
    }


    public function getAll()
    {

    }

    public function getLoanInfo()
    {
       $loan_id = $this->loan_id;

        $this->db->query(
          "SELECT * from fn_cash_advances
            WHERE id = '{$loan_id}'"
        );
        return $this->db->single();
    }
  }
