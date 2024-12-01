<?php

	class LDAccountActivation extends Controller
	{

		public function __construct()
		{
			$this->activationCode = $this->model('FNCodeInventoryModel');

			$this->userCodeModel  = $this->model('FNUserCodeModel');

			$this->accountUpgradeModel = $this->model('AccountUpgradeModel');

			$this->userModel = $this->model('User_model');

		}
		public function activate_account()
		{
			// return $this->view('account_activation/dev');

			if($this->request() === 'POST')
			{
				//search activation code
				$activationCode = $_POST['activationCode'];

				$activationDetails = $this->activationCode->get_by_code($activationCode);

				//if no result
				if(empty($activationDetails)) {

					Flash::set("Code {$activationCode} does not exists" , 'danger');

					redirect('LDAccountActivation/activate_account');

					return;
				}
				//check if used;

				if(strtolower($activationDetails->status) == 'used') {

					Flash::set("Code {$activationCode} already used" , 'danger');

					redirect('LDAccountActivation/activate_account');

					return;
				}


				$user   = Session::get('USERSESSION');

				$userid = $user['id'];

				$submitCommission = $this->submit_commissions($userid , $activationDetails, $activationCode);

				/*Account Creation (BINARY SPREADYY)*/

			    if(in_array($activationDetails->level , ['bronze' , 'silver' , 'gold']))
			    {
			        $accountMaker = new AccountMakerObj($userid , $activationDetails->level);
			        $accountMaker->run();
			    }


				if($submitCommission)
				{
					$useActivationcode = $this->activationCode->update_status($activationDetails->id , 'used');

					$this->userCodeModel->update_status($activationDetails->id , 'used');

					if($useActivationcode) {
						Flash::set("Code {$activationCode} successfully registered");

						$this->accountModelInstance()->update_account($userid , $activationDetails);

						redirect('LDAccountActivation/activate_account');
					}
				}else{

					redirect('LDAccountActivation/activate_account');
				}
			}else{
				$data = [
					'userinfo' => $this->userModel->get_user(Session::get('USERSESSION')['id'])
				];

				return $this->view('account_activation/activate_account' , $data);
			}
		}



		private function submit_commissions($purchaser , $activationDetails, $activationCode)
		{
			/*load payin model*/
			$payinModel = new LDPayinModel();
			/*load commissionModel*/
			$this->commissiontrigger_model = $this->model('commissiontrigger_model');

			$origin = $activationDetails->company ?? 'untag';//if no origin set to untag
			$commissions =
				array(
					'unilevelAmount'   => $activationDetails->unilevel_amount,
					'drcAmount'        => $activationDetails->drc_amount ,
					'binaryPoints'     => $activationDetails->binary_point
				);

			$orderid   = 0;
			$distribution = $activationDetails->distribution;

			/*add payinmodel*/
			$payinModel->make_payin($purchaser , $activationDetails->amount , 'code' , $origin);

			/*ddistribute commissions*/
			$distributeCommission =
				$this->commissiontrigger_model->submit_commissions($purchaser , $commissions ,
					$orderid , $distribution , $origin);

			if($distributeCommission)
				return true;
			return false;
		}

		private function accountModelInstance()
		{
			return new AccountActivationModel();
		}
		private function branch_vault_model_instance()
		{
			return new BranchVaultModel();
		}

	}
