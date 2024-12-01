<?php

	class Account extends Controller
	{

		public function __construct()
		{
			$this->binarypv_model = $this->model('binarypv_model');
			$this->userModel = $this->model('user_model');
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
		    $this->FNCashAdvanceModel = $this->model('FNCashAdvanceModel');
		    $this->UserSocialMediaModel = $this->model('UserSocialMediaModel');
		    $this->TOCModel = $this->model('TOCModel');
		}
		public function list()
		{
			if(!isEqual(whoIs('type'), USER_TYPES['ADMIN'])) {
                Flash::set("unauthorized access");
                return redirect('AccountProfile');
            }
			$req = request()->inputs();

			$itemsPerPage = 10;
			$curPage = $req['page'] ?? 1;
			$offset = ($curPage - 1) * $itemsPerPage;

			Authorization::setAccess(['admin']);
			$users = $this->userModel->getAll([
				'where' => [
					'YEAR(user.created_at)' => '2024'
				],

				'limit' => "{$offset}, {$itemsPerPage}",

				'order' => 'user.id desc'
			]);

			$totalUserCount = $this->userModel->count([
				'where' => [
					'YEAR(created_at)' => '2024'
				]
			]);
			$data = [
				'userList' => $users,

				'pagination' => [
					'itemsPerPage' => $itemsPerPage,
					'curPage' => $curPage,
					'totalUserCount' => $totalUserCount
				]
			];

			return $this->view('account/list' , $data);
		}

		public function activate()
		{
			$userid = Session::get('USERSESSION')['id'];

			$this->user_model    = $this->model('user_model');
			$this->accountModel  = $this->model('accountModel');
			$this->binaryModel   = $this->model('binary_model');
			
			/*LOAD MODELS FOR ACTIVATION*/
			$this->commissiontrigger_model = $this->model('commissiontrigger_model');
			$this->orderModel              = $this->model('order_model');
			//this will return an objects of items comiissions

			$legDetails   = $this->binarypv_model->get_bpv($userid);

			$bestposition = $legDetails->getLeftCarry() < $legDetails->getRightCarry() ? 'Left': 'Right';
			
			$user         = $this->user_model->get_user($userid);


			if($this->request() === 'POST') {

				$downline = $this->binaryModel->outDownline($user->direct_sponsor , $bestposition);

				$data = [
					$userid , 
					$downline,
					$bestposition
				];

				$res = $this->accountModel->activate(...$data);


				if($res) {

					$payinModel = new LDPayinModel();

					$activationOrder = $this->orderModel->get_activation_order($userid);

					if(!empty($activationOrder))
					{
						$order = $this->orderModel->get_order_item($activationOrder->id);
						/*DISTRIBUTE COMMISSIONS*/
						try{
							/*order and order item info*/
							$commissions = array(
								'unilevelAmount'   => $order->unilvl_amount,
								'drcAmount'        => $order->drc_amount , 
								'binaryPoints'     => $order->binary_pb_amount
							);

							$purchaser = $order->user_id;
							$orderid   = $activationOrder->id;
							$distribution = $order->distribution;

							$origin = 'sne';


							$payinModel->make_payin($purchaser , $activationOrder->price , 'order' , $origin);
							
							$distributeCommission = 
								$this->commissiontrigger_model->submit_commissions(
									$purchaser , $commissions , $activationOrder->id , 
								$distribution , $origin);

							if(!$distributeCommission) {
								throw new Exception("Commissions not distributed", 1);
							}
							redirect('geneology/binary');

						}catch(Exception $e) 
						{
							die($e->getMessage());
						}
					}else{
						die('NOT ACTIVATED');
					}
				}else{
					die("DI NAG ACTIVATE");
				}
				
			}
		}


		public function doSearch()
		{
			$req = request()->inputs();
			/**
			 * Quick Fix
			 */
			
			switch($req['searchOption']) {
				case 'email':
					$user = $this->userModel->getSingle([
						'where' => [
							'user.email' => $req['username']
						],
						'order' => 'id asc'
					]);
					break;
				case 'username':
					$user = $this->userModel->getSingle([
						'where' => [
							'user.username' => $req['username']
						],
						'order' => 'id asc'
					]);
					break;

				case 'lastname':
					$user = $this->userModel->getSingle([
						'where' => [
							'user.lastname' => $req['username']
						],
						'order' => 'id asc'
					]);
				break;

				case 'firstname':
					$user = $this->userModel->getSingle([
						'where' => [
							'user.firstname' => $req['username']
						],
						'order' => 'id asc'
					]);
				break;
			}


			if($user) {
				return redirect('/AccountProfile/index?userid='.$user->id);
			} else {
				Flash::set('User not found');
				return request()->return();
			}

			return;

			//username for change first your upline or directsponsor
			$usernameTwo = '';

			if(isset($_GET['username']))
				$username = $_GET['username'];
			if(isset($_GET['usernameTwo']))
				$usernameTwo = $_GET['usernameTwo'];

			if(empty($username)) {
				Flash::set("Invalid search" , 'danger');
				return request()->return();
			}

			//search first user

			$userDetail = $this->userModel->get_user_by_username($username , TRUE, $_GET['searchOption']);
			
			if(count($userDetail) == 1)
			{
				$userDetail = $userDetail[0];

				$data['baseUser']['detail'] = $userDetail;

				$data['baseUser']['upline'] = $this->userModel->get_user($userDetail->upline);

				$data['baseUser']['directSponsor'] = $this->userModel->get_user($userDetail->direct_sponsor);

				$data['baseUser']['loan_data'] = $this->FNProductBorrowerModel->get_user_loans($userDetail->id);

				$data['baseUser']['cash_loan'] = $this->FNCashAdvanceModel->get_user_loan($userDetail->id);
				
				$data['baseUser']['social'] = $this->UserSocialMediaModel->get_user_fb_link($userDetail->id);

				$data['baseUser']['toc_details'] = $this->TOCModel->getByUser($userDetail->id);

				//if sponsor or upline is missing
				if(!$data['baseUser']['upline'] || !$data['baseUser']['directSponsor'])
				{
					$data['previous'] = [
						'upline' => $this->userModel->getOldUpline($userDetail->id),
						'directSponsor' => $this->userModel->getOldSponsor($userDetail->id),
						'loan_data' => $this->FNProductBorrowerModel->get_user_loans($userDetail->id),
						'cash_loan' => $this->FNCashAdvanceModel->get_user_loan($userDetail->id)
					];


				}	

				if(!empty($usernameTwo))
					$data['secondUser'] = $this->userModel->get_user_by_username($usernameTwo);


				return $this->view('account/do_search' , $data);
			}else
			{
				$data = [
					'userDetail' => $userDetail
				];

				$this->view('account/search_list',$data);
			}	
		}
		public function searchUser()
		{
			Authorization::setAccess([USER_TYPES['ADMIN'], USER_TYPES['ENCODER_A']]);
			return $this->view('account/search');
		}


		public function doUpdateHigherUser()
		{
			$this->userModel = $this->model('user_model');
			if($this->request() === 'POST') {

			if(isset($_POST['upline']))
			{
				$this->userModel->updateUpline($_POST);
				

			}else{
				$this->userModel->updateDirectSponsor($_POST);
			}

			}
		}


		public function updateHigherUser()
		{
			if(!isset($_GET['userid'])) {
				Flash::set("Invalid Request" , 'danger');
				return request()->return();
			} 

			$user = $this->userModel->get_user($_GET['userid']);

			$returnToURL = request()->referrer();

			return $this->view('account/update_higher_user' , compact(['user' , 'returnToURL']));
		}

		public function changePassword()
		{
			Authorization::setAccess(['admin']);

			if($this->request() === 'POST')
			{
				$this->userModel = $this->model('user_model');

				$redirectTo = $_POST['redirectTo'];

				$this->userModel->changepassword($_POST['userid'] , $_POST['password'] ,$redirectTo);
			}
		}

		public function create()
		{
			
		}

		public function deactivate_account()
		{
			Authorization::setAccess(['admin']);

			$this->accountModel  = $this->model('accountModel');

			if($this->request() === 'POST')
			{

				$result = $this->accountModel->deactivate_account();

				if(!empty($result)){

					Flash::set("Accounts Are now Deactivated!" , 'danger');
					return request()->return();			
				}
	
			}else{

				$data = [
					'userList' => $this->accountModel->get_users_for_deactivation()
				];

				$this->view('account/deactivate_account',$data);
			}
		}

		public function create_staff()
		{
			Authorization::setAccess(['admin']);

			$this->accountModel  = $this->model('accountModel');

			if($this->request() === 'POST')
			{	

				$result = $this->accountModel->change_staff_status($_POST['userid'],'1');

				if($result)
				{

					Flash::set("User Successfully Appointed as Staff");
					return request()->return();			
				}else
				{
					Flash::set("Error Please Try Again",'danger');
					return request()->return();	
				}
			}else{

				$data = [
					'staffList' => $this->accountModel->get_user_staff()
				];

				$this->view('account/create_staff',$data);
			}
		}

		public function api_fetch_all() {
			$req = request()->inputs();
			$keyword = $req['keyword'] ?? '';

			$groupedA = $this->userModel->convertWhere([
				'GROUP_CONDITION' => [
					'user.username' => [
						'condition' => 'like',
						'value'  => "%$keyword%",
						'concatinator' => 'OR'
					],
					'user.firstname' => [
						'condition' => 'like',
						'value'  => "%$keyword%",
						'concatinator' => 'OR'
					],
					'user.lastname' => [
						'condition' => 'like',
						'value'  => "%$keyword%",
						'concatinator' => 'OR'
					]
				]
			]);

			$users = $this->userModel->getAll([
				'where' => "$groupedA AND YEAR(user.created_at) = '2024'",
				'limit' => 10,
				'order' => 'id desc'
			]);

			if($users) {
				foreach($users as $key => $row) {
					$row->is_verified_text = userVerfiedText($row);
				}
			}
			echo api_response([
				'users' => $users
			]);
			return;
		}

		public function remove_staff($userid)
		{
			Authorization::setAccess(['admin']);

			$this->accountModel  = $this->model('accountModel');
			$result = $this->accountModel->change_staff_status($userid,'0');

			if($result)
			{
				Flash::set("User Successfully Removed as Staff");
				return request()->return();			
			}else
			{
				Flash::set("Error Please Try Again",'danger');
				return request()->return();	
			}
			redirect("account/create_staff");
		}
	}