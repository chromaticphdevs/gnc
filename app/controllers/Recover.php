<?php 	

	class Recover extends Controller
	{
		public function __construct()
		{
			$this->recoverModel = $this->model('recoverModel');
		}
		public function initiate()
		{
			if(isSubmitted()) {
				$this->recoverModel->sendNewPassoword($_POST['email'] , $_POST['userid']);
			} else {
				if(isset($_GET['email'])){
					
					$email = trim($_GET['email']);
					/*nit usermodel*/

					$this->userModel = $this->model('user_model');

					$data =[ 
						'userList' => $this->userModel->get_list( " WHERE email = '{$email}'")
					];

					$this->view('recover/index' , $data);

				}else{
					$this->view('recover/index');
				}
			}
		}

		public function changePassword()
		{
			if(isset($_GET['sessionid'] , $_GET['token']))
			{
				$data =[
					'sessionid' => $_GET['sessionid'] ,
					'token'     => $_GET['token']
				];

				$this->recoverModel->changePassword($data);
			}else
			{
				//error
			}
		}
	}