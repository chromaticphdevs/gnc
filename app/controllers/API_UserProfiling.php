<?php 	



	class API_UserProfiling extends Controller

	{



		public function __construct()

		{

			$this->model = model('UserProfilingModel');



			$this->companyFollowUpModel = model('CompanyCustomerFollowUpModel');

		}



		// createLogs

		

		public function save()

		{

			$errors = [];



			$requiredFields = [

				'sourceIncome' , 

				'income' , 'houseRental',

				'dependents' , 'riceConsumption'

			];



			$q = request()->inputs();





			//check required fields if empty

			foreach($requiredFields as $key => $row) 

			{

				if( empty($q[$row]) ) {

					$errors[] = "{$row} must not be empty"; 

				}

			}



			if(!empty($errors))

			{

				return ee(api_response([

					'retval' => 'error',

					'message' => implode(',' , $errors)

				]));

			}



			$r = $this->model->storeWithCop([

				'userid' => $q['userId'],

				'source_income' => $q['sourceIncome'],

				'income' => $q['income'],

				'house_rental' => $q['houseRental'],

				'dependents' => $q['dependents'],

				'rice_consumption' => $q['riceConsumption'],

				'process_by'  => $q['processedBy'],

				'account_type' => $q['whoIs'],

				'cop' => $q['cop'] ?? 'N/A'

			]);



			$this->companyFollowUpModel->createLogs([

				'userId' => $q['userId'],

				'processedBy' => $q['processedBy'],

				'remarks' => 'no-remarks',

				'notes' => $q['notes']

			]);



			return ee( api_response([

				'retval' => $r,

				'message' => 'ok'

			]) );			

		}


		public function numberStatusUpdate()
		{
			$q = request()->inputs();

			$res = $this->model->dbupdate([
				"number_status" => $q['status']
			] , $q["id"]);


			$retval = "Success";

			if(!$res)
				$retval = "Update failed!";

			return ee( api_response($retval , $res) );
		}

	}