<?php

	class FNUserSteps extends Controller
	{


		public function __construct()
		{
			$this->FNUserStepsModel= $this->model('FNUserStepsModel');
			$this->toc = model('TOCModel');
			$this->productReleaseModel = model('FNProductReleaseModel');
		}

		public function import()
		{
			$this->FNUserStepsModel->insert_step1_users();
		}


		public function get_position1()
		{	
			$branchid = check_session();
			/*
			*users on position 1 and not in standby mode
			*/

			$activeUsers = [];

			$isStandBy = false;

			$results = $this->FNUserStepsModel->get_product_borrower($branchid);
			
			foreach($results as $key => $row) 
			{	
				$isStandBy = $this->isStandBy($row->userid);

				if($isStandBy){
					continue;
				}else{
					array_push($activeUsers , $row);
				}
			}

			$isCsr = true;
			$isStockManager = true;
			$whoIsType = whoIs()['type'];

			if( !isEqual( $whoIsType , CSR_TYPE) )
				$isCsr = false;

			if( !isEqual( $whoIsType , STOCK_MANAGER_TYPE))
				$isStockManager = false;

			$data = [
				'step_number' => 1,
				'title' => "Step 1 ( Client List )",
                'result' => $activeUsers,
                'productAutoloan'  => mGetCodeLibraries(17),
                'isCsr'   => $isCsr,
                'isStockManager' => $isStockManager
            ];

             $linksAndButtons = [
                'previewLink' => '/company-customers-follow-ups/show',
                'updateController' => '/company-customers-follow-ups/update',
            ];

            $data['linksAndButtons'] = $linksAndButtons;
            
            $this->view('finance/toc/position1' , $data);
		}

		public function isStandBy($userId)
		{
			$isExists = $this->toc->getByUser($userId);

			if(!$isExists) 
			 return false;

			if($isExists && $isExists->is_standby) 
			 return true;

			return false;
		}
		public function get_user_list($stepNumber)
		{
			$step_number = unseal($stepNumber);
			$branchid = check_session();

			$status ='Approved';
			$data = [
				'title' => "Step {$step_number} ( Client List )",
                'result' => $this->FNUserStepsModel->get_user_list(compact(['branchId' , 'status']))
            ];
            $this->view('finance/collector/collector_task' , $data);
		}
		


        public function all_toc_position()
        {	
        	$isCsr = true;
			$isStockManager = true;
			$whoIsType = whoIs()['type'];

			if( !isEqual( $whoIsType , CSR_TYPE) )
				$isCsr = false;

			if( !isEqual( $whoIsType , STOCK_MANAGER_TYPE))
				$isStockManager = false;

        	//init data sets
        	$data = [];

            if( isset($_GET['advance_payment_list']))
            {
            	//for deliveries
            	$data['result'] = $this->productReleaseModel->getAdvanceList('pending');
            	$data['isCsr'] = $isCsr;
            	$data['isStockManager'] = $isStockManager;

            	return $this->view('finance/toc/advance_payment_list' , $data);
            }   

             if( isset($_GET['temp_list']))
            {
            	//for deliveries
            	$data['result'] = $this->productReleaseModel->getAdvanceProductList();
            	$data['isCsr'] = $isCsr;
            	$data['isStockManager'] = $isStockManager;

            	return $this->view('finance/toc/advance_payment_list' , $data);
            }   

            $branchid = check_session();
			/*
			*users on position 1 and not in standby mode
			*/

			$activeUsers = [];

			$isStandBy = false;

			$results = $this->FNUserStepsModel->get_product_borrower($branchid);
			
			foreach($results as $key => $row) 
			{	
				$isStandBy = $this->isStandBy($row->userid);

				if($isStandBy){
					continue;
				}else{
					array_push($activeUsers , $row);
				}
			}

			$data = [
				'step_number' => 1,
				'title' => "All ( Client List )",
                'result' => $activeUsers,
                'productAutoloan'  => mGetCodeLibraries(17),
                'isCsr'   => $isCsr,
                'isStockManager' => $isStockManager
            ];


            $tocPassers = $this->toc->getAllPosition();

            $data['tocAll'] = [
                'tocPassers' => $tocPassers
            ];

            /*
        	*Quick Fix only
        	*if forDeliveries then show other table
        	*/
        	if( isset($_GET['forDeliveries']) ){
        		return $this->view('finance/toc/for_deliveries' , $data);
        	}

            return $this->view('finance/toc/view_all' , $data);
        }


        public function send($number)
        {	

        	$sms_content = "Watch video breakthrough mechanics here at https://breakthrough-e.com/videos";

    		$sendSmsData = [
                'mobile_number' => $number,
                'content'      => $sms_content,
                'category' => 'SMS'
            ];

			$sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $sendSmsData);
			$sms = json_decode($sms);

			Flash::set("SMS Sent");
			return request()->return();
        }
		

	}
