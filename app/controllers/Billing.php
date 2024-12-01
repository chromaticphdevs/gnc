<?php 	

	class Billing extends Controller
	{
		public function index()
		{
			$this->checkout();
		}
		public function checkout()
		{

			if($this->request() === 'POST')
			{
				$this->billingModel = $this->model('billingModel');

				$cartid = Session::get('CARTSESSION')['id'];
				$userid = Session::get('USERSESSION')['id'];

				$file = new File();

				$file->setFile($_FILES['payment_attachment'])
				->setPrefix('IMAGE')
				->setDIR(PUBLIC_ROOT.DS.'assets')
				->upload();


				if(!empty($file->getErrors()))
				{
					Flash::set($file->getErrors() , 'danger');

					redirect('/billing/checkout');
					
					return;
				}else{

					$image  = $file->getFileUploadName();

					$orderid    = $this->billingModel->billOut($_POST , $image, $cartid , $userid);
				}
			}else{
				$this->userModel = $this->model('user_model');
				$this->cartModel    = $this->model('cart_model');

				//get cartItems
				$data = [
					'user'       => $this->userModel->get_user_by_id(Session::get('USERSESSION')['id']),
					'cartItem' => $this->cartModel->get_cart_items(Session::get('CARTSESSION')['id'])
				];
				$this->view('billing/index' , $data);
			}
		}
	}