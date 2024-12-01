<?php

	class UserSocialMedia extends Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->UserSocialMediaModel = $this->model('UserSocialMediaModel');
			$this->UserIdVerificationModel = $this->model('UserIdVerificationModel');
		}

		public function dashboard()
		{
			$data = [
				'social' => $this->UserSocialMediaModel->count_manager_work(),
				'user_id' => $this->UserIdVerificationModel->count_manager_work(),
				'social_week' => $this->UserSocialMediaModel->count_manager_work_week(7),
				'user_id_week' => $this->UserIdVerificationModel->count_manager_work_week(7),
				'social_month' => $this->UserSocialMediaModel->count_manager_work_week(30),
				'user_id_month' => $this->UserIdVerificationModel->count_manager_work_week(30)

			];

	        $this->view('user_social_media/manager_dashboard',$data);

		}

		public function index() {
			$req = request()->inputs();

			$data = [
				'userSocials' => $this->UserSocialMediaModel->getAll([
					'where' => [
						'user_social.status' => $req['status'] ?? 'unverified',
						'YEAR(user_social.date_time)' => date('Y')
					]
				]),
				'navigationHelper' => $this->navigationHelper,
				'req' => $req
			];

			return $this->view('user_social_media/index', $data);
		}

		/**
		 * ** POST REQUEST **
		 * **parameters passed**
		 * user_id - sealed id
		 * link
		 * type
		 * status
		 */
		public function api_add_link() {
			$post = request()->posts();
			$check_link = $this->UserSocialMediaModel->check_duplication_link($post['link'],$post['type']);
			/**
			 * checks if social media is already duplicated
			 */
			if($check_link) {
				echo api_response([
					'message' => 'Error! Invalid Social Media Profile Link',
					'success' => FALSE
				]);
				return;
			} else {
				$userId = unseal($post['userId']);

				$result = $this->UserSocialMediaModel->add_link([
					'link' => $post['link'],
					'type' => $post['type'],
					'userid' => $userId
				],  $userId);

				if($result) {
					$socialMedia = $this->UserSocialMediaModel->dbget($result);
					echo api_response([
						'message' => 'social media updated',
						'success' => TRUE,
						'data' => [
							'link' => $socialMedia->link
						]
					]);
					return;
				}
			}
		}

		public function approve($id) {
			$resp = $this->UserSocialMediaModel->change_status('Verified', unseal($id), " Approved by ". whoIs('username'));
			if($resp) {
				Flash::set('Social Media Approved');
			} else {
				Flash::set('Unable to update social media', 'danger');
			}
			return redirect('UserSocialMedia');
		}

		public function deny($id) {
			$resp = $this->UserSocialMediaModel->change_status('deny', unseal($id), " Approved by ". whoIs('username'));
			if($resp) {
				Flash::set('Social Media Approved');
			} else {
				Flash::set('Unable to update social media', 'danger');
			}
			return redirect('UserSocialMedia');
		}
		
		public function add_link()
		{
			$this->user_id = Session::get('USERSESSION')['id'];

			if($this->request() === 'POST')
			{

				$url =$_POST['link'];
				if (filter_var($url, FILTER_VALIDATE_URL) === FALSE)
				{
					Flash::set("Error! Invalid Social Media Profile Link");
					redirect('UserSocialMedia/add_link');

				}else
				{
					$check_link = $this->UserSocialMediaModel->check_duplication_link($url,$_POST['type']);
	
					if($check_link){

						Flash::set("Link is already used Try other one");
						redirect('UserSocialMedia/add_link');

					}else{

						$result = $this->UserSocialMediaModel->add_link($_POST, $this->user_id);
						if($result)
						{
							Flash::set("Successfully Added");

							$user_uploaded_id = check_user_id($this->user_id);

							if($user_uploaded_id == 0)
							{
								redirect('UserIdVerification/upload_id_html');
							}else{
								redirect('UserSocialMedia/add_link');
							}
						}else{

							Flash::set("Error Please Try Again");
							redirect('UserSocialMedia/add_link');
						}
					}	
				}

			}else{

				$data = [
                	'result' => $this->UserSocialMediaModel->get_user_uploaded_social_media_link($this->user_id),
			         'profile_frame' => 'NO'
           		];

	            $this->view('user_social_media/add_link',$data);

			}

		}

		public function remove_link()
		{

			$this->user_id = Session::get('USERSESSION')['id'];

			if($this->request() === 'POST')
			{

			}else{

				$result = $this->UserSocialMediaModel->remove_link($_GET['type'], $this->user_id);

				if($result)
				{
					Flash::set("Successfully Removed");
					redirect('UserSocialMedia/add_link');
				}else{

					Flash::set("Error Please Try Again");
					redirect('UserSocialMedia/add_link');
				}

			}

		}


		public function verify_link_list()
		{

			$branchid = $this->check_session();


			if($this->request() === 'POST')
			{

			}else{
				if($branchid == "admin")
				{
					$data = [
		                'result' => $this->UserSocialMediaModel->get_user_social_media_link_all()
		            ];
					$this->view('user_social_media/verify_link',$data);
				}else{

					$data = [
		                'result' => $this->UserSocialMediaModel->get_user_social_media_link_all()
		            ];
					
					$this->view('user_social_media/verify_link',$data);
				}

			}

		}


		public function verified_list($status)
		{
			$branch_user = Session::get('BRANCH_MANAGERS'); 
			$this->check_session();

			$data = [
                'result' => $this->UserSocialMediaModel->verified_list($status)
            ];

			$this->view('user_social_media/processed_data',$data);
		}


		public function get_users($status)
		{

			$branchid = $this->check_session();


			if($this->request() === 'POST')
			{

			}else{
				$condition = '';

				if($status=='Done'){
					$condition = '>=';
				}else{
					$condition = '<';
				}

				$data = [
					'status' => $status,
	                'result' => $this->UserSocialMediaModel->get_user_all($condition)
	            ];
				$this->view('user_social_media/users_list',$data);


			}

		}

		public function upload_chat_bot_link()
		{

			$branchid = $this->check_session();


			if($this->request() === 'POST')
			{
				$result = $this->UserSocialMediaModel->upload_chat_bot_link($_POST['userid'], $_POST['chat_bot_link']);

				if($result)
				{
					Flash::set("Successfully Uploaded");
					redirect('UserSocialMedia/get_users/Pending');
				}else{

					Flash::set("Error Please Try Again");
					redirect('UserSocialMedia/get_users/Pending');
				}

			}else{

			}

		}


		public function get_users_chat_bot_link()
		{
			$user = Session::get('USERSESSION');

			$data = [
								'result' => $this->UserSocialMediaModel->get_chat_bot_link($user['id'])
						];


			return $this->view('user_social_media/get_chat_bot_link',$data);
		}

		public function change_status()
		{

			$branchid = $this->check_session();
			$status = $_GET['status'];

			$commment = null;

			if(isset($_GET['comment']))
			{
				$commment = $_GET['comment'];
			}

			if($this->request() === 'POST')
			{
			}else{

				$result = $this->UserSocialMediaModel->change_status($_GET['status'], $_GET['id'], @$_GET['comment']);

				if($result)
				{
					Flash::set("Successfully {$status}");
					redirect('UserSocialMedia/verify_link_list');
				}else{

					Flash::set("Error Please Try Again");
					redirect('UserSocialMedia/verify_link_list');
				}

			}


		}

		public function change_status_admin()
		{

			$branchid = $this->check_session();
			$status = $_GET['status'];

			$commment = null;

			if(isset($_GET['comment']))
			{
				$commment = $_GET['comment'];
			}
			$result = $this->UserSocialMediaModel->change_status($_GET['status'], $_GET['id'], $_GET['comment']);

			if($result)
			{
				Flash::set("Successfully {$status}");
				return request()->return();
			}else{

				Flash::set("Error Please Try Again");
				return request()->return();
			}

		}


		public function deny_link()
		{
			$branchid = $this->check_session();
			if($this->request() === 'POST')
			{
				redirect("/UserSocialMedia/change_status/?status=deny&id={$_POST['id']}&comment={$_POST['comment']}");
			}else{

			}
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
				redirect('user/login');
			}
		}




	}
