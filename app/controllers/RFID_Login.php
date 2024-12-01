
<?php 	

	class RFID_Login extends Controller
	{	

		public function __construct()
		{
			$this->RFID_Login_Modal = $this->model('RFID_Login_Modal');	
			$this->User_Account_Model = $this->model("UserAccountModel");
		}

		public function login(){


			if($this->request() === 'POST') 
			{

				$rfid_UID = $_POST['UID'];

				$result = $this->RFID_Login_Modal->account_details($_POST);

				if(!empty($result))
				{
					
					$user_session = [
						'id' => $result->id ,
						'type' => $result->user_type,
						'selfie' => $result->selfie,
						'firstname' => $result->firstname,
						'lastname'  => $result->lastname,
						'username'  => $result->username,
						'status'    => $result->status,
						'is_activated'    => $result->is_activated,
						'branchId'    => $result->branchId,
						'rfid_UID' => $rfid_UID,
						'account_tag' => $result->account_tag
					];
					

					Session::set('USER_INFO' , $result);

					Cookie::set('USERSESSION' , $user_session);

					Session::set('USERSESSION' , $user_session);


					//get user accounts and put in session
					$user_account_list = [];

					$user_account_list["by_name"] = $this->User_Account_Model->search_by_name_and_email($result->firstname, $result->lastname, $result->email, $result->id);

					Session::set('MY_ACCOUNTS' , $user_account_list);
					

					set_logged_in();//set user login

					
					Flash::set("Welcome back {$result->firstname}");

					//redirect('/cashAdvance/create');
					redirect('/RFID_Login/take_pic');

					

				}else
				{

					Flash::set("Invalid RFID" , 'info');

					redirect('users/login');
					
				}
			}else{

				//$this->view('/rfid_scanning/user_register');
			}
			

		}


		public function take_pic(){

			if($this->request() === 'POST') 
			{

				$this->RFID_Login_Modal->take_pic($_POST);

			}else{

				$this->view('/rfid_scanning/take_pic');
			}

		}



	}




