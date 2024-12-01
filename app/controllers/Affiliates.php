
	<?php 	

	class Affiliates extends Controller{

		public function __construct()
		{
			parent::__construct();

			$this->referral_model = $this->model('referral_model');
			$this->binary_model = $this->model('binary_model');

			$this->binarypv_model = $this->model('binarypv_model');
			$this->Referrals_dbbiModel = $this->model('Referrals_dbbiModel');

		}
			public function dbbi_refferal_link()
		{

			Authorization::setAccess(['admin' , 'user']);
			$user_id = Session::get('USERSESSION')['id'];
				
			/** OLD **/
				// $url_left = URL.DS.'LDUser/pre_register_left/?refferal_ID='.$user_id;
				// $url_right = URL.DS.'LDUser/pre_register_right/?refferal_ID='.$user_id;
			/** OLD **/

			$url_left  = URL.DS.'Registration/create/?sponsor='.seal($user_id).'&'.'position=left';
			$url_right = URL.DS.'Registration/create/?sponsor='.seal($user_id).'&'.'position=right';
			
			$data = [
				'pre_register_dbbi' => $this->Referrals_dbbiModel->list($user_id),
				'referral' => [
					'url_left'  => $url_left,
					'url_right' => $url_right
				]
			];


                            
			$this->view('referral/dbbi_refferal_link',$data);
		}

		public function index()
		{	

			Authorization::setAccess(['admin' , 'user']);
				
			/*load mdodel*/

			$this->userModel = $this->model('user_model');
			$user_id = Session::get('USERSESSION')['id'];

			$ref_left   = $this->binary_model->outDownline($user_id , 'left');
			$ref_right  = $this->binary_model->outDownline($user_id , 'right');
			$legDetails = $this->binarypv_model->get_bpv($user_id);

			$param  = [ 
				'left'  => 'sponsor='.seal($user_id).'&'.'upline='.seal($ref_left).'&'.'pos=left' , 
				'right' => 'sponsor='.seal($user_id).'&'.'upline='.seal($ref_right).'&'.'pos=right'
			];

			$data = [
				'referral_links' => array(
					'left' => URL.DS.'referrals'.DS.'referral/?'.$param['left'],
					'right' => URL.DS.'referrals'.DS.'referral/?'.$param['right']
				)
			];

			$data['useraccount']  = $this->userModel->get_user($user_id);

			$data['bestposition'] = $legDetails->getLeftCarry() < $legDetails->getRightCarry() ? 'Left': 'Right';

			$this->view('referral/index' , $data);
		}

		public function referral(string $referral)
		{	
			
			$data = [
				'referral' => explode('-', $referral)
			];

			$this->view('referral/refferal_form' , $data);
		}

		public function create_account()
		{

			if($this->request() === 'POST')
			{
				//get sponsor id to get the upline
				if(!in_array($_POST['binary_position'], ['left' , 'right']))
				{
					die("INCORRECT URL INFORMATION");
				}else
				{	
					$position = $_POST['binary_position'];
					$sponsor  = $_POST['sponsor'];

					$upline = $this->binary_model->outDownline( unseal($sponsor), $position);

					$account = [
						'firstname'       => $_POST['firstname'] ,
						'lastname'        => $_POST['lastname'],
						'username'        => $_POST['username'],
						'email'           => $_POST['email'],
						'password'        => $_POST['password'],
						'direct_sponsor'  => unseal($_POST['sponsor']),
						'upline'          => $upline,
						'binary_position' => $position,
						'branchId'        => $_POST['branch']
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


						redirect('referrals/referral/?sponsor='.$sponsor.'&upline='.seal($upline).'&pos='.$position);
					}
				}
				
			}else
			{
				//get sponsor upline and position

				if(isset($_GET['sponsor'] , $_GET['upline'] , $_GET['position']) && 
				  !empty($_GET['sponsor']) && 
				  !empty($_GET['upline']) && 
				  !empty($_GET['position']))
				{
					echo die("INCORRECT URL");
				}
			}
		}
	}