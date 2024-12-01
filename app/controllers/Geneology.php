<?php
	class Geneology extends Controller
	{
		private $_userId;

		public function __construct()
		{
			Authorization::setAccess(['admin' , 'user']);

			$this->_userId = Session::get('USERSESSION')['id'];
			$this->user_model = $this->model('user_model');
			$this->userAccountModel  = $this->model('userAccountModel');
			/*
			*Used on advance geneology Model
			*/
			$this->userGeneology = $this->model('UserGeneologyModel');
		}

		public function seacrh_user()
		{	
			if($this->request() === 'POST')
			{
				$result = $this->user_model->get_user_by_username($_POST['username'],false,'username');

				redirect("geneology/binary/{$result[0]->id}");
			}

		}

		public function unactivated_referral()
		{
			if(isset($_GET['userid'])) {

				$uplineid = $_GET['uplineid'];


				$this->view('geneology/referral_list');

			}else{
				die('USERID NOT SET');
			}
		}
		public function add_user()
		{
			$this->referralModel = $this->model('referral_model');

			$this->geneologyModel = $this->model('Geneology_model');

			$this->geneologyModel->__add_model('userModel' , $this->model('user_model'));

			$this->orderModel  = $this->model('order_model');

			if($this->request() === 'POST')
			{
				$uplineid = $_POST['upline'];
				$userid   = $_POST['userid'];
				$position = $_POST['position'];

				/*get user*/

				$user = $this->user_model->get_user($userid);

				if($user->activated_by == 'code')
				{
					$activationModel = $this->model('LDActivationModel');
					$this->commissiontrigger_model = $this->model('commissiontrigger_model');
					$activationDetail   = $activationModel->get_user_activation($userid);

					$data = [
						$uplineid , $userid , $position
					];

					$res = $this->geneologyModel->add_user(...$data);

					try{
						/*order and order item info*/
						$commissions = array(
							'unilevelAmount'   => $activationDetail->unilvl_amount,
							'drcAmount'        => $activationDetail->drc_amount ,
							'binaryPoints'     => $activationDetail->binary_pb_amount
						);

						$purchaser = $activationDetail->user_id;
						$orderid   = $activationDetail->id;
						$distribution = $activationDetail->com_distribution;

						$origin = 'sne';

						$distributeCommission =
							$this->commissiontrigger_model->submit_commissions(
								$purchaser , $commissions , $activationDetail->id ,
							$distribution , $origin);

						if(!$distributeCommission) {
							throw new Exception("Commissions not distributed", 1);
						}

						redirect('geneology/binary');

					}catch(Exception $e)
					{
						die($e->getMessage());
					}
				}else
				{
					$activationOrder = $this->orderModel->get_activation_order($userid);

					if(!empty($activationOrder))
					{
						$this->commissiontrigger_model = $this->model('commissiontrigger_model');

						$data = [
							$uplineid , $userid , $position
						];

						$res = $this->geneologyModel->add_user(...$data);

						if($res)
						{
							$order = $this->orderModel->get_order_item($activationOrder->id);

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
							die("Activation did not push through");
						}
					}else{

						$data = [
							$uplineid , $userid , $position
						];
						$res = $this->geneologyModel->add_user(...$data);

						redirect('geneology/binary');
					}
				}
			}else{

				$userid = Session::get('USERSESSION')['id'];

				if(isset($_GET['uplineid'] , $_GET['position'])) {

					$upline = $_GET['uplineid'];
					$position = $_GET['position'];

					$data = [
						'upline'    => $upline ,
						'position'  => $position
					];


					$data['referral'] = [
						'unactivatedList' => $this->referralModel->get_preactivated_list($userid)
					];

					$this->view('geneology/add_user' , $data);
				}
			}
		}

		public function downlinesOuter($root = null , $position)
		{
			if($root == null)
			{
				$root = Session::get('USERSESSION')['id'];

				$res = $this->binary_model->outDownline($root , 'left');
			}

			else{
				$res = $this->binary_model->outDownline($root , $position);
			}

			return $res;


		}

		public function update()
		{
			$this->load_model('geneology_model' ,'geneology_model');

			$res = $this->geneology_model->update($_GET['userid'] , $_GET['newupline']);

			if($res)
			{
				redirect('geneology/binary');
			}else
			{
				die('SOMETHING WENT WRONG');
			}
		}
		public function binary($root_id = null)
		{
			$this->load_model('binary_model' , 'binary_model');
			$this->topUpModel = model('TopupModel');


			$user = Session::get('USERSESSION');

			$user = $this->user_model->get_user($user['id']);
			$personalPoint = $this->topUpModel->getBalance($user->id);

			$root    = $this->user_model->get_user_by_id($root_id ?? $this->_userId);

			$root_roots = $this->binary_model->getBinary($root->id);



			$lvl2 = [
				'2.1' => $root_roots['left'],
				'2.2' => $root_roots['right']
			];

			$pair1  = $this->binary_model->getBinary($lvl2['2.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl2['2.2']->id);

			$lvl3 = [
				'3.1' => $pair1['left'],
				'3.2' => $pair1['right'],
				'3.3' => $pair2['left'],
				'3.4' => $pair2['right']
			];
			$pair1  = $this->binary_model->getBinary($lvl3['3.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl3['3.2']->id);
			$pair3  = $this->binary_model->getBinary($lvl3['3.3']->id);
			$pair4  = $this->binary_model->getBinary($lvl3['3.4']->id);

			$lvl4 = [
				'4.1' => $pair1['left'],
				'4.2' => $pair1['right'],
				'4.3' => $pair2['left'],
				'4.4' => $pair2['right'],
				'4.5' => $pair3['left'],
				'4.6' => $pair3['right'],
				'4.7' => $pair4['left'],
				'4.8' => $pair4['right']
			];

			$pair1  = $this->binary_model->getBinary($lvl4['4.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl4['4.2']->id);
			$pair3  = $this->binary_model->getBinary($lvl4['4.3']->id);
			$pair4  = $this->binary_model->getBinary($lvl4['4.4']->id);
			$pair5  = $this->binary_model->getBinary($lvl4['4.5']->id);
			$pair6  = $this->binary_model->getBinary($lvl4['4.6']->id);
			$pair7  = $this->binary_model->getBinary($lvl4['4.7']->id);
			$pair8  = $this->binary_model->getBinary($lvl4['4.8']->id);

			$lvl5 = [
				'5.1'  => $pair1['left'],
				'5.2'  => $pair1['right'],
				'5.3'  => $pair2['left'],
				'5.4'  => $pair2['right'],
				'5.5'  => $pair3['left'],
				'5.6'  => $pair3['right'],
				'5.7'  => $pair4['left'],
				'5.8'  => $pair4['right'],
				'5.9'  => $pair5['left'],
				'5.10' => $pair5['right'],
				'5.11' => $pair6['left'],
				'5.12' => $pair6['right'],
				'5.13' => $pair7['left'],
				'5.14' => $pair7['right'],
				'5.15' => $pair8['left'],
				'5.16' => $pair8['right']
			];

			$pair1  = $this->binary_model->getBinary($lvl5['5.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl5['5.2']->id);
			$pair3  = $this->binary_model->getBinary($lvl5['5.3']->id);
			$pair4  = $this->binary_model->getBinary($lvl5['5.4']->id);
			$pair5  = $this->binary_model->getBinary($lvl5['5.5']->id);
			$pair6  = $this->binary_model->getBinary($lvl5['5.6']->id);
			$pair7  = $this->binary_model->getBinary($lvl5['5.7']->id);
			$pair8  = $this->binary_model->getBinary($lvl5['5.8']->id);
			$pair9  = $this->binary_model->getBinary($lvl5['5.9']->id);
			$pair10  = $this->binary_model->getBinary($lvl5['5.10']->id);
			$pair11  = $this->binary_model->getBinary($lvl5['5.11']->id);
			$pair12  = $this->binary_model->getBinary($lvl5['5.12']->id);
			$pair13  = $this->binary_model->getBinary($lvl5['5.13']->id);
			$pair14  = $this->binary_model->getBinary($lvl5['5.14']->id);
			$pair15  = $this->binary_model->getBinary($lvl5['5.15']->id);
			$pair16  = $this->binary_model->getBinary($lvl5['5.16']->id);

			$lvl6 = [
				'6.1'  => $pair1['left'],
				'6.2'  => $pair1['right'],
				'6.3'  => $pair2['left'],
				'6.4'  => $pair2['right'],
				'6.5'  => $pair3['left'],
				'6.6'  => $pair3['right'],
				'6.7'  => $pair4['left'],
				'6.8'  => $pair4['right'],
				'6.9'  => $pair5['left'],
				'6.10' => $pair5['right'],
				'6.11' => $pair6['left'],
				'6.12' => $pair6['right'],
				'6.13' => $pair7['left'],
				'6.14' => $pair7['right'],
				'6.15' => $pair8['left'],
				'6.16' => $pair8['right'],
				'6.17'  => $pair9['left'],
				'6.18'  => $pair9['right'],
				'6.19'  => $pair10['left'],
				'6.20'  => $pair10['right'],
				'6.21'  => $pair11['left'],
				'6.22'  => $pair11['right'],
				'6.23'  => $pair12['left'],
				'6.24'  => $pair12['right'],
				'6.25'  => $pair13['left'],
				'6.26' => $pair13['right'],
				'6.27' => $pair14['left'],
				'6.28' => $pair14['right'],
				'6.29' => $pair15['left'],
				'6.30' => $pair15['right'],
				'6.31' => $pair16['left'],
				'6.32' => $pair16['right']
			];

			$result = array_merge($lvl2 , $lvl3);

			$result = array_merge($result , $lvl4);

			$result = array_merge($result , $lvl5);
			$result = array_merge($result , $lvl6);

			$userid = Session::get('USERSESSION')['id'];

			$contentView = $_GET['view'] ?? 'chart';

			if(isEqual($user->status , ['pre-activated'])) {
				if($personalPoint < 60) {
					$contentView = 'list';
				}
			}
				
			$data = [
				'root' => $root,
				'userid' => $userid,
				'userInfo' => $user,
				'root'     => $root,
				'geneology' => $result ,
				'tree'  => $this->binary_model->getDownlines($root->id),
				'left'  => $this->downlinesOuter($root->id,'left'),
				'right' => $this->downlinesOuter($root->id,'right'),
				'contentView'  => $contentView
			];
			
			if(isset($_GET['level'])){
				$data['level'] = TRUE;
			}

			return $this->view('geneology/binary' , $data);
		}

		public function unilevel($rootid = null)
		{
			//*get users unilevel*//
			$user = Session::get('USERSESSION');
			$userid = $user['id'];
			$geneologyModel = $this->model('geneology_model');


			$user = $this->user_model->get_user($userid);

			$tree = $geneologyModel->getUnilevelTree($user->direct_sponsor);
			if($rootid != null){
				$userid = $rootid;
			}

			$data = [
				'user' => $user,
				'unilevelList' => $geneologyModel->getUnilevel($userid)
			];

			return $this->view('geneology/unilevel' , $data);
		}

		final private function get_gen($root_id)
		{
			$this->load_model('binary_model' , 'binary_model');

			$root    = $this->user_model->get_user_by_id($root_id ?? $this->_userId);

			$root_roots = $this->binary_model->getBinary($root->id);

			$lvl2 = [
				'2.1' => $root_roots['left'],
				'2.2' => $root_roots['right']
			];
			$pair1  = $this->binary_model->getBinary($lvl2['2.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl2['2.2']->id);

			$lvl3 = [
				'3.1' => $pair1['left'],
				'3.2' => $pair1['right'],
				'3.3' => $pair2['left'],
				'3.4' => $pair2['right']
			];
			$pair1  = $this->binary_model->getBinary($lvl3['3.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl3['3.2']->id);
			$pair3  = $this->binary_model->getBinary($lvl3['3.3']->id);
			$pair4  = $this->binary_model->getBinary($lvl3['3.4']->id);

			$lvl4 = [
				'4.1' => $pair1['left'],
				'4.2' => $pair1['right'],
				'4.3' => $pair2['left'],
				'4.4' => $pair2['right'],
				'4.5' => $pair3['left'],
				'4.6' => $pair3['right'],
				'4.7' => $pair4['left'],
				'4.8' => $pair4['right']
			];

			$pair1  = $this->binary_model->getBinary($lvl4['4.1']->id);
			$pair2  = $this->binary_model->getBinary($lvl4['4.2']->id);
			$pair3  = $this->binary_model->getBinary($lvl4['4.3']->id);
			$pair4  = $this->binary_model->getBinary($lvl4['4.4']->id);
			$pair5  = $this->binary_model->getBinary($lvl4['4.5']->id);
			$pair6  = $this->binary_model->getBinary($lvl4['4.6']->id);
			$pair7  = $this->binary_model->getBinary($lvl4['4.7']->id);
			$pair8  = $this->binary_model->getBinary($lvl4['4.8']->id);

			$lvl5 = [
				'5.1'  => $pair1['left'],
				'5.2'  => $pair1['right'],
				'5.3'  => $pair2['left'],
				'5.4'  => $pair2['right'],
				'5.5'  => $pair3['left'],
				'5.6'  => $pair3['right'],
				'5.7'  => $pair4['left'],
				'5.8'  => $pair4['right'],
				'5.9'  => $pair5['left'],
				'5.10' => $pair5['right'],
				'5.11' => $pair6['left'],
				'5.12' => $pair6['right'],
				'5.13' => $pair7['left'],
				'5.14' => $pair7['right'],
				'5.15' => $pair8['left'],
				'5.16' => $pair8['right'],
			];

			$result = array_merge($lvl2 , $lvl3);

			$result = array_merge($result , $lvl4);

			$result = array_merge($result , $lvl5);

			return $result;
		}


		public function create_account()
		{


			$user = Session::get('USERSESSION');

			$data = [
				'user' => $this->user_model->get_user($user['id'])
			];


			if($this->request() === 'POST')
			{

				$userid   = $data['user']->id;
				$username = $_POST['username'];
				$password = $_POST['password'];
				$uplineid = $_POST['uplineid'];
				$position = $_POST['position'];
				$res = $this->userAccountModel->
								createAccount_to_binary($username , $password , $userid, $uplineid, $position);


				redirect('geneology/binary');

			}else
			{

				$this->view('geneology/create_account');
			}

		}

		/*
		*New Binary Geneology
		*/

		public function binaryAdvanced()
		{
			$level = 5;
			$base  = Session::get('USERSESSION')['id'];

			if(isset($_GET['level']))
				$level = $_GET['level'];
			if(isset($_GET['base']))
				$base  = $_GET['base'];


			$levelTwo = $this->userGeneology->getBranch([$base]);
			$levelThree = $this->extractUplinesGetBranch($levelTwo);
			$levelFour = $this->extractUplinesGetBranch($levelThree);
			$levelFive = $this->extractUplinesGetBranch($levelFour);
			$levelSix = $this->extractUplinesGetBranch($levelFive);

			$data = [
				'base' => $this->userGeneology->userInfo($base),
				'levelTwo' => $levelTwo ,
				'levelThree' => $levelThree ,
				'levelFour' => $levelFour,
				'levelFive' => $levelFive,
			];


			dump($data);
			// $result = UI_binary_branch($geneology[0][0][0] , null , null , $this->userGeneology->userInfo($base));

			return $this->view('geneology/new/binary' , $data);
		}

		private function extractUplinesGetBranch($uplines)
		{
			$results = $this->userGeneology->extractDownlines($uplines);
			return $this->userGeneology->getBranch($results);
		}
		private function getLevelSix($uplines)
		{
			return $this->userGeneology->extractDownlines($uplines);
		}
	}
