<?php 	
	
	class API_UserCustomerFollowUp extends Controller
	{
		public function __construct()
		{
			$this->followUp = model('UserCustomerFollowUpModel');
			$this->user_model = model('User_model');
			$this->profiling = model('UserProfilingModel');
		}

		public function index()
		{
			$responses = $this->followUp->getFirstLevel();

			if(!$responses){
				ee(api_response("no response" , false));
			}else
			{
				foreach($responses as $key => $row) {
					$row->id_sealed = seal($row->id);
				}
				
				ee(api_response($responses));
			}
		}


		public function get()
		{

			$q = request()->inputs();

			$userIdSealed = $q['userIdSealed'];

			$userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);


            $user->id_sealed = seal($user->id);

            $userNotes = $this->followUp->getUserNotes($userId);
            	
            $profiling = $this->profiling->get_user_profiling_info($userId);

            $data = [
                'user' => $user,
                'userNotes' =>  $userNotes,
                'profiling'   => $profiling,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'total_direct' =>$this->user_model->get_direct_sponsor_total($userId),
                'currentCustomer' => false
            ];  


            // ee(api_response($data));

            // return;
            
            $payloads = json_encode($data);


            ee(api_response( $payloads ));
		}
	}