<?php 	

	class BankTransferLogModel extends Base_model
	{
		public $table = 'bank_transfer_logs';


		/*
		*Transfer id is comming from
		*commission_transactions
		*/
		public function save($transferId , $userId , $description)
		{
			$approvedBy = whoIs()['id'];

			$controlNumber = random_number(12);

			$log = parent::store([
				'control_number' => $controlNumber,
				'approved_by' => $approvedBy,
				'user_id'     => $userId,
				'description' => $description
			]);

			if($log) {
				$this->controlNumber = $controlNumber;
				return true;
			}
			$this->errors = " Bank transfer logging did not went through ";
			return false;
		}


		public function getByUser($userId)
		{
			return $this->dbHelper->resultSet(...[
				$this->table,
				'*',
				" user_id = '{$userId}' "
			]);
		}
	}