<?php 	

	class RegistrationSignup extends Controller
	{
		public function __construct()
		{
			$this->RegistrationSignupModel = $this->model('RegistrationSignupModel');	
		}

		public function index()
		{	
			if($this->request() == 'POST'){

				$this->RegistrationSignupModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->RegistrationSignupModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->RegistrationSignupModel->pre_register_geneology($_POST);

			}else
			{

				$data = [
					'branchList' => $this->RegistrationSignupModel->branch_list()
				];
			
		        $this->view('signup/index',$data);
	    	}
		}

		public function check_send_text_code()
		{	
			if($this->request() == 'POST'){


				$this->RegistrationSignupModel->__add_model('binaryModel' , $this->model('binary_model'));
				$this->RegistrationSignupModel->__add_model('binarypv_model' , $this->model('binarypv_model'));
				
				$this->RegistrationSignupModel->check_send_text_code($_POST);

				
			}
		}

	}