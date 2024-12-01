<?php

  class UserEarningModel extends Base_model
  {
    public function __construct($userid)
    {
      $this->userid = $userid;
      $this->mgPayoutModel     = new MGPayoutModel();
			$this->mgPayoutItemModel = new MGPayoutItemModel();
			$this->giftcert          = new GiftCertificateModel();
      $this->userBalance = new UserBalance($userid , $this->mgPayoutModel->get_recent_payout());
    }
    
    public function getAvailable()
    {
      $payoutTotal = $this->mgPayoutItemModel->get_user_total_payout($this->userid);

      $totalEarning =  $this->userBalance->getTransactionsTotal();

      return $totalEarning - $payoutTotal;
    }
    
  }
