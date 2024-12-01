<?php


	class LDActivationTest extends Controller
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
					
					$update_account = $this->UserModel->update_account($user->id , $position , $upline);

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
					$this->view($this->view.'forms/activation');
			}


		}

		public function form()
		{

			$this->check=2;
			$data = [
				'userList' => $this->UserModel->list(),
				'banchList' => $this->UserModel->branch_list()
			];
			

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

		private function account_activation($userid , $activation_code)
		{

			/*to load models*/
			$this->user_model    = $this->model('user_model');	
			/*get user information*/
			$user = $this->user_model->get_user($userid);
			/*get purchase information*/
			$activationDetails = $this->ActivationModel->get_activation($activation_code);
			/*get directsponsor best downline position*/


			$data = [
				$userid , 
				$activationDetails->max_pair ,
				$activationDetails->activation_level
			];

			/*update account to what ever it is*/
			$updateAccount = $this->ActivationModel->update_account(...$data);

			if($updateAccount) {

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

					$orderid      = 0;

					$distribution = $activationDetails->com_distribution;

					$distributeCommission = 
						$this->commissiontrigger_model->submit_commissions(
							$userid , $commissions , $orderid , 
						$distribution, $activationDetails->company);

					if(!$distributeCommission) {
						throw new Exception("Commissions not distributed", 1);
					}else{
						if($this->check==1){


						$this->ActivationModel->update_status($activation_code);
						Flash::set("Succesfully registered and activated");
						redirect("/LDUser/pre_register_login");

						}else if($this->check==2){

						$this->ActivationModel->update_status($activation_code);
						Flash::set("Succesfully registered and activated");
						redirect("/LDActivation/form");

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