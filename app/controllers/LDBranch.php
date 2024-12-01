<?php 	

	class LDBranch extends Controller
	{	

		public function __construct()
		{
			$this->BranchModel = $this->model('LDBranchModel');	
		
		}

		public function create()
		{

			if($this->request() === 'POST')
			{	

				$user   = Session::get('user');
				$userId = $user['id'];
				$this->BranchModel->create_branch($_POST, $userId);

			}else
			{
				$this->view('lending/branch/create');			
			}

				

		}


		public function transfer_cash_branch()
		{

			if($this->request() === 'POST')
			{	
				$user   = Session::get('user');
				$main_branch_id = $user['branch_id'];

				$this->BranchModel->transfer_cash_branch($_POST, $main_branch_id);

			}
				
		}


	}


