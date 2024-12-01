<?php 	
	use Bank\Pera;

	require_once CLASSES.DS.'banks/Pera.php';

	class Bank extends Controller
	{	

		public function __construct()
		{
			$this->pera = model('BankPeraModel');

			$this->banklog = model('BankTransferLogModel');

			$this->auth = whoIs();
		}

		public function index()
		{
			$userId = $this->auth['id'];

			$data = [
				'pera' => $this->pera->getByUser($userId),
				'logs' => $this->banklog->getByUser($userId)
			];

			return $this->view('bank/index' , $data);
		}
		/*
		*Connect to a bank
		*/
		public function create()
		{
			$userId = $this->auth['id'];


			$data = [
				'pera' => $this->pera->getByUser($userId),
				'logs' => $this->banklog->getByUser($userId)
			];

			if( $data['pera'])
				return redirect('bank/index');

			return $this->view('bank/create' , $data);
		}

		public function test()
		{	
			$userId = $this->auth['id'];

			$pera_class = new Pera();

			$peraAccount = $this->pera->getByUser($userId);

			/**
			 * Validate if user has pera account
			 */
			if(!$peraAccount)
				return $this->addError("{$user->fullname} ,No pera account , your payout request is subject for confirmation");
			
			/**
			 * Try connecting account to 
			 * Pera-E API
			 */
			$isConnected = $pera_class->connectAuth($peraAccount->api_key , $peraAccount->api_secret);

			if(!$isConnected)
				return $this->addError("{$user->fullname} Cannot connect to pera-e.com!");


			$result = $pera_class->sendMoney(...[-100,1232555,"test 101"]);
			dump($result);
		}

		public function edit()
		{
			$userId = $this->auth['id'];

			$data = [
				'pera' => $this->pera->getByUser($userId),
				'logs' => $this->banklog->getByUser($userId)
			];

			return $this->view('bank/edit' , $data);
		}


		public function update()
		{	
			$user_id = get_userid();

			$q = request()->inputs();

			$pera_class = new Pera();

			$isValid = $pera_class->connectAuth($q['apiKey'] , $q['apiSecret']);

			if(!$isValid){
				Flash::set("Invalid KEY or Secret", 'danger');
			}else{

				$pera_class->registerAuth($q['apiKey'] , $q['apiSecret']);

				$response = $pera_class->response();

				if($response->status) {

					$data = $response->data;

					$result= $this->pera->update_account($data , $user_id);
	
					if($result) {
						Flash::set("Account updated");
					}
				}
			}

			
			return request()->return();
		}


		public function register()
		{
			$post = request()->inputs();


			$pera = new Pera();

			$pera->registerAuth($post['apiKey'] , $post['apiSecret']);

			$response = $pera->response();

			if($response->status) {

				$data = $response->data;

				$result = $this->pera->store([
					'user_id' => $this->auth['id'],
					'api_key' => $data->apiKey,
					'api_secret' => $data->apiSecret,
					'account_number' => $data->accountNumber,

				]);

				if($result) {
					Flash::set("Bank connected");
				}
			}else{
				Flash::set("Something went wrong with the connection" , 'danger');
			}

			return redirect('bank/create');
		}
	}