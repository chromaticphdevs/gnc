<?php

use Services\UserService;

	class UsermetaModel extends Base_model
	{

		public $table = 'users_meta';


		public static $types = [
			'SCREENING_NOTES' , 'SCREENING_CALLS', ''
		];

		public $_fillables = [
			'userid',
			'meta_id',
			'meta_key',
			'meta_value',
			'meta_value_type',
			'meta_attribute',
			'is_required',
			'is_verified'
		];

		public function saveEntry($entry) {
			return parent::store($entry);
		}
		/*
		*Override
		*/
		public function store($params)
		{	

			$type = $params['meta_key'] ?? null;

			if(!isEqual($type , self::$types))
			{
				$this->addError("Invalid Meta Type");
				return false;
			}

			$userHasBeenScreened = $this->getScreenings($params['user_id']);

			if($userHasBeenScreened) {
				$this->addError(" User has been already screened today ");
				return false;
			}
			//check if paras is valid
			return parent::store($params);
		}

		public function formatAttribute($params) {
			if(isset($params['meta_attribute'])) {
				$params['meta_attribute'] = json_encode($params['meta_attribute']);
			}
			return $params;
		}


		public function getScreenings( $userId = null , $orderBy = null)
		{	
			/*
			*If user ID is not set
			*call array results
			*/
			if(!is_null($userId)) 
			{
				$data = [
					$this->table,
					'*',

					" user_id = '{$userId}' ",
					$orderBy
				];

				return $this->dbHelper->resultSet(...$data);
			}


			$data = [
				$this->table,
				'*',
				null,
				$orderBy
			];

			return $this->dbHelper->resultSet(...$data);
		}

		public function save($metaData, $id = null) {
			$_fillables = $this->getFillables($metaData);

			if(isEqual($_fillables['meta_key'], UserService::numberKeys())) {
				if(!is_numeric($_fillables['meta_value'])) {
					$this->addError("Value must be a valid number");
					return false;
				}
			}

			$_fillables = $this->formatAttribute($_fillables);

			if(is_null($id)) {
				//create
				$isExist = parent::dbget_single(
					parent::convertWhere([
						'meta_key' => $metaData['meta_key'],
						'userid' => $metaData['userid']
					])
				);

				if($isExist) {
					$this->addError("You already have info for your *{$metaData['meta_key']}*, you can edit it instead.");
					return false;
				}
				return parent::store($_fillables);
			} else {
				$isExist = parent::dbget_single(
					parent::convertWhere([
						'meta_key' => $metaData['meta_key'],
						'userid' => $metaData['userid']
					])
				);
				
				if($isExist && ($isExist->id != $id)) {
					$this->addError("You already have info for your *{$metaData['meta_key']}*, you can edit it instead.");
					return false;
				}
				return parent::dbupdate($_fillables, $id);
			}
		}

		public function getByUser($userId) {
			return parent::dbget_assoc('meta_key', parent::convertWhere([
				'userid' => $userId
			]));
		}
		
		public function get($id) {
			$meta = parent::dbget($id);
			if($meta && !empty($meta->meta_attribute)) {
				$meta->meta_attribute = json_decode($meta->meta_attribute);
			}
			return $meta;
		}
	}