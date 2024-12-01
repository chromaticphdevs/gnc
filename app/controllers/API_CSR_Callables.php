<?php 	

	

	class API_CSR_Callables extends Controller

	{



		public function __construct()
		{
			$this->FNUserStepsModel= $this->model('FNUserStepsModel');

			$this->toc = model('TOCModel');

			$this->timesheet = model('CSR_TimesheetModel');

			$this->followUp = model('CompanyCustomerFollowUpModel');
		}


		public function show($userId)
		{
			$user = $this->FNUserStepsModel->getProductBorrowerUser( $userId );
		}
		public function forScreening()

		{

			$limit = 1;



			$branchid = $_GET['branchId'] ?? 8;


			$results = $this->FNUserStepsModel->get_product_borrower($branchid);
				

			$activeUsers = [];

			foreach($results as $key => $row) 

			{	

				$isForShipment = mTocForShipment($row->userid); 



				$isStandBy = $this->isStandBy($row->userid);



				if($isStandBy)

					continue;

				

			    //if for shipment then continue

				if( $isForShipment)

					continue;





				$isCalledToday = $this->timesheet->calledToday($row->userid);



				if($isCalledToday)

					continue;



				$row->id_sealed = seal($row->userid);

				$row->is_screening = true;



				if( !is_null($limit) ) {

					if( count($activeUsers) >= $limit )

						break;

				}



				$activeUsers[] = $row;

			}

			

			return $activeUsers;

		}



		public function singleUser()
		{

			$results = $this->forScreening();



			if(!$results)

				$results = $this->forFollowUps();



			return ee(api_response($results));

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





		public function forFollowUps()

		{

			$clients  = [];

            $level = 1;



            $limit = 1;

 

            $clients = $this->followUp->getCompanyCustomers();



            foreach($clients as $key => $client) {

            	$client->id_sealed = seal($client->id);

            	$client->is_screening = false;

            }



            return $clients;

		}

	}