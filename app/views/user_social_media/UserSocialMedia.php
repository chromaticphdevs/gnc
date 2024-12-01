<?php

	class UserSocialMedia extends Controller
	{

		public function __construct()
		{
			$this->UserSocialMediaModel = $this->model('UserSocialMediaModel');
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
					$check_link = $this->UserSocialMediaModel->check_duplication_link($url);
	
					if($check_link){

						Flash::set("Link is already used Try other one");
						redirect('UserSocialMedia/add_link');

					}else{

						$result = $this->UserSocialMediaModel->add_link($_POST, $this->user_id);
						if($result)
						{
							Flash::set("Successfully Added");
							//redirect('UserSocialMedia/add_link'); we change it for step by step verification
							//redirect('UserIdVerification/upload_id');

						    $data= [
			                	'result' => $this->UserSocialMediaModel->get_user_uploaded_social_media_link($this->user_id),
			                	'profile_frame' => 'YES'
			           		];

				            $this->view('user_social_media/add_link',$data);
							die(var_dump($data))
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
					/*$data = [
		                'result' => $this->UserSocialMediaModel->get_user_social_media_link_by_branch($branchid)
		            ];
					$this->view('user_social_media/verify_link',$data);*/

					$data = [
		                'result' => $this->UserSocialMediaModel->get_user_social_media_link_all()
		            ];
					$this->view('user_social_media/verify_link',$data);
				}

			}

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

				$result = $this->UserSocialMediaModel->change_status($_GET['status'], $_GET['id'], $_GET['comment']);

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
				Authorization::setAccess(['admin']);

				return 'admin';

			}else{
				redirect('user/login');
			}
		}




	}
