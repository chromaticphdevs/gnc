<?php 	

	class LDTransferAccount extends Controller
	{

		public function __construct()
		{
			$this->userModel = $this->model('User_model');

			$this->transferModel = $this->model('LDTransferAccountModel');
		}

		public function index()
		{
			$data = [
				'title' => 'Transfer Account'
			];
			//check if post isset

			if($this->request() === 'POST')
			{
				$username = trim(filter_var($_POST['username'] , FILTER_SANITIZE_STRING));

				$result = $this->userModel->get_by_username($username);

				if(!empty($result))
				{
					$token = Session::set('transferToken' , seal(uniqid('' , true)));
					Session::set('transferTokenId' , $result->id);

					redirect("LDTransferAccount/transfer_account/?token={$token}&userid={$result->id}");
				}
			}

			$this->view('lending/transfer/index' , $data);
		}

		public function transfer_account()
		{
			if(! isset($_GET['token'] , $_GET['userid']))
			{
				die('Must set token and userid');			
			}else
			{
				$token  = $_GET['token'];
				$userid = $_GET['userid'];
				//check match token
				if($token !== Session::get('transferToken')) 
				{
					die('INcorrect token');
				}

				if($userid !== Session::get('transferTokenId'))
				{
					die('Misleading userid');
				}

				/*load all*/

				$branchModel = $this->model('LDBranchModel');

				$user = $this->userModel->get_user($userid);

				$data = [
					'branchList' => $branchModel->get_list() ,
					'user'       => $user
				];

				if($this->request() === 'POST')
				{
					$result = $this->transferModel->transfer_account($_POST);

					if($result) {
						Flash::set("Account Transfered {$_POST['firstname']} {$_POST['lastname']}");
						redirect('LDTransferAccount');
					}		
				}

				$this->view('lending/transfer/user_view' , $data);
			}
			
		}
	}