<?php 	
	/*
	*TEMPORARY CODES
	*NOT OPTIMIZED
	*/
	class BinaryGeneologyWide extends Controller
	{
		public function __construct()
		{
			$this->geneology = $this->model('UserGeneologyModel');	
			$this->userModel = $this->model('User_model');	
		}

		public function index()
		{
			$geneology = $this->geneology->getWithMultipleDownlines();

			return $this->view('geneology/wide' , compact(['geneology']));
		}

		public function user()
		{	
			$user = Session::get('USERSESSION');
			$userId = $user['id'];

			if(isset($_GET['user_id']))
			{
				$userId = $_GET['user_id'];
				$user = (array) $this->userModel->dbget($userId);
			}

			if(isset($_GET['username']))
			{
				$username = $_GET['username'];
				$user = (array) $this->userModel->get_by_username($username);

				$userId = $user['id'];
			}
			

			if(isset($_GET['upline']))
			{
				$res = $this->userModel->dbupdate([
					'upline' => $_GET['upline']
				],$_GET['user_id']);

				if($res) {
					Flash::set("Upline Moved");

					return request()->return();
				}
			}	

			$geneology = $this->geneology->getDownlinesMultipleAllowed($userId);

			return $this->view('geneology/wide_user' , compact(['geneology' ,'user']));
		}	
	}