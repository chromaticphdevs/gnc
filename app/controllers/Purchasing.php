<?php 	

	class Purchasing extends Controller{

		private $cart_id;

		public function __construct()
		{

			parent::__construct();

			//fill cart_id
			$this->set_cart_details();

			$this->cart_model = $this->model('cart_model');
			$this->purchasing_model = $this->model('purchasing_model');
		}

		public function cart_view()
		{	
			$data = [
				'cart_items' => $this->cart_model->get_cart_items($this->cart_id) ,
				'cart_total' => $this->cart_model->get_cart_items_total($this->cart_id)
			];
			$this->view('market/cart_preview' , $data);
		}
		public function checkout()
		{

			if($this->request() === 'POST')
			{

				// $this->view('market/checkout');

				// set cart items to order
				
				$res = $this->cart_model->cart_item_to_order($this->cart_id);

				if($res === TRUE)
				{
					$err = [
					'r_fullname_err' => '' ,
					'r_mobile_err'   => '' ,
					'r_email_err'    => '' ,
					'address'        => ''
					];

					$data = [

						'for_orders' => $this->cart_model->get_for_order_items($this->cart_id) ,
						'order_total' => $this->cart_model->get_cart_items_total($this->cart_id) ,
						'err' => $err
					];

					$this->view('market/checkout' , $data);

				}else{
					die("SOMETHING WENTWRONG");
				}
				
			}else{
				
				$this->cart_view();
			}
		}
		//submit checkout
		public function submit_checkout()
		{
			if($this->request() === 'POST')
			{	

				//validation
				$err = [
					'r_fullname_err' => '' ,
					'r_mobile_err'   => '' ,
					'r_email_err'    => '' ,
					'address_err'        => ''
				];

				if(empty($_POST['r_fullname'])){
					$err['r_fullname_err'] =  "Reciever name cannot be empty";
				}

				if(empty($_POST['r_mobile'])){
					$err['r_mobile_err'] =  "Reciever name cannot be empty";
				}

				if(empty($_POST['r_email'])){
					$err['r_email_err'] =  "Reciever name cannot be empty";
				}

				if(empty($_POST['address']))
				{
					$err['address_err'] =  "Reciever name cannot be empty";
				}

				if(empty($err['r_fullname_err']) && empty($err['r_mobile_err']) && empty($err['r_email_err']) && empty($err['address_err'])){


					$order_details = [
						'address' => $_POST['address'],
						'user_id' => Session::get('USERSESSION')['id']
					];

					$res = $this->purchasing_model->add_order($order_details , $this->cart_id);


					if($res)
					{
						Flash::set('YOUR ORDER HAS BEEN SENT');

						redirect('orders/view_order/'.$res);
					}else{
						die("SOMETHING WENT WRONG");
					}
				}else{
					$data = [

						'for_orders' => $this->cart_model->get_for_order_items($this->cart_id) ,
						'order_total' => $this->cart_model->get_cart_items_total($this->cart_id) ,
						'err' => $err
					];
					$this->view('market/checkout' , $data);
				}
			}
			else{
				$this->checkout();

			}
		}

		private function set_cart_details()
		{
			$this->cart_id = Session::get('CARTSESSION')['id'];
		}

		private function unset_all_purchase_session()
		{
			//cart session

			unset($_SESSION['CARTSESSION']);
		}
	}