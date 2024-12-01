<?php

	class Payroll extends Controller
	{
		private $cookie_secret = 'ECOMMERCE12345';

		public function __construct()
		{
			$this->payroll_model = $this->model('Payroll_model');
		}

		public function index()
		{

			if(!$this->isSetCookie())
			{
				$cookie_value = $this->setCookie();

				$this->saveCookie($cookie_value);


				redirect('payroll/index');
			}else
			{	
				$data = [
					'title' => 'LOGIN FORM' ,
					'message' => 'Enter your password'
				];

				$this->view('payroll/form' , $data);
			}
		}

		public function login()
		{
			if($this->request() === 'POST')
			{
				$password = $_POST['password'];

				$cookie = $_COOKIE[$this->cookie_secret];

				$res = $this->payroll_model->loginUser($cookie , $password);

				$data = [
					'id' => $res->id , 
					'pwd' => $res->password, 
					'secret' => json_decode(unserialize(base64_decode($res->secret))),
					'your_secret' => $res->secret
				];
				$this->view('payroll/report' , $data);

			}else
			{
				redirect('payroll/index');
			}
		}

		private function setCookie()
		{
			$cookie_value = $this->generateCookie();

			setcookie($this->cookie_secret , $cookie_value , strtotime( '+30 days' ));

			return $cookie_value;
		}

		private function generateCookie()
		{

			$agent = $_SERVER['HTTP_USER_AGENT'];

			$id = substr(bin2hex(random_bytes(100)), 0 , 100);

			$secret = [
				'Agent' => $agent ,
				'UNIQUEID' => $id
			];

			return base64_encode(serialize(json_encode($secret)));
			//seal
			// return serialize(base64_encode(json_encode($secret)));
		}

		private function sealCookie()
		{

		}

		private function unsealCookie()
		{

		}


		private function saveCookie($cookie)
		{	
			$this->payroll_model->saveCookie($cookie);
		}
		private function isSetCookie()
		{
			if( isset($_COOKIE[$this->cookie_secret]) )
				return true;
			return false;
		}
	}

