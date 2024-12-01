<?php 	
	
	require_once LIBS.DS.'bk_tk/loader.php';
	
	use BKTK\Payout as bkPayout;
	use BKTK\Wallet as bkWallet;

	class TKPayoutModel extends Base_model
	{
		
		// public $endpoint = 'https://app.breakthrough-e.com';

		public $endpoint = 'http://dev.bktktool';
		
		public function __construct()
		{
			parent::__construct();

			$this->bktk = [
				'payout' => new bkPayout(),
				'wallet' => new bkWallet()
			];
		}

		public function getAll(){
			return $this->bktk['wallet']->getAll();
		}

		public function singlePayout($userId){
			return $this->bktk['payout']->single($userId);
		}

		public function multiplePayout($usersIds){
			return $this->bktk['payout']->multiple($usersIds);
		}
	}