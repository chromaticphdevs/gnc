<?php 	

	class LDAccountSNETransfer extends Controller
	{

		public function __construct()
		{
			$this->dbbiUserModel = $this->model('LDUserModel');
			$this->sneAccountConnectionModel = $this->model('LDSNEAccountConnectionModel');
		}
		public function preview()
		{
			if(isset($_GET['user'] , $_GET['token']))
			{
				$token = trim($_GET['token']);
				/*userid refers to dbbid*/
				$userid = $_GET['user'];

				if(unseal($token) != 'malupitangtokenmothafucker')
				{

					?> 
						<h1>Token invalid.</h1> 
						<a href="/LDTransferAccount/">Return To Page</a>
					<?php
					return false;
				}

				$data = [
					'dbbiAccount' => $this->dbbiUserModel->get_user($userid)
				];

				$data['sneAccount'] = $this->sneAccountConnectionModel->get_account_on_sne($userid);

				$this->view('lending/transfer/account' , $data);
			}
		}
	}