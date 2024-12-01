<?php 	

	class FNManager extends Controller
	{

		public function __construct()
		{
			$this->accountModel = $this->model('FNAccountModel');
		}

		public function index()
		{
			return $this->login();
		}


		public function login()
		{
			
			if( isEqual(request()->method() , 'post') ) 
			{
				$post = $_POST;
				
				$errors = [];

				$username = trim($post['username']);
				$password = trim($post['password']);

				$result = $this->accountModel->get_by_username($username);

				if(!$result) {
					$errors [] = "Username '{$username}' does not exists";
				}else
				{	
					if( ! password_verify($password , $result->password) ) 
					{
						$errors [] = "Password is in-correct";
					}
				}

				if(!empty($errors))
				{
					Flash::set( implode(',' , $errors) , 'danger');

					return redirect('FNManager/login');
				}

				/** NO ERRORS */

				Session::set('BRANCH_MANAGERS' , $result);

				Flash::set("Welcome User!");

				return redirect('FNIndex/index');


			}

			$data = [
				'title' => 'Manager Login'
			];


			return $this->view('finance/account/login' , $data);
		}

		public function logout()
		{
			session_destroy();
			
			Flash::set("Account has been logged out" , 'danger');
			
			redirect('FNManager/login');

		}
	}