	<?php 	
	class Admin extends Controller{
		/*ADMINISTRATOR PASSSWORD 271022313
		LIVE:3838179217*/
		private $user_id;
		private $user_type;
		
		public function __construct()
		{
			parent::__construct();


			if(is_logged_in()){
				$this->user_id = Session::get('USERSESSION')['id'];
				$this->user_type = Session::get('USERSESSION')['type'];
			}

			$this->user_model = $this->model('user_model');

			$this->transaction_model = $this->model('transaction_model');
		}

		public function index()
		{	
			Authorization::setAccess(['admin']);


			$data  = [
				'title' => 'Admin' 
			];


			if($this->request() === 'POST')
			{
				die(var_dump($_POST));
				$data['today'] = [
						'account' => 
						[
							'list'   =>  $this->user_model->get_activated_users_today($_POST),
							'total'  =>  $this->user_model->get_activated_users_total_today($_POST)
						]
					];

			}else{

				$number_of_days=1;
				$data['today'] = [
						'account' => 
						[
							'list'   =>  $this->user_model->get_activated_users_today($number_of_days),
							'total'  =>  $this->user_model->get_activated_users_total_today($number_of_days)
						]
					];
			}
			$this->view('admin/index' , $data);
		}
		public function login()
		{
			
			if(isset($this->user_id)){
				die('YOU ARE ALREADY LOGGED IN');
			}

			if($this->request() === 'POST')
			{

				
				$username = StringMethod::_clean($_POST['username']);

				$password = StringMethod::_clean($_POST['password']);

				$data = [
					'username' => $username ,
					'password' => $password
				];

				$res = $this->user_model->user_login($username , $password , 1);
				//if there is result

				if($res){

					if(password_verify($password, $res->password))
					{
						//set session

						$user_session = [
							'id' => $res->id ,
							'type' => $res->user_type,
							'selfie' => $res->selfie,
							'firstname' => $res->firstname,
							'lastname'  => $res->lastname,
							'username'  => $res->username,
							'status'    => $res->status
						];
						
						Session::set('USERSESSION' , $user_session);

						set_logged_in();//set user login

						Flash::set("Welcome back {$res->firstname}");
						redirect('admin/');
					}
					else{
						Flash::set("Password un matched" , 'warning');
						$this->view('admin/login' , $data);
					}
				}
				else{

					$data['username_err'] = $username. ' not exists ';

					Flash::set("No User found {$username}" , 'warning');

					$this->view('admin/login' , $data);
				}
			}else{
				$data = [
					'username' => '' ,
					'password' => ''
				];
				$this->view('admin/login' , $data);
			}
		}

		private function call_order_model()
		{
			$this->order_model = $this->model('order_model');
		}
	}