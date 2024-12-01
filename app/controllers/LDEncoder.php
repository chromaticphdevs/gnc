<?php 	

	class LDEncoder extends Controller
	{	

		public function __construct()
		{
			$this->encodeModel = $this->model('LDEncoderModel');
			$this->orderModel = $this->model('Order_model');
			$this->userModel = $this->model('user_model');
		}

		public function register_account()
		{
			if($this->request() === 'POST') {

				/*This function will return orderid*/
				$orderid = $this->encodeModel->do_encode($_POST);

				if($orderid) {
					$res = $this->user_activation($orderid);

					Flash::set("Account has been activated check it social network accounts/DBBIlist");

					redirect('LDEncoder/register_account');

				}else{
					echo "may error";
				}
			}else{

				$this->LDUserModel = $this->model('LDUserModel');
				$data = [
					'userList' => $this->userModel->get_activated_users(),
					'createUsers' => $this->LDUserModel->get_recent()
				];

				$this->view('lending/encoder/encode' ,$data);
			}
		}


		private function user_activation($orderid)
		{

			$this->activationModel = $this->model('UserActivationModel');
			$this->purchaseModel   = $this->model('UserPurchaseModel');
			$this->userMaxpairModel = $this->model('userMaxpairModel');
			//this will return an objects of items comiissions

			$order = $this->orderModel->getOrderDetails($orderid);

			$this->activationModel->setUserId($order->user_id);
			/*pass purchase model*/
			$this->activationModel->setPurchaseModel($this->purchaseModel);
			//try to activate account
			$res = $this->activationModel->activateUser();


			if($res) {
				return true;
			}else{
				die("WHAT THE FUCK HAPPENED");
			}
		}	
	}


