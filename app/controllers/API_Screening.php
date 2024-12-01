<?php 	
	
	class API_Screening extends Controller
	{

		public function __construct()
		{
			$this->FNUserStepsModel= $this->model('FNUserStepsModel');
			$this->toc = model('TOCModel');
			$this->timesheet = model('CSR_TimesheetModel');
		}



		public function index()
		{	

			$branchid = $_GET['branchId'] ?? 8;

			$limit = $_GET['limit'] ?? null;

			$activeUsers = [];
		
			$results = $this->FNUserStepsModel->get_product_borrower($branchid);
			
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

				if( !is_null($limit) ) {
					if( count($activeUsers) >= $limit )
						break;
				}

				$activeUsers[] = $row;
			}


			ee(api_response($activeUsers));
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


	}