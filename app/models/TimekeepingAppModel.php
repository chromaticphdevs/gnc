<?php 	
	
	require_once LIBS.DS.'bk_tk/loader.php';

	use BKTK\User as bkUser;
	use BKTK\Timesheet as bkTimesheet;
	use BKTK\Payout as bkPayout;

	class TimekeepingAppModel extends Base_model 
	{

		public $table_name = 'tk_app_data';
		public $table = 'tk_app_data';

		public $table_fn_accounts = 'fn_accounts';

		// public $endpoint = 'https://app.breakthrough-e.com';

        public $endpoint = 'http://dev.bktktool';

        public function __construct()
        {

        	parent::__construct();
        	/*
            *Timekeeping session
            */
        	$this->user = model('User_model');

            if(empty(Session::get('TimekeepingToken')) )
            {
            	Session::set('TimekeepingToken' , uniqid('TK' , true));
            }


            $this->bktk = [

            	'user' => new bkUser() ,
            	'timesheet' => new bkTimesheet(),
            	'payout'   => new bkPayout()
            ];


            $this->session  = Session::get('TimekeepingToken');
        }

		public function getManagerWithAccounts()
		{
			$users = $this->getRegisteredAppAccounts();

			return $users;
		}

		public function getManagerWithoutAccounts()
		{
			$this->db->query(
				"SELECT user.* , tkapp.access_key as tk_acces_key
					FROM $this->table_name as tkapp 
					RIGHT JOIN $this->table_fn_accounts as user 
					ON user.id = tkapp.user_id

					WHERE tkapp.access_key is NULL"
			);

			return $this->db->resultSet();
		}

		public function getWithMeta($fnAccountId)
		{
			$this->db->query(
				"SELECT user.* ,  tkapp.access_key as tk_access_key 
					FROM $this->table_fn_accounts as user
					LEFT JOIN $this->table as tkapp
					ON user.id = tkapp.user_id 

				WHERE user.id = '$fnAccountId' "
			);

			return $this->db->single();
		}


		public function getByAccess($userToken)
		{
			return $this->dbHelper->single(...[
				$this->table_name,
				'*',
				"access_key = '$userToken'"
			]);
		}

		public function getRegisteredAppAccounts()
		{
			return $this->bktk['user']->getAll();
		}

		/*
		*user get by token
		*/
		public function apiGetByToken($token)
		{
			$tkAppData = $this->bktk['user']->getByToken($token);

			if(!$tkAppData)
				return false;


			$this->db->query(
				"SELECT user.* 
					FROM $this->table as appdata
					LEFT JOIN fn_accounts as user 
					ON user.id = appdata.user_id
					WHERE appdata.access_key = '{$tkAppData->domain_user_token}' "
			);

			$userData = $this->db->single();

			$tkAppData->user = $userData;

			return $tkAppData;
		}

		public function apiGetByTokenComplete($token)
		{
			return $this->bktk['user']->getCompleteByToken($token);
		}

		public function apiUpdate($data , $token)
		{
			return $this->bktk['user']->update($data , $token);
		}


		public function getByUserId($userId)
		{
			$data = [
				$this->table,
				'*',
				" user_id = '$userId' "
			];

			return $this->dbHelper->single(...$data);
		}


		public function deleteUser($userId)
		{
			$isDeleted = $this->dbHelper->delete(...[
				$this->table,
				"user_id = '{$userId}' "
			]);

			return $isDeleted;
		}

		public function getTimesheet($id)
		{
			return $this->bktk['timesheet']->get($id);
		}

		public function deleteTimesheet($id)
		{
			return $this->bktk['timesheet']->delete($id);
		}

		/*
		*Delete user by token
		*/
		public function deleteByToken($userToken)
		{	
			$endpoint = $this->endpoint.'/api/user/delete';

			$tkAppData = $this->dbHelper->single(...[
				$this->table , '*' , " access_key = '$userToken' "
			]);

			/*
			*Delete account
			*on the domain
			*/

			if(!$tkAppData)
				return false;

			/*dlete on domain side*/
			$domainDelete = $this->dbHelper->delete(...[
				$this->table, " id = '$tkAppData->id' "
			]); 
			/*
			*DELETE VIA REST API
			*/
			$restDelete = api_call('POST' , $endpoint , compact(['userToken']));
			

			$response = json_decode($restDelete);

			if($domainDelete && $response->status)
				return true;
			return false;
		}

		/**
		 * Approve bulk timesheets
		 */

		public function approveBulk($apiParameter)
		{

			$endpoint = $this->endpoint.'/api/timesheet/approveBulk';

			$result = api_call('POST' , $endpoint , $apiParameter);
			
			$response = json_decode($result);

			if($response->status)
				return true;
			return false;
		}

		public function deleteBulk($apiParameter)
		{
			$endpoint = $this->endpoint.'/api/timesheet/deleteBulk';

			$result = api_call('POST' , $endpoint , $apiParameter);

			$response = json_decode($result);

			if($response->status)
				return true;
			return false;
		}

		public function moveToTrash($apiParameter)
		{
			$endpoint = $this->endpoint.'/api/timesheet/moveToTrash';

			$result = api_call('POST' , $endpoint , $apiParameter);

			$response = json_decode($result);

			if($response->status)
				return true;
			return false;
		}

		/*
		*Restore timesheets that are set to deleted
		*/
		public function restore($apiParameter)
		{
			$endpoint = $this->endpoint.'/api/timesheet/restore';

			$result = api_call('POST' , $endpoint , $apiParameter);

			$response = json_decode($result);

			if($response->status)
				return true;
			return false;
		}


		public function getTrash()
		{
			$endpoint = $this->endpoint.'/api/timesheet/trash';

			$result = api_call('GET' , $endpoint);

			$response = json_decode($result);

			return $response;
		}
	}