<?php 	

	class UserAccount extends Controller
	{	
		public function __construct()
		{
			$this->userModel = $this->model('User_model');

			$this->userAccountModel  = $this->model('userAccountModel');
		}

		public function create()
		{

			echo "<H1> FEATURE TEMPORARY SUSPEND </H1>";
			// $user = Session::get('USERSESSION');

			// $data = [
			// 	'user' => $this->userModel->get_user($user['id'])
			// ];
				
			// if($this->request() === 'POST')
			// {
			// 	$userid   = $data['user']->id;
			// 	$username = $_POST['username'];
			// 	$password = $_POST['password'];

			// 	$res = $this->userAccountModel->createAccount($username , $password , $userid);


			// 	redirect('UserAccount/create');
			// }else{
			// 	$this->view('useraccount/create' , $data);
			// }
			
		}
	}