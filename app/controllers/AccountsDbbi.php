<?php 	

	class AccountsDbbi extends Controller
	{	

		public function __construct()
		{
			$this->accountsDbbiModel = $this->model('accountsDbbiModel');
		}

		public function get_list()
		{
			$res = $this->accountsDbbiModel->get_list();

			$data = [
				'userList' => $res 
			];

			$this->view('account/ddbi_list' , $data);
		}
	}