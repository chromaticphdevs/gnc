<?php 	

	class API_CompanyFollowUp extends Controller
	{

		public function __construct()
		{
			$this->followUp = model('CompanyCustomerFollowUpModel');
            $this->user_model = model('User_model');
            $this->callModel = model('UserCallModel');
            $this->profiling = model('UserProfilingModel');
            $this->userAddresses = model('UserAddressesModel');
		}

		public function index()
		{
			$clients  = [];
            $level = 1;
 
            if(isset($_GET['level']) && intval($_GET['level']) > 1)
            {
                $level = $_GET['level'];
                $clients = $this->followUp->getByLevel($_GET['level']);
            }else{
                
                $clients = $this->followUp->getCompanyCustomers();

                foreach($clients as $key => $client) {
                	$client->id_sealed = seal($client->id);
                }
            }

            ee(api_response($clients));
		}

		public function show()
		{
			$q = request()->inputs();

			$userIdSealed = $q['userIdSealed'];

			$userId = unseal($userIdSealed);

            $user = $this->followUp->getUser($userId);
            
            $userNotes = $this->followUp->getUserNotes($userId);

            // $yourCustomer = $this->customerPreviewValidate($userId);
            
            // if(!$yourCustomer)
            //     return redirect('company-customers-follow-ups/');

            $user->id_sealed = seal($user->id);

            $mobileServiceProvider = sim_network_identification($user->mobile);
            

            $data = [
                'user' => $user,
                'mobileServiceProvider' => $mobileServiceProvider,
                'userNotes' =>  $userNotes,
                'userIdSealed' => $userIdSealed,
                'userLevel'   => $this->followUp->userLevel($userId),
                'total_direct' =>$this->user_model->get_direct_sponsor_total($userId),
                'currentCustomer' => $this->callModel->getCustomer(whoIs()['id']),
                'profiling' => $this->profiling->get_user_profiling_info($userId),
                'addresses' => [
                    'cop' => $this->userAddresses->getCOP($userId)
                ]
            ];

            $payloads = json_encode($data);

            ee(api_response( $payloads ));
		}


        public function moveToNextLevel()
        {
            $q = request()->inputs();

            $q = json_decode($q['payloads']);

            $userIdSealed = $q->userIdSealed;

            $userId = unseal($userIdSealed);

            $notes = str_escape($q->notes);

            $whoIs = $q->auth;
            
            $profilingData = [
                'userid' => $userId,
                'source_income' => $q->sourceIncome,
                'income' => $q->income,
                'house_rental' => $q->houseRental,
                'dependents' => $q->dependents,
                'rice_consumption' => $q->riceConsumption,
                'process_by' => $q->processedBy,
                'account_type' => $whoIs->whoIs
            ];

            
               
            $info = $this->profiling->storeWithCop($profilingData);

            $caller = [
                'callerId' => $whoIs->id,
                'type'     => $whoIs->whoIs
            ];

            $this->followUp->setCaller($caller);


            $result = $this->followUp->moveNextLevelWithTimeSheet($userId , $notes);

            ee(api_response( $this->profiling->id ));
        }
	}