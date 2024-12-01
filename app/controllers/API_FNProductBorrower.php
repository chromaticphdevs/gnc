<?php 	

	class API_FNProductBorrower extends Controller
	{
		
		public function __construct()
		{
			$this->FNProductBorrowerModel = $this->model('FNProductBorrowerModel');
			$this->timesheet = model('CSR_TimesheetModel');
			$this->FNUserStepsModel= $this->model('FNUserStepsModel');

			$this->userCall = model('UserCallModel');
		}



		/*
		*ENDPOINTS
		*/

		public function get_released_product_cash_collection()
		{
			$request = request()->inputs();

			$branchid = $request['branchid'];
			$status   = $request['status'];

			$results = $this->FNProductBorrowerModel->get_released_product_users($branchid, $status);

			$uData = null;

			$isCalledTodayArr = [];

			foreach($results as $key => $row)
			{

				if( ! is_null($uData))
					break;

				//add check balance
				if($row->balance <= 0 )
					continue;


				$isOnCall = $this->userCall->getStatus( $row->userid );

				if($isOnCall)
					continue;

				$isCalledToday = $this->timesheet->calledToday($row->userid);
				if($isCalledToday)
					continue;
				
				$isCalledTodayArr [] = $isCalledToday;

				if(!$isCalledToday)
					$uData = $row;
			}


			//reformat data
			if( !is_null($uData))
			{
				$user = $this->FNUserStepsModel->getProductBorrowerUser( $uData->userid );


				$user->id_sealed = seal($uData->userid);
				$user->balance = $uData->balance;

				ee(api_response($user));
			}else{
				ee(api_response('not available'));
			}
		}

		public function get_released_product_cash_collection_d()
		{
			$request = request()->inputs();

			$branchid = $request['branchid'];
			$status   = $request['status'];

			$results = $this->FNProductBorrowerModel->get_released_product_users($branchid, $status);


			$uData = null;

			$isCalledTodayArr = [];

			foreach($results as $key => $row)
			{
				if( ! is_null($uData))
					break;

				$isOnCall = $this->userCall->getStatus( $row->userid );

				if($isOnCall)
					continue;

				$isCalledToday = $this->timesheet->calledToday($row->userid);
				if($isCalledToday)
					continue;
				
				$isCalledTodayArr [] = $isCalledToday;

				if(!$isCalledToday)
					$uData = $row;
				// if($isCalledToday === false)
				// $uData = $row;
			}


			//reformat data
			if( !is_null($uData))
			{
				$user = $this->FNUserStepsModel->getProductBorrowerUser( $uData->userid );


				$user->id_sealed = seal($uData->userid);


				ee(api_response($user));
			}else{
				ee(api_response('not available'));
			}
		}

		
	}