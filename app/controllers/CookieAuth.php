<?php 	

	class CookieAuth extends Controller
	{

		public function __construct()
		{
			$this->user_model = $this->model('user_model');
			$this->User_Account_Model = $this->model("UserAccountModel");
			$this->activeAccountModel = $this->model('ActiveAccountModel');


			$this->accountModel = $this->model('FNAccountModel');
			$this->UserSocialMediaModel = $this->model('UserSocialMediaModel');

		}

		public function relogin()
		{
			$cookie = authCookie();


			if( isEqual( $cookie->type , 'staff')){
				$this->initManager( $cookie->username );
			}else
			{
				$this->initUser( $cookie->username);
			}
		}


		private function initManager($username)
		{
			$result = $this->accountModel->get_by_username($username);

			Session::set('BRANCH_MANAGERS' , $result);

			Cookie::set('USERSESSION' , $result);

			Flash::set("Welcome User!");

			return redirect('FNIndex/index');
		}

		private function initUser($username)
		{
			$res = $this->user_model->get_by_username($username);

			$this->activeAccountModel->online($res->id);

			$this->activeAccountModel->online($res->id);
			//set session
			
			$this->user_model->sessionUpdate($res->id);
			$user_session = [
				'id' => $res->id ,
				'type' => $res->user_type,
				'selfie' => $res->selfie,
				'firstname' => $res->firstname,
				'lastname'  => $res->lastname,
				'username'  => $res->username,
				'status'    => $res->status,
				'is_activated' => $res->is_activated,
				'branchId'    => $res->branchId,
				'account_tag' => $res->account_tag,
				'is_staff' => $res->is_staff
			];

			redirect('UserIdVerification/upload_id_html');
			//redirect('FNCashAdvance/create');
		}
	}