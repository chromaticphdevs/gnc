<?php 	

	class API_CollectedContact extends Controller
	{	

		public function __construct()
		{
			$this->model = model('CollectedContactModel');
		}

		public function store()
		{
			// ee( api_response(" HELLOW "));
			
			$contacts = request()->input('contacts');

			$contacts = $_POST['contacts'];

			if(!empty($contacts))
				$contacts = json_decode($contacts);

			if( empty($contacts)){
				return ee(api_response( "no result" , false));
			}

			// $contacts = 
			// [
			// 	(object) [
			// 		'mobile_number' => '09063387451',
			// 		'direct' => '117',
			// 		'name'   => 'TEST QA'
			// 	],

			// 	(object) [
			// 		'mobile_number' => '09955003501',
			// 		'direct' => '117',
			// 		'name'   => 'TEST QA 1'
			// 	]
			// ];
			
			$res = $this->model->storeMultiple($contacts);

			if(!$res) {
				ee(api_response( $this->model->getErrorString() , false));
				return;
			}

			ee( api_response( $res ) ); 
		}
	}