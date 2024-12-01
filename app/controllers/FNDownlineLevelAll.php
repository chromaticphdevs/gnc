<?php 	

	class FNDownlineLevelAll extends Controller
	{

		private $account_types = [
			'stock-manager' , 'cashier' , 'branch-manager','cashier-assistance'
		];


		public function __construct()
		{
			$this->DownlineLevel = $this->model('FNDownlineLevelAllModel');
		
		}

	

		public function list_all_second_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$data = [
					'title'       => 'Second Level List',
					'user_list' => $this->DownlineLevel->list_all_second_lvl() 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_by_branch_second_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;

				$data = [
					'title'       => 'Second Level List',
					'user_list' => $this->DownlineLevel->list_by_branch_second_lvl($branchid) 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_all_third_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$data = [
					'title'       => 'Third Level List',
					'user_list' => $this->DownlineLevel->list_all_third_lvl() 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_by_branch_third_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;

				$data = [
					'title'       => 'Third Level List',
					'user_list' => $this->DownlineLevel->list_by_branch_third_lvl($branchid) 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_all_fourth_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$data = [
					'title'       => 'Fourth Level List',
					'user_list' => $this->DownlineLevel->list_all_fourth_lvl() 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_by_branch_fourth_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;


				$data = [
					'title'       => 'Fourth Level List',
					'user_list' => $this->DownlineLevel->list_by_branch_fourth_lvl($branchid) 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_all_fifth_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{

				$data = [
					'title'       => 'Fifth Level List',
					'user_list' => $this->DownlineLevel->list_all_fifth_lvl() 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

		public function list_by_branch_fifth_lvl()
		{
			
			if($this->request() === 'POST')
			{
				

			}else{
				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;
				$data = [
					'title'       => 'Fifth Level List',
					'user_list' => $this->DownlineLevel->list_by_branch_fifth_lvl($branchid) 
			
				];

				$this->view('finance/downline_lvl/levels' , $data);
			}


		}

	
	}
?>