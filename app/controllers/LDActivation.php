<?php


	class LDActivation extends Controller
	{

		private $view = 'lending/';
		private $check =0;

		public function index()
		{

			echo '<h1> Building a better website , this feature is on maintenance </h1>';

			die();
		}
		public function __construct()
		{

			$this->ProductModel = $this->model('LDProductModel');
			$this->ActivationModel = $this->model('LDActivationModel');
			$this->ActivationModel->__add_model('binaryModel' , $this->model('binary_model'));
			$this->binaryModel = $this->model('binary_model');
			$this->UserModel = $this->model('LDUserModel');

			$this->check =0	;

		}

		public function history_activation_code()
		{
			DBBIAuthorization::setAccess(['super admin'] , 'user' , 'FireLoginDBBI');

			$user_session = Session::get('user');
			$data = [
				'activation_code_history' =>  $this->ActivationModel->activation_code_history()
			];


			if($this->request() === 'POST')
			{

			}else
			{
				$this->view($this->view.'activation/history',$data);
			}


		}


		public function activate_code_pre_register()
		{
			if($this->request() === 'POST')
			{
				$this->check=1;

				$user = Session::get('USER_INFO');

				//get natin dito yung direct_sposnor
				//get din position na gusto nya

				//kunin yung strongest branch ng direct_sponsor
				$direct_sponsor = $user->direct_sponsor;
				/*this will be your position*/
				$position = $_POST['position'];

				/*this will be your upline*/
				$upline = $this->binaryModel->outDownline( $direct_sponsor, $position);
				/*position*/

				/*check activation code*/
				$activation = $this->ActivationModel->get_activation($_POST['activation_code']);
				/*check mo kung meron laman activation*/
				if($activation)
				{
					//update account
					$update_account = $this->UserModel->update_account($user->id , $position , $upline , 'code');

					if($update_account)
					{
						$this->account_activation($user->id,$_POST['activation_code']);
					}
				}else{
					Flash::set("Invalid Activation Code");
						redirect("/LDActivation/activate_code_pre_register");
				}
			}else
			{
					//update status if expired
					$this->ActivationModel->update_expiration_status();

					$this->view($this->view.'forms/activation');
			}


		}

		public function form_activation()
		{

			$this->check=2;
			$data = [
				'userList' => $this->UserModel->list(),
				'banchList' => $this->UserModel->branch_list()
			];

			//update status if expired
			$this->ActivationModel->update_expiration_status();

			if($this->request() === 'POST')
			{

				if($this->ActivationModel->username_verify($_POST)){

					/*newly createed id socialnetwork id*/

					list ($activation_code , $user_socialnetwork_id) = $this->ActivationModel->register($_POST);

					if($user_socialnetwork_id) {

						$res = $this->account_activation($user_socialnetwork_id,$activation_code);

						die(var_dump($res));

					}
				}

			}else
			{
				$this->view($this->view.'activation/form',$data);
			}
		}


		public function live_search()
		{
			if($this->request() === 'POST')
			{

				$this->UserModel->live_list($_POST);
			}

		}

		public function purchase_code_branch()
		{
			if($this->request() === 'POST')
			{

				$user   = Session::get('user');
				$userId = $user['id'];
				$branchId=$user['branch_id'];
				$activation_lvl = $_POST['data'];
				$this->ActivationModel->purchase_code_branch($branchId, $activation_lvl , $userId);
			}

		}

		public function verify_code()
		{

			if($this->request() === 'POST')
			{
				$this->ActivationModel->code_verify($_POST);
			}else
			{
				//$this->view($this->view.'activation/form',$data);
			}
		}

		private function account_activation($purchaser , $activation_code)
		{

			/*to load models*/
			$this->user_model    = $this->model('user_model');
			/*get user information*/
			$user = $this->user_model->get_user($purchaser);
			/*get purchase information*/
			$activationDetails = $this->ActivationModel->get_activation($activation_code);
			/*get directsponsor best downline position*/


			$data = [
				$purchaser ,
				$activationDetails->max_pair ,
				$activationDetails->activation_level
			];

			/*update account to what ever it is*/
			$updateAccount = $this->ActivationModel->update_account(...$data);

			if($updateAccount) {
				/*load payin model*/
				$payinModel = new LDPayinModel();
				$AccountActivationLoggerModel = new LDAccountActivationLoggerModel();

				/*load commission model*/
				$this->commissiontrigger_model = $this->model('Commissiontrigger_model');

				/*pasok ng commissions*/
				try{
					/*order and order item info*/
					$commissions = array(
						'unilevelAmount'   => $activationDetails->unilvl_amount,
						'drcAmount'        => $activationDetails->drc_amount ,
						'binaryPoints'     => $activationDetails->binary_pb_amount
					);

					$orderid = 0;


					$origin = $activationDetails->company ?? 'untag';//if no origin set to untag

					$distribution = $activationDetails->com_distribution;
					/*add payinmodel*/
					$payinModel->make_payin($purchaser , $activationDetails->price , 'code' , $origin);

					/*add record to account activations records */
					$AccountActivationLoggerModel->make_account_activation_logger($purchaser , $activation_code , 'code' , $origin);


					$distributeCommission =
						$this->commissiontrigger_model->submit_commissions(
							$purchaser , $commissions , $orderid ,
						$distribution, $origin);

					if(!$distributeCommission) {
						throw new Exception("Commissions not distributed", 1);
					}else{

						$this->ActivationModel->update_status($purchaser, $activation_code);

						if($this->check==1){

						Flash::set("Succesfully registered and activated");
						redirect("/LDUser/pre_register_login");

						}else if($this->check==2){


						Flash::set("Succesfully registered and activated");
						redirect("/LDActivation/form_activation");

						}
					}

				}catch(Exception $e)
				{
					die($e->getMessage());
				}
			}
		}

	}
?>
