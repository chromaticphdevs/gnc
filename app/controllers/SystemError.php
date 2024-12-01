<?php
	class SystemError extends Controller
	{
		public function index()
		{
			echo 'YOU ARE NOT SUPPOSED TO BE HERE..';
			exit();
		}
		public function unAuthorize()
		{	
			$this->view('error/unauthorize');
		}
	}