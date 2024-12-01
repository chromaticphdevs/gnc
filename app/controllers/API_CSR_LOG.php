<?php 	

	class API_CSR_LOG extends Controller
	{
		public function __construct()
		{
			$this->timesheet = model('CSR_TimesheetModel');
			$this->userOnCall = model('UserCallModel');
			$this->CSR_ReportsModel = model('CSR_ReportsModel');
		}

		/*
		*DO NOT USE WHOIS FUNCTION ON API_CONTROLLERS
		*/

		public function save()
		{
			$punchTime = today();

			$data = request()->inputs();

			$customerId = unseal($data['customerId']);

			$userId = $data['userId'];

			$account_type =  $data['account_type'];


			$call = $this->userOnCall->getAndDropCall($customerId , $userId , $account_type);

			if(!$call) {

				ee(api_response( $this->userOnCall->error ?? 'walang error' , false));
				return;
			}

			ee(api_response( " Finished "));
		}


		/*
		*DO NOT USE WHOIS FUNCTION ON API_CONTROLLERS
		*/
		public function call()
		{
			$post = request()->inputs();

			// $userId = whoIs()['id'];

			$customerId = unseal($post['customerId']);
			$callerId = $post['callerId'];

			if(!$callerId) {
				ee(api_response('you are not logged in' , false));
				return;
			}

			$isCalled = $this->userOnCall->call($customerId , $callerId);

			if(!$isCalled) {
				ee( api_response( $this->userOnCall->error ?? 'something went wrong' , false) );
			}else{
				ee(api_response('Ok'));
			}
			
		}

		public function dropCall()
		{

			$post = request()->inputs();
			$userId = whoIs()['id'];
			$customerId = unseal($post['customerId']);

			if(!$userId) {
				ee(api_response('not set' , false));
				return;
			}

			$this->userOnCall->dropCall($customerId , $userId);
			ee(api_response('ok'));
		}

		public function get_call_history()
		{	
			$userId = whoIs()['id'];
			$account_type = whoIs()['whoIs'];

			$data = [
                'list' => $this->timesheet->get_call_history($userId, $account_type),
                'user_id' => seal($userId),
                'sorted_call_duration' => $this->CSR_ReportsModel->get_sorted_duration($userId, $account_type)
            ]; 

            return $this->view('csr/csr_summary' , $data);
		}


		

	}