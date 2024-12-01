<?php

	class BeneficiaryModel extends Base_model
	{
		public $table = 'user_beneficiaries';
		public $_fillables = [
			'user_id',
			'status',
			'status_modified',
			'firstname',
			'lastname',
			'middlename',
			'gender',
			'date_of_birth',
			'email',
			'phone',
			'created_at',
			'updated_at'
		];

		public function createOrUpdate($data, $id = null) {
			$_fillables = parent::getFillables($data);

			if(is_null($id)) {
				$_fillables['status'] = 'pending';
				$retVal = parent::store($_fillables);
			} else {
				$retVal = parent::dbupdate($_fillables, $id);
			}

			return $retVal;
		}

		public function getByUser($id) {
			return parent::dbget_assoc('firstname', parent::convertWhere(['user_id' => $id]));
		}
	}