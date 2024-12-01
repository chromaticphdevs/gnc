<?php


	class Activation extends Controller
	{

		public function __construct()
		{	
			$this->ProductModel = $this->model('LDProductModel');	
			$this->ActivationModel = $this->model('LDActivationModel');
			$this->ActivationModel->__add_model('binaryModel' , $this->model('binary_model'));
			$this->UserModel = $this->model('LDUserModel');
			$this->ActivationCodeModel = $this->model('ActivationCodeModel');		
		}


		public function form()
		{

			$data = [
				'userList' => $this->UserModel->list(),
				'banchList' => $this->UserModel->branch_list()
			];


			if($this->request() === 'POST')
			{

				if($this->ActivationModel->username_verify($_POST))
				{

					/*newly createed id socialnetwork id*/

					list ($activation_code , $user_socialnetwork_id) = $this->ActivationModel->register($_POST);

					if($user_socialnetwork_id) 
					{

						$res = $this->account_activation($user_socialnetwork_id,$activation_code);

						die(var_dump($res));

					}
				}

			}else
			{
					$this->view('activation/form' , $data);
			}
		}

		public function create_code()
		{	

			$this->branchModel = new FNBranchModel();

			$this->codeInventoryModel = $this->model('FNCodeInventoryModel');

			$user_session = Session::get('USERSESSION');

			$data = [
				'codes' => $this->codeInventoryModel->get_list(),
				'branches' => $this->branchModel->get_list()
			];

			if(isset($_GET['branchid']) && is_numeric($_GET['branchid']))
			{
				$data['codes'] = $this->codeInventoryModel->get_branch_code($_GET['branchid']);
			}else{
				$data['codes'] = $this->codeInventoryModel->get_list();
			}

			$this->view('finance/code/get_list' , $data);
		}

	}
