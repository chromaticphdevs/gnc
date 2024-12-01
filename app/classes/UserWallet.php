<?php

namespace app\Classes
{
	class UserWallet{

		public $_userId;
		public $db;


		public function __construct($userId , $db)
		{
			$this->_userId = $userId;
			$this->db = $db;
		}


		//balances -  withdrawls 
		public function walletBalance()
		{

			$wallet = $this->balances($this->_userId);
			$withdraw = $this->withdrawTotal($this->_userId);

			return $this->computeWallet($wallet , $withdraw);
		}

		//total withdrawals
		public function withdrawTotal()
		{

			$this->db->query("SELECT sum(amount) as total from wallet_withdrawals where user_id = :user_id ");
			$this->db->bind(':user_id' , $this->_userId);


			$res = $this->db->single();
			
			if($this->db->rowCount())
				return $res->total;
			return 0;
		}

		//all balances
		public function balances()
		{
			$this->db->query("SELECT sum(amount) as total from binary_pv_commissions where user_id = :user_id");

			$this->db->bind(':user_id' , $this->_userId);

			$res = $this->db->single();

			if($this->db->rowCount())
				return $res->total;
			return 0;
		}

		//withdrawals list
		public function withdrawals()
		{
			$this->db->query("SELECT * FROM wallet_withdrawals where user_id = :user_id");
			$this->db->bind(':user_id' , $this->_userId);
			
			return $this->db->resultSet();
		}

		
		private function computeWallet($totalwallet , $totalwithdraw)
		{
			return $totalwallet - $totalwithdraw;
		}
	}
}
