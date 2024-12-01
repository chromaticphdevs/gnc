<?php 	

	class LDPayment extends Controller
	{
		private $view = 'lending/';
		
		public function __construct()
		{
			//loan user model
			$this->productLoanModel = $this->model('LDProductLoanModel');	
			$this->UserModel = $this->model('LDUserModel');

			$this->cashloanModel = $this->model('LDCashLoanModel');
		}


		public function make_payment($userid)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer','cashier'] , 'user' , 'FireLoginDBBI');


			if($this->request() === 'POST')
			{
				var_dump($_POST);

			}else{
				$data['loans'] = [
					'cash'    => $this->cashloanModel->get_by_user($userid),
					'product' => $this->productLoanModel->get_by_user($userid)
				];

				$data['userid'] = $userid;

				$data['username'] = $this->UserModel->preview($userid)->fullname;
				
				if($this->request() === 'POST')
				{
					// $this->CashModel->pay($_POST);
				}else
				{
					$this->view($this->view.'payment/make_payment',$data);
				}

			}
		}

		public function make_payment_cashier($userid)
		{
			DBBIAuthorization::setAccess(['super admin','admin','customer','cashier'] , 'user' , 'FireLoginDBBI');

			// $data['balance'] = [
			// 	'cash' => $this->cashloanModel->get_by_user($userid),
			// 	'product' => ''
			// ];
			if($this->request() === 'POST')
			{
				var_dump($_POST);

			}else{
				$data['loans'] = [
					'cash'    => $this->cashloanModel->get_by_user($userid),
					'product' => $this->productLoanModel->get_by_user($userid)
				];

				$data['userid'] = $userid;

				$data['username'] = $this->UserModel->preview($userid)->fullname;
				
				if($this->request() === 'POST')
				{
					// $this->CashModel->pay($_POST);

				}else
				{
					$this->view($this->view.'payment/make_payment_cashier',$data);
				}

			}
		}
		/*ajax*/
		public function do_payment()
		{
			$this->cashPaymentModel = $this->model('LDCashLoanPaymentModel');

			$this->productPaymentModel = $this->model('LDPaymentProductModel');
			
			if($this->request() === 'POST')
			{
				$paymentsInfo = json_decode($_POST['payments']);

				$payerid = $paymentsInfo->payerid;

				$note = $paymentsInfo->note;

				$payments = [
					'cash' => $paymentsInfo->cash ,
					'product' => $paymentsInfo->product
				];

				$image = $_POST['image'];
			

				$res = $this->cashPaymentModel->make_payment($payerid , $payments['cash'] , $note , $image);

				if($res)
				{

					/*productModel*/
					$this->productPaymentModel->__add_model('productModel' , $this->model('Product_model'));
					
					/*socialCommissionModel*/
					$this->productPaymentModel->__add_model('commissionTriggerModel' , $this->model('Commissiontrigger_model'));

					$this->productPaymentModel->make_payment($payerid , $payments['product'] , $note, $image);

					Flash::set("Payment success");

					echo('success');
				}else{
					echo('failed');
				}

				
				

			}
		}
	}