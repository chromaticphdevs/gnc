<?php 	

	class SNEFacialRecognition extends Controller
	{
		public function __construct()
		{
			$this->faceAuthModel = $this->model('SNEFacialRecognitionModel');
			$this->faceAuthModel->__add_model('userModel' , $this->model('User_model'));
			$this->faceAuthModel->__add_model('User_Account_Model' , $this->model('UserAccountModel'));
		}


		public function index()
		{
			$this->face_auth_activation_login();
		}


		public function logout()
		{
			session_destroy();

			Flash::set("Logged out");

			redirect('SNEFacialRecognition/face_auth_login');
		}

		public function face_auth_index()
		{
			if(Session::check('FaceRecogUserSession'))
			{

				$userid = Session::get('FaceRecogUserSession')->id;

				/*load usermodel*/

				$user_model = $this->model('User_model');


				$data = [
					'user' => $user_model->get_user($userid),
					'face' => $this->faceAuthModel->get_auth_detail($userid)
				];
				
				$this->view('snefacial/index' , $data);
			}else{

				die('Face Session not set');
			}
			
		}

		public function face_auth_activation_login()
		{
			if($this->request() === 'POST')
			{
				/*LOAD USER MODEL*/

				$this->user_model = $this->model('User_model');


				$username = $_POST['username'];
				$password = $_POST['password'];

				/*auth get user agent*/
				$getuser = $this->user_model->user_login($username , $password , '2');

				if($getuser) {

					//check password

					if(!password_verify($password, $getuser->password)) {
						Flash::set("Incorrect Password" , 'danger');

						redirect('SNEFacialRecognition/face_auth_activation_login');
						return false;
					}
					/*check if user has already a facial recognition saved*/
					$getFacialDetail = $this->faceAuthModel->get_auth_detail($getuser->id);

					if(!empty($getFacialDetail)) {

						Flash::set("You already have activated your face authentication");

						Session::set('FaceRecogUserSession', $getuser);

						redirect('SNEFacialRecognition/face_auth_index');

						return;
					}

					//set token
					/*set session*/
					Session::set('FaceAuthActivation' , $getuser);

					if(Session::check('FaceAuthActivation')) {

						redirect('SNEFacialRecognition/face_auth_capture');
					}
					/*check if user has already activated their facial recognition account*/
				}else
				{
					Flash::set("No {$username} found" , 'danger');

					redirect('SNEFacialRecognition/face_auth_activation_login');
				}

			}else{

				$data = [
					'title' => 'Facial Recognition Activation'
				];

				$this->view('snefacial/activation' , $data);
			}
		}

		/*AJAX CALL*/
		public function face_auth_activation()
		{
			if($this->request() === 'POST') 
			{
				$imageSource = $_POST['image'];
				$userid      = Session::get('FaceAuthActivation')->id;
				$user_agent  = $_SERVER['HTTP_USER_AGENT'];		

				$result = $this->faceAuthModel->activate($userid , $imageSource , $user_agent);

				if($result) {

					Session::remove('FaceAuthActivation');

					Flash::set("Face Auth has been saved");

					echo 'ok';
				}	
			}
		}
		public function face_auth_capture()
		{

			if(Session::check('FaceAuthActivation')) 
			{

				$user_model = $this->model('User_model');

				$userid = Session::get('FaceAuthActivation')->id;

				$data = [
					'title' => 'Face Activation Capture',
					'user'  => $user_model->get_user($userid)
				];

				$this->view('snefacial/capture' , $data);
				
			}
			
		}


		public function face_auth_login()
		{
			$userModel = $this->model('user_model');

			if($this->request() === 'POST')
			{
				$imageSource = $_POST['image'];

				$result = $this->faceAuthModel->login($imageSource);

				if(is_bool($result) && $result === true) 
				{
					echo 'ok';
				}else{
					echo '';
				}
			}else{
				$this->view('snefacial/login');
			}
		}
	}