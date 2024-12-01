
<?php 	

	class RFID_Register extends Controller
	{	

		public function __construct()
		{
			$this->RFID_User_UID_Modal = $this->model('RFID_User_UID_Modal');	

		}

		public function index(){


			if($this->request() === 'POST') 
			{
	
				$this->RFID_User_UID_Modal->record_user_UID($_POST);

			}else{

				$this->view('/rfid_scanning/user_register');
			}
			

		}


	}




