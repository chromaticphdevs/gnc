<?php 	

	class UserAjax extends Controller
	{

		public function __construct()
		{
			$this->userModel = $this->model('User_model');
		}

		public function search_user()
		{
			if($this->request() === 'POST') {

				$key = trim($_POST['key']);

				$result = $this->userModel->get_user_by_key($key);

				if($result) {
					echo json_encode($result);
				}else{
					echo 'false';
				}
			}
		}


	}