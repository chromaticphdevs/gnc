<?php 	

	class LDFaceAuthentication extends Controller
	{

		public function __construct()
		{
			$this->faceAuthModel = $this->model('SNEFacialRecognitionModel');
			$this->faceAuthModel->__add_model('userModel' , $this->model('User_model'));
		}

		public function authenticate_account()
		{
			$data = [
				'title' => 'Face Authentication Register'
			];

			if($this->request() === 'POST')
			{
				/*LOAD USER MODEL*/
				$this->ldAuthenticationModel = $this->model('LDUserAuthenticateModel');
				$this->ldAuthenticationModel = $this->model('LDSNEAccountConnectionModel');
				
				$email = $_POST['email'];
				$phone = $_POST['phone'];

				$getuser = $this->ldAuthenticationModel->email_phone_login($email , $phone);
				/*means the account exists*/
				if($getuser) 
				{
					/*check if the account has sne account*/
					$hasSNEAccount = $this->sneAccountConnectionModel->get_account_on_sne($getuser->id);
					/* if the user has no sne account create pre-activated-sne-account*/
					if(!$hasSNEAccount)
					{

					}
				}
			}
			$this->view('lending/face_authentication/authenticate_account' , $data);
		}

		public function register_face()
		{
			if($this->request() === 'POST')
			{
				/*LOAD USER MODEL*/
				$this->ldAuthenticationModel = $this->model('LDUserAuthenticateModel');
				$email = $_POST['email'];
				$phone = $_POST['phone'];

				/*auth get user agent*/
				$getuser = $this->ldAuthenticationModel->email_phone_login($email , $phone , '2');
				if($getuser) 
				{
					//check if nigga has no social network account
					$hasSNEAccount = $this->ldAuthenticationModel->search_on_sne($getuser->id);
					//check password
					// if(!password_verify($password, $getuser->password)) {
					// 	Flash::set("Incorrect Password" , 'danger');
					// 	redirect('SNEFacialRecognition/face_auth_activation_login');
					// 	return false;
					// }
					// /*check if user has already a facial recognition saved*/
					// $getFacialDetail = $this->faceAuthModel->get_auth_detail($getuser->id);

					// if(!empty($getFacialDetail)) {

					// 	Flash::set("You already have activated your face authentication");

					// 	Session::set('FaceRecogUserSession', $getuser);

					// 	redirect('SNEFacialRecognition/face_auth_index');

					// 	return;
					// }

					// //set token
					// /*set session*/
					// Session::set('FaceAuthActivation' , $getuser);

					// if(Session::check('FaceAuthActivation')) {

					// 	redirect('SNEFacialRecognition/face_auth_capture');
					}
					/*check if user has already activated their facial recognition account*/

			}else
			{

				if(Session::check('faceauthentication'))
				{
					$user = Session::get('user');

					$this->view('lending/face_authentication/register_face');
				}else{
					
				}
			}
		}
	}