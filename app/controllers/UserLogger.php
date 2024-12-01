<?php 	

	class UserLogger extends Controller
	{
		public function __construct()
		{
			$this->UserLoggerModel = $this->model('UserLoggerModel');
		}
	
		public function get_user_login()
		{
			if($this->request() === 'POST')
			{
				
			}else
			{
				if(Session::check('USERSESSION'))
				{
					$data = [
					'userList'    => $this->UserLoggerModel->get_user_login()
					];
					$this->view('user_logger/login' , $data);
				}
			}

		}


		public function get_user_logout()
		{
			if($this->request() === 'POST')
			{
				
			}else
			{
				if(Session::check('USERSESSION'))
				{
					$data = [
						'userList'    => $this->UserLoggerModel->get_user_logout()
					
					];
					$this->view('user_logger/logout' , $data);
				}
			}

		}


	}