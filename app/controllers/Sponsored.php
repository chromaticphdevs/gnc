<?php 	

	class Sponsored extends Controller
	{

		public function __construct()
		{
			$this->sponsoredModel = $this->model('SponsoredModel');
		}


		public function index()
		{
			$this->summary();
		}
		public function summary()
		{
			Authorization::setAccess(['admin' , 'user']);
			$user = Session::get('USERSESSION');
			$data = [
				'starterTotal' => $this->sponsoredModel->getSummary($user['id'] , 'starter'),
				'bronzeTotal' => $this->sponsoredModel->getSummary($user['id'] , 'bronze'),
				'silverTotal' => $this->sponsoredModel->getSummary($user['id'] , 'silver'),
				'goldTotal' => $this->sponsoredModel->getSummary($user['id'] , 'gold'),
				'diamondTotal' => $this->sponsoredModel->getSummary($user['id'] , 'diamond'),
				'platinumTotal' => $this->sponsoredModel->getSummary($user['id'] , 'platinum'),
			];
			
			$this->view('user/sponsor_summary' , $data);
		}
	}