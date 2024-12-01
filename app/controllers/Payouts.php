<?php 	

	class Payouts extends Controller
	{

		public function __construct()
		{
			// if(Auth::user_position() != '1'){
			// 	die('You have no access on this page');
			// }
			$this->payoutModel = $this->model('payoutModel');

		}

		public function index()
		{
			Authorization::setAccess(['admin']);			

			$this->view('payout/index');

		}

		public function displayPayout()
		{
			Authorization::setAccess(['admin']);			
			if($this->request() === 'POST')
			{
				$latestPayout = $this->payoutModel->getLatestPayout();

				$start  = !empty($latestPayout) ? $latestPayout : '2019-10-1';
				$end    = date('Y-m-d h:i:s');

				if($start == $end)
				{
					Flash::set('You have already generated a payout for today' , 'danger');
					redirect('payouts/index');
				}
				else{
					$userList = $this->getUsers();

					$data = [
						'payoutList' => $this->payoutModel->displayPayoutList($start , $end , $userList),
						'start'    => $start , 
						'end'      => $end
					];

					$this->view('payout/display' , $data);
				}
				
			}
		}

		public function generatePayout()
		{
			Authorization::setAccess(['admin']);			

			if($this->request() === 'POST')
			{
				$start = $_POST['start'];
				$end   = $_POST['end'];

				$res = $this->payoutModel->generatePayout($start , $end , $this->getUsers());
				
				if($res){

					Flash::set("Payout for {$start} to {$end} has been generated");

					redirect('payouts/preview/'.$res);

				}else{
					die("something went wrong");
				}
			}
		}

		public function add_cheque_img()
		{
			if($this->request() == 'POST') 
			{
				$this->payrollModel = $this->model('payrollModel');

				$this->payrollModel->add_cheque_img($_POST , $_FILES['chequeimg']);
			}
		}
		private function getUsers(){

			$this->userModel = $this->model('user_model');

			return  $this->userModel->get_all(100000);
		}

		public function preview($payoutid)
		{
			Authorization::setAccess(['admin']);			

			$this->payrollModel = $this->model('payrollModel');
			
			$data = [
				'payout' => $this->payoutModel->getPayout($payoutid),
				'payoutList' => $this->payrollModel->getRecievers($payoutid)
			];


			$this->view('payout/preview' ,$data);
		}
		public function list()
		{
			Authorization::setAccess(['admin']);			

			$data = [
				'payoutList' => $this->payoutModel->getList()
			];

			$this->view('payout/list' , $data);
		}

		public function walletBallance()
		{
			Authorization::setAccess(['admin']);			

			$data = [
				'hasBalance' => $this->payoutModel->getHasBalance()
			];

			$this->view('payout/hasbalance' , $data);
		}

		public function my_payouts()
		{
			Authorization::setAccess(['admin' , 'customer']);

			$userid = Session::get('USERSESSION')['id'];

			$chequeModel = $this->model('payoutchequeModel');

			$data = [
				'chequeList' => $chequeModel->getList($userid)
			];

			$this->view('cheque/list' , $data);
		}


		public function view_my_payout($chequeid)
		{
			Authorization::setAccess(['admin' , 'customer']);

			$userid = Session::get('USERSESSION')['id'];

			$chequeModel = $this->model('payoutchequeModel');

			$data = [
				'cheque' => $chequeModel->getCheque($chequeid)
			];

			
			// die(var_dump($data));

			$this->view('cheque/view' , $data);
		}
	}