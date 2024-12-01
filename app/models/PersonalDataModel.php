<?php 

	class PersonalDataModel extends Base_model
	{
		public $table = 'personal_data';
		public $_fillables = [
			'user_id',
			'status',
			'status_modified',
			'firstname',
			'lastname',
			'middlename',
			'gender',
			'date_of_birth',
			'place_of_birth',
			'nationality',
			'country_code',
			'city',
			'address',
			'occupation',
			'height',
			'weight',
			'email',
			'phone',
			'is_email_verified',
			'is_phone_verified',
			'created_at',
			'updated_at'
		];


		public function createOrUpdate($data, $id = null) {
			$_fillables = parent::getFillables($data);

			if (is_null($id)) {
				$this->validationStrict($_fillables);

				if(!empty($this->getErrors())) {
					return false;
				}

				$_fillables['status'] = 'pending';
				$retVal = parent::store($_fillables);
			} else {
				$retVal = parent::dbupdate($_fillables, $id);
			}

			return $retVal;
		}


		public function get($id)
		{
			$data = parent::dbget_single(parent::convertWhere(['user_id' => $id]));

			if(!$data) {
				$this->addError("Master list not found!");
				return false;
			}

			if(!isset($this->beneficiaryModel)) {
				$this->beneficiaryModel = model('BeneficiaryModel');
			}


			$data->beneficiaries = $this->beneficiaryModel->getByUser($id);

			return $data;
		}

		private function validationStrict($data) {
			//check if user already got master list

			$userById = parent::dbget_single(parent::convertWhere(['user_id' => $data['user_id']]));

			if($userById) {
				$this->addError("User already got master file data");
			}
			//check firstname and lastname
			//check email and phone
			//check address	
		}
	}