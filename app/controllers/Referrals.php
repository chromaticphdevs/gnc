<?php 	

	class Referrals extends Controller{

		public function __construct()
		{
			parent::__construct();

			$this->referral_model = $this->model('referral_model');
			$this->branchModel = $this->model('LDBranchModel');
		}



		public function get_list()
		{

			$user = Session::get('USERSESSION');

			$data = [
				'activatedList'       => $this->referral_model->get_activated_list($user['id']) ,
				'forActivationList'   => $this->referral_model->get_unactivated_list($user['id']),
				'preActivatedList'    => $this->referral_model->get_preactivated_list($user['id'])
			];


			$this->view('referral/list' , $data);
		}

		public function get_activated_list()
		{

		}

		public function index()
		{	

			$user_id = Session::get('USERSESSION')['id'];
			$data = [
				'referral_links' => array(
					'left' => URL.DS.'referrals'.DS.'referral'.DS.$user_id.'-'.'left',
					'right' => URL.DS.'referrals'.DS.'referral'.DS.$user_id.'-'.'right'
				)
			];

			$this->view('referral/index' , $data);
		}

		public function referral()
		{	
			//check if upline and sponsor is set

			if(isset($_GET['sponsor'] , $_GET['upline'] , $_GET['pos']) && 
				!empty($_GET['sponsor']) && 
				!empty($_GET['upline'])&&
				!empty($_GET['pos']))
			{
				//check if will return integer
				$sponsor  = unseal($_GET['sponsor']);
				$upline   = unseal($_GET['upline']);
				$position = $_GET['pos'];

				if($position == 'left' || $position == 'right')
				{
					//check if sponsor and upline is numeric
					if(!is_numeric($sponsor) && !is_numeric($upline))
					{
						err_404();
					}

					$data = [
						'referral' => [
							'position' => $position ,
							'sponsor'  => seal($sponsor) ,
							'upline'   => seal($upline)
						],

						'branchList' => $this->branchModel->get_list()
					];

					$this->view('referral/refferal_form' , $data);
				}else{
					echo die("Incorrect Url");
				}

				
			}else{
				err_404();
			}
			
		}

		public function create_account()
		{

			if($this->request() === 'POST')
			{
				
				$account = [
					'firstname'       => $_POST['firstname'] ,
					'lastname'        => $_POST['lastname'],
					'username'        => $_POST['username'],
					'email'           => $_POST['email'],
					'password'        => password_hash($_POST['password'], PASSWORD_DEFAULT),
					'direct_sponsor'  => $_POST['sponsor'],
					'upline'          => $_POST['sponsor'],
					'binary_position' => $_POST['binary_position']
				];

				$res = $this->referral_model->create_account($account);

				if(empty($res['errors']))
				{
					Flash::set('Account Created');
					redirect('users/login');
				}
				else{

					$message = implode(',', $res['errors']);

					Flash::set($message , 'warning');

					$referral = $account['upline'].'-'.$account['binary_position'];

					redirect('referrals/referral/'.$referral);
				}
			}
		}
	}