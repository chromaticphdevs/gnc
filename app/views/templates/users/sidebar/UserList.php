<?php 	

	class UserList extends Controller
	{

		public function __construct()
		{
			$this->UserListModel = $this->model('UserListModel');
		}



		public function get_activation_today()
		{	
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{	
				
			}else{


				$data = [
				'title' => "Activation Today",	
                'result' => $this->UserListModel->get_activation_today()
           		];

	            $this->view('user/list_info',$data);

			}
		
		}

		
		public function get_registration_today()
		{	
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{	
				
			}else{

				
				$data = [
				'title' => "Registration Today",	
                'result' => $this->UserListModel->get_registration_today()
           		];

	            $this->view('user/list_info',$data);

			}
		
		}

		public function get_registration_a_week()
		{	
	
			if($this->request() === 'POST')
			{	
				$data = [
				'title' => "Newly Registered User",	
				'number_days' => $_POST['days'],
                'result' => $this->UserListModel->get_registration_a_week($_POST['days'])
           		];

	            $this->view('user/customer_service_task',$data);
			}else{

				
				$data = [
				'title' => "Newly Registered User",
				'number_days' => '7',	
                'result' => $this->UserListModel->get_registration_a_week('7')
           		];

	            $this->view('user/customer_service_task',$data);

			}
		
		}

		public function get_login_today()
		{	
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{	
				
			}else{
	
				$data = [
				'title' => "Login Today",
                'result' => $this->UserListModel->get_login_today()
           		];

	            $this->view('user/list_info',$data);

			}
		
		}


		public function get_product_release_today()
		{	
			Authorization::setAccess(['admin']);
			if($this->request() === 'POST')
			{	
				
			}else{
	
				$data = [
				'title' => "Product Release Today",
                'advance_payment' => $this->UserListModel->get_product_release_today("advance-payment"),
                'product_loan' => $this->UserListModel->get_product_release_today("product-loan")
           		];

	            $this->view('finance/product_advance/released_today',$data);

			}
		
		}
		


	}