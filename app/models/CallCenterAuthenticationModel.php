<?php 

	class CallCenterAuthenticationModel extends Base_model
	{
		public $userTable;

		public $managerTable;


		public $user;

		public function __construct()
		{
			$this->fnAccountModel = model('FNAccountModel');

			$this->user = model('User_model');

			$this->managerTable = $this->fnAccountModel->table;

			$this->userTable = $this->user->table;
		}


		public function manager($params = [])
		{
			$key = $params['key'];

			$secret = $params['secret'];

			$res = $this->fnAccountModel->get_by_username( $key );

			if(!$res) {
				$this->error = " User not found";
				return false;
			}

			if( password_verify($secret, $res->password) ) 
			{
				$res->whoIs = 'manager';
				$res->fullname = $res->name;
				$res->branch_id = $res->branchid;

				$this->setUser($res);
				return true;
			}

			$this->error = "Password not matched";
			return false;

		}

		public function member($params = [])
		{
			$key  = $params['key'];

			$secret = $params['secret'];

			$res = $this->user->get_by_username( $key );
			
			if(!$res){
				$this->error = " User not found ";
				return false;
			}

			if( password_verify($secret, $res->password) ) {
				$res->whoIs = 'user';
				$res->branch_id = '123123123';
				$this->setUser($res);
				return true;
			}

			$this->error = "Password not matched";
			return false;
		}


		public function setUser($user)
		{
			$this->user = $user;
		}

		public function getUser()
		{
			return $this->user;
		}

	}