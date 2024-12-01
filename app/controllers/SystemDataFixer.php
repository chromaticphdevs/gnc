<?php 	

	class SystemDataFixer extends Controller
	{	

		public function __construct()
		{
			$this->SystemDataFixerModel = $this->model('SystemDataFixerModel');
		}

		public function remove_duplicate()
		{
			$this->SystemDataFixerModel->remove_duplicate();
		}


		public function search_upline($username)
		{
			$this->SystemDataFixerModel->search_upline($username);
		}

		public function search_direct($username)
		{
			$this->SystemDataFixerModel->search_direct($username);
		}

		public function delete_test_account_loan($data)
		{
			$this->SystemDataFixerModel->delete_test_account_loan($data);
		}
	}