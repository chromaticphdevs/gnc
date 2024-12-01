<?php 	

	class TKPayout extends Controller
	{

		public function __construct()
		{
			$this->tkapp = model('TimekeepingAppModel');
			$this->tkappPayout = model('TKPayoutModel');
		}

		public function index()
		{
			$walletResponse = $this->tkappPayout->getAll();

			$wallets = [];

			if($walletResponse->status)
				$wallets = $walletResponse->data;

			$tkAppSession = $this->tkapp->session;

			return $this->view('timekeeping/payout/index' , compact(['wallets' , 'tkAppSession']));
		}

		public function multiplePayout()
		{
			//tkapp token

			$post = request()->inputs();

			$tkappToken = $post['token'];

			$usersPayout = $post['usersId'];

			if(!isEqual($tkappToken , $this->tkapp->session)){
				Flash::set("Invalid token");
				return request()->return();
			}

			$resultsResponse = $this->tkappPayout->multiplePayout($usersPayout);
			
			if(!empty($resultsResponse->warnings))
			{
				foreach($resultsResponse->warnings as $key => $warning) {
					$message .= "<p> {$warning} </p>";
				}
			}

			Flash::set($message , 'info');


			return redirect('TKPayout');
		}

		/*
		*UserToken
		*/
		public function singlePayout($userToken)
		{
			$get = request()->inputs();
			
			$userId = unseal($get['user_id']);

			if(! isEqual($this->tkapp->session , $userToken))
			{
				Flash::set("Invalid Request");
				return request()->return();
			}

			$response = $this->tkappPayout->singlePayout($userId);

			
			Flash::set($response->warnings);

			return request()->return();
		}
	}