<?php

	class UserBalance
	{

		/*
		*SECOND PARAMETER IS NOT USED ANY MORE
		*BUT to support previous version is should stay there
		**/
		public function __construct($userid , $lastPayout = null)
		{
			$this->lastPayout = $lastPayout;
			$this->userid = $userid;
			$this->db = new Database();
		}

		public function getTotalCashOut()
		{
			$userid = $this->userid;

			$sql = "SELECT sum(amount) as total from payout_cheque where user_id = '$userid'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total ;
			return 0;
		}

		public function getBinary()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'BINARY'";

			$this->db->query($sql);

			return $this->db->single()->total ?? 0;
		}


		/**
		*SUBJECT FOR DELETION
		*DEPRECATED
		*2020/6/24
		**/
		public function getUnDeductBinary()
		{
			$userid = $this->userid;

			$lastPayoutDate = $this->lastPayout;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total from commission_transactions
			where userid = '$userid'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		/*payout from bnary*/
		private function getWalletWithdrawals()
		{
			$userid = $this->userid;

			$sql = "SELECT sum(amount) as total from wallet_withdrawals where user_id = '$userid' ";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		public function getDrc()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'DRC'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}

		public function getTransactionsTotal()
		{
			$userid = $this->userid;
			
			$this->db->query(
				"SELECT ifnull(sum(amount) , 0 ) as total
				FROM commission_transactions where userid = '$userid'"
			);

			return $this->db->single()->total;
		}

		public function getAdjustment()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'ADJUSTMENT'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}


		public function getCashAdancePayment()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'CA_PAYMENT'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}

		public function getUnilevel()
		{
			$userid = $this->userid;

			$sql = "SELECT ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'UNILEVEL'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}

		public function getMentor()
		{
			$userid = $this->userid;

			$sql = "SELECT  ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'MENTOR'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}


		public function getCashAdvance()
		{
			$userid = $this->userid;

			$sql = "SELECT  ifnull(sum(amount) , 0 ) as total
			FROM commission_transactions where userid = '$userid' and type = 'CASH-ADVANCE'";

			$this->db->query($sql);

			return $this->db->single()->total;
		}


		/***************************
		** ALL METHODS BELOW ARE SUBJECT TO BE REMOVED
		****************************
		****************************/
		/**
		*SUBJECT FOR DELETION
		*DEPRECATED
		*2020/6/24
		** CHANGED TO UserEarningModel
		**/
		public function getTotalMoney()
		{
			$totalMoney = $this->getTotalMainCommission() + $this->getBinary();

			return $totalMoney;
		}

		/**
		*SUBJECT FOR DELETION
		*DEPRECATED
		*2020/6/24
		** Payout Process modified
		**/
		public function getTotalMainCommission()
		{
			$userid = $this->userid;

			$lastPayoutDate = $this->lastPayout;

			$sql = "SELECT sum(amount) as total from commissions where c_id = '$userid'
			and dt > '$lastPayoutDate'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		/**
		*DEPRECATED
		*2020/6/24
		**/
		private function getMainCommissionDeduction()
		{
			$userid = $this->userid;

			$sql = "SELECT sum(amount) as total from comission_deductions
			where user_id = '$userid'";

			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}

		/**
		*DEPRECATED
		*2020/6/24
		**/
		private function getMainCommissionTotal()
		{
			$maincommission = $this->getMainCommission();
			$maincommissionDeductor = $this->getMainCommissionDeduction();

			$binaryDeductor   = $this->getWalletWithdrawals();
			return $maincommission - ($maincommissionDeductor +  $binaryDeductor);
		}
	}
