<?php 	
	
	class BankPeraModel extends Base_model 
	{

		public $table = 'bank_pera_accounts';

		public function getByUser($userId)
		{

			return $this->dbHelper->single(...[
				$this->table,
				'*',
				" user_id = '$userId' "
			]);
		}

		public function update_account($response, $userid)
		{	
			$data = [
				$this->table , 
				[
					'api_key' => $response->apiKey,
					'api_secret' => $response->apiSecret,
					'account_number' => $response->accountNumber
				], 
				" user_id = '$userid'"
			];
			
			return 	
				$this->dbHelper->update(...$data);
		}
	}