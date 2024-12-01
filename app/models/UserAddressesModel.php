<?php 	

	class UserAddressesModel extends Base_model
	{
		public $table = 'user_addresses';


		public function add($val)
		{
			//search muna
			$isOk = true;

			$data = [
				$this->table,
				'*',
				" userid = '{$val['userid']}' and type = '{$val['type']}'"
			];

			$isExists = $this->dbHelper->single(...$data);

			if($isExists)
			{
				$isOk = parent::dbupdate([
					'address' => $val['address']
				], $isExists->id);
			}else
			{
				$isOk = parent::store([
					'address' => $val['address'],
					'userid'  => $val['userid'],
					'type'    => $val['type']
				]);
			}
		
			return $isOk;
		}

		public function getParam($condition)
		{
			$conditionString = parent::dbParamsToCondition($condition);

			$data = [
				$this->table,
				'*',

				$conditionString
			];

			return $this->dbHelper->single(...$data);
		}


		public function addCOP($val)
		{
			return $this->add([
				'address' => $val['address'],
				'userid'  => $val['userId'],
				'type'    => 'COP'
			]);
		}
		
		public function getCOP($userId)
		{
			return $this->getParam([
				'userid' => $userId,
				'type'    => 'COP',
				'is_show'    => 'yes'
			]);
		}
	}