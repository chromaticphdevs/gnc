<?php 	

	class Finance extends Controller
	{
		public function index()
		{
			$this->view('lending/user/login');
		}
		
		public function users()
		{
			$this->index();
		}
	}