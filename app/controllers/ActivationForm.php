<?php 	

	class ActivationForm extends Controller
	{	

		private $view = 'lending/';

		public function __construct()
		{
			$this->ActivationFormModel = $this->model('ActivationFormModel');	
			$this->UserModel = $this->model('LDUserModel');	
		}

		public function index()
		{

	
			if($this->request() == 'POST')
			{
				$this->ActivationFormModel->pre_register_login($_POST);

			}else
			{

				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()

				];

		       $this->view('lending/activation/form2',$data);
	    	}
	        				
		}

		public function pre_register()
		{

			if($this->request() == 'POST')
			{		
				$this->ActivationFormModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->ActivationFormModel->__add_model('binarypv_model' , $this->model('binarypv_model'));

			
				$this->ActivationFormModel->pre_register($_POST);

				

			}

		}

		public function check_send_text_code()
		{

	
			if($this->request() == 'POST')
			{	
				$this->ActivationFormModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->ActivationFormModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				$this->ActivationFormModel->check_send_text_code($_POST);

			}else
			{

	    	}
	        				
		}
		public function check_send_email_code()
		{

	
			if($this->request() == 'POST')
			{	
				$this->ActivationFormModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->ActivationFormModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				$this->ActivationFormModel->check_send_email_code($_POST);

			}else
			{

	    	}
	        				
		}

		public function test()
		{

	
			if($this->request() == 'POST')
			{	
				$this->ActivationFormModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->ActivationFormModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				$this->ActivationFormModel->check_send_text_code($_POST);

			}else
			{

				$data = [
					'userList' => $this->UserModel->list(),
					'branchList' => $this->UserModel->branch_list()

				];

		       $this->view('lending/activation/test_form',$data);
	    	}
	        				
		}





	}


?>