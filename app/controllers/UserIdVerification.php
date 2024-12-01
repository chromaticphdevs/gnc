<?php

	use Services\UserSocialMediaService;
	load(['UserSocialMediaService'], APPROOT.DS.'services');

	class UserIdVerification extends Controller
	{

		public function __construct()
		{
			parent::__construct();

			$this->UserIdVerificationModel = $this->model('UserIdVerificationModel');
			$this->user_model = $this->model('User_model');
			$this->userNotificationModel = model('UserNotificationModel');
			$this->UserSocialMediaModel = $this->model('UserSocialMediaModel');

			$this->socialMediaService = new UserSocialMediaService();

		}

		public function index() {
			$req = request()->inputs();
			$userId = $req['user_id'] ?? whoIs()['id'];

			$data = [
				'Userid' => $userId,
		     	'result' => $this->UserIdVerificationModel->getUserids($userId),
		     	'notes' => $this->user_model->get_qualification_notes($userId)
		    ];

			return $this->view('user_id_verification/index', $data);
		}



		public function verified_list($status)
		{
			$branch_user = Session::get('BRANCH_MANAGERS'); 

			$data = [
                'result' => $this->UserIdVerificationModel->verified_list($status),
				'navigationHelper' => $this->navigationHelper
            ];

			$this->view('user_id_verification/verified_list',$data);
		}

		public function get_user_uploaded_id($user_id)
		{
			
			if($this->request() === 'POST')
			{	

			}else{

				$data = [
	                'result' => $this->UserIdVerificationModel->get_user_uploaded_id($user_id)
	            ];

				$this->view('user_id_verification/get_all_user_id',$data);

			}

		}

		public function upload_id()
		{
			if(Session::check('USERSESSION'))
			{
				
				if($this->request() === 'POST')
				{	

				}else{

					$this->user_id = Session::get('USERSESSION')['id']; 

					$data = [
						'comment' => $this->UserIdVerificationModel->get_id_comment( $this->user_id ),
		                'result' => $this->UserIdVerificationModel->get_user_uploaded_id( $this->user_id )
		            ];

					$this->view('user_id_verification/upload_id',$data);

				}

			}else{
				redirect('users/login');
			}

		}



		public function upload_id_html()
		{
			if(Session::check('USERSESSION'))
			{
				
				if($this->request() === 'POST')
				{	

				}else{

					$this->user_id = Session::get('USERSESSION')['id']; 

					$data = [
		                'result' => $this->UserIdVerificationModel->get_user_uploaded_id( $this->user_id ),
						'navigationHelper' => $this->navigationHelper,
						'notifications' => $this->userNotificationModel->getAll([
							'where' => [
								'un.user_id' => $this->user_id,
								'un.parent_key' => 'UPLOAD_ID_MESSAGE'
							]
					]),
						'socialMediaService' => $this->socialMediaService,
						'socials' => [
							'facebook' => $this->UserSocialMediaModel->get([
								'where' => [
									'user_social.userid' => $this->user_id,
									'user_social.type' => UserSocialMediaService::FACEBOOK,
									'user_social.status' => [
										'condition' => 'not equal',
										'value' => 'deny'
									]
								]
							]),
							'messenger' => $this->UserSocialMediaModel->get([
								'where' => [
									'user_social.userid' => $this->user_id,
									'user_social.type' => UserSocialMediaService::MESSENGER,
									'user_social.status' => [
										'condition' => 'not equal',
										'value' => 'deny'
									]
								]
							])
						] 
		            ];

					$this->view('user_id_verification/upload_id_html',$data);

				}

			}else{
				redirect('users/login');
			}

		}

		public function upload_id_test()
		{
			if(Session::check('USERSESSION'))
			{
				
				if($this->request() === 'POST')
				{	

				}else{

					$this->user_id = Session::get('USERSESSION')['id']; 

					$data = [
		                'result' => $this->UserIdVerificationModel->get_user_uploaded_id( $this->user_id )
		            ];

					$this->view('user_id_verification/upload_id_test',$data);

				}

			}else{
				redirect('users/login');
			}

		}

		public function take_pic_test()
		{	
			if(Session::check('USERSESSION'))
			{
				
			
				if($this->request() === 'POST')
				{		

					 $this->user_id = Session::get('USERSESSION')['id'];
	

					 $this->UserIdVerificationModel->save_id_image_test( $_POST, $this->user_id);

				}else{

					$this->view('user_id_verification/take_pic_test');

				}
			}else{
				redirect('users/login');
			}	
		}

		public function take_pic_html()
		{	
			if(Session::check('USERSESSION'))
			{
				$req = request()->inputs();
				if($this->request() === 'POST')
				{		

					 $this->user_id = Session::get('USERSESSION')['id'];

					 $front_id = $this->upload_image_file($_FILES['front_id']);
					 $back_id = $this->upload_image_file($_FILES['back_id']);
					 
					 $result = $this->UserIdVerificationModel->save_id_image_html($front_id, $back_id, $_POST['ID_type'], $this->user_id);

					 if($result)
					 {
					 	Flash::set("ID Uploaded Successfully");
						redirect('/UserIdVerification/upload_id_html');
					 }
					 
				}else{
					$idTypes = listOfValidIds();
					$data = [
						'idType' => $idTypes[$_GET['type']],
						'uploadedId'     => $this->UserIdVerificationModel->get_user_uploaded_by_type(whoIs()['id'], $req['type']),
						'navigationHelper' => $this->navigationHelper
					];
					$this->view('user_id_verification/take_pic_html', $data);
				}
			}else{
				redirect('users/login');
			}
		}


		public function take_pic()
		{	
			if(Session::check('USERSESSION'))
			{
				
			
				if($this->request() === 'POST')
				{		

					 $this->user_id = Session::get('USERSESSION')['id'];
	

					 $this->UserIdVerificationModel->save_id_image( $_POST, $this->user_id);

				}else{

					$this->view('user_id_verification/take_pic');

				}
			}else{
				redirect('users/login');
			}	
		}

		public function verify_id_list()
		{	
				
			$branchid = $this->check_session();

		
			if($this->request() === 'POST')
			{		
			

			}else{

				if($branchid == "admin")
				{
					$data = [
		                'result' => $this->UserIdVerificationModel->get_user_uploaded_id_all()
		            ];

					$this->view('user_id_verification/verify_id',$data);
				}else{
					$data = [
		                'result' => $this->UserIdVerificationModel->get_user_uploaded_id_by_branch($branchid)
		            ];

					$this->view('user_id_verification/verify_id',$data);
				}				

			}

		}

		public function verify_id($id)
		{	
				
			if ($this->request() === 'POST') {		
				// $branchid = $this->check_session();
			 }else {
				$resp = $this->UserIdVerificationModel->verify_id($id);
				$idDetail = $this->UserIdVerificationModel->get([
					'upi.id' => $id
				]);

				if($resp) {
					$nextIds = $this->UserIdVerificationModel->getAll([
						'where' => [
							'upi.userid' => $idDetail->userid,
							'upi.status' => 'unverified'
						]
					]);

					if(!$nextIds) {
						$nextIds = $this->UserIdVerificationModel->getAll([
							'where' => [
								'upi.status' => 'unverified'
							]
						]);
					}
				}

				if (request()->input('returnTo')) {
					return redirect(unseal(request()->input('returnTo')));
				} else {
					if($nextIds) {
						Flash::set("Id Has been verified");
						return redirect('/UserIdVerification/preview_id_image/'.$nextIds[0]->id);
					}
					Flash::set("All Ids has been processed");
					return redirect('/UserIdVerification/verify_id_list');
				}
			}

			
		}

		public function preview_id_image($id = null)
		{	
			$req = request()->inputs();

			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{		
				

			}else{
				$data = [
					'navigationHelper' => $this->navigationHelper,
					'idDetail'   => $this->UserIdVerificationModel->get([
						'where' => [
							'upi.id' => $id
						]
						]),
					'id' => $id
				];

				$this->view('user_id_verification/user_preview_id', $data);
			}

		
		}

		public function staff_preview_id($id)
		{	
			$this->check_session();

			$userid = unseal($id);

			$data = [
				'Userid' => $userid,
		     	'result' => $this->UserIdVerificationModel->get_user_uploaded_id_info($userid),
		     	'notes' => $this->user_model->get_qualification_notes($userid)
		            ];
			$this->view('user_id_verification/staff_preview_id',$data);
		}


		public function user_customer_preview_id($id)
		{	

			$userid = unseal($id);

			$data = [
				'Userid' => $userid,
		     	'result' => $this->UserIdVerificationModel->get_user_uploaded_id_info($userid),
		     	'notes' => $this->user_model->get_qualification_notes($userid)
		    ];
			$this->view('user_id_verification/user_customer_preview_id',$data);
		}


		public function customerPublicView($id) {
			$userid = unseal($id);

			$data = [
				'Userid' => $userid,
		     	'result' => $this->UserIdVerificationModel->getUserids($userid),
		     	'notes' => $this->user_model->get_qualification_notes($userid)
		    ];
					
			$this->view('templates/public/member_ids',$data);
		}


		public function get_next_uploaded_id()
		{

			$branchid = $this->check_session();
		
			if($this->request() === 'POST')
			{		
		

			}else{

				if(true)
				{
					$result = $this->UserIdVerificationModel->get_next_uploaded_id();

					if(empty($result)){
						redirect('UserIdVerification/verify_id_list');
					}

					$data = [
		                'result' => $this->UserIdVerificationModel->get_next_uploaded_id()
		            ];

					$this->view('user_id_verification/preview_next_id',$data);
				}else{

					$result = $this->UserIdVerificationModel->get_next_uploaded_id_by_branch($branchid);

					if(empty($result)){
						redirect('UserIdVerification/verify_id_list');
					}

					$data = [
		                'result' => $this->UserIdVerificationModel->get_next_uploaded_id_by_branch($branchid)
		            ];

					$this->view('user_id_verification/preview_next_id',$data);
				}				

			}

		}

		public function deny_id($id = null)
		{		
			if($this->request() === 'POST')
			{		
				$branchid = $this->check_session();
				$this->UserIdVerificationModel->deny_id($_POST['id'], $_POST['comment']);
				redirect('UserIdVerification/verify_id_list');
			}else{
				$this->UserIdVerificationModel->deny_id($id, "Denied");
				Flash::set($this->UserIdVerificationModel->getMessageString());
				if(request()->input('returnTo')) {
					return redirect(unseal(request()->input('returnTo')));
				} else {
					return request()->return();
				}
			}		
		}

		public function cancel_qualification()
		{		
			$branchid = $this->check_session();
			if($this->request() === 'POST')
			{		
				$this->UserIdVerificationModel->deny_id($_POST['id'], $_POST['comment']);
		 		return request()->return();
			}else{
						
			}		
		}


		public function cancel_id($id)
		{	
			if(Session::check('USERSESSION'))
			{		

				if($this->request() === 'POST')
				{		
				

				}else{
					$resp = $this->UserIdVerificationModel->deny_id($id,"user cancel");
					$idDetail = $this->UserIdVerificationModel->get([
						'upi.id' => $id
					]);
					
					if($resp) {
						$nextIds = $this->UserIdVerificationModel->getAll([
							'where' => [
								'upi.userid' => $idDetail->userid,
								'upi.status' => 'unverified'
							]
						]);

						if(!$nextIds) {
							$nextIds = $this->UserIdVerificationModel->getAll([
								'where' => [
									'upi.status' => 'unverified'
								]
							]);
						}
					}

					if (request()->input('returnTo')) {
						return redirect(unseal(request()->input('returnTo')));
					} else {
						if($nextIds) {
							Flash::set("Id Has been denied");
							return redirect('/UserIdVerification/preview_id_image/'.$nextIds[0]->id);
						}
						Flash::set("All Ids has been processed");
						return redirect('/UserIdVerification/verify_id_list');
					}
					
					redirect('UserIdVerification/upload_id_html');

				}

			}	
		}

		public function user_preview_id_image()
		{	
			if(Session::check('USERSESSION'))
			{		
				$data = [
					'navigationHelper' => $this->navigationHelper
				];
				$this->view('user_id_verification/user_preview_id', $data);
		
			}	
		}


		private function upload_image_file($image)
		{
		   $file = new File();

            $file->setFile($image)
			->setPrefix('IMAGE')
			->setDIR('../public/assets/user_id_uploads')
			->upload();

			if(!empty($file->getErrors())){

				Flash::set($file->getErrors(), 'danger');
				return false;
			}

			return $file->getFileUploadName();
		}

		private function check_session()
		{
			
			if(Session::check('BRANCH_MANAGERS'))
			{	
				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;

				return $branchid;

				
			}else if(Session::check('USERSESSION'))
			{	
				//Authorization::setAccess(['admin']);

				return 'admin';

			}else{
				redirect('users/login');
			}
		}



	}