<?php 	

	class API_UserAddresses extends Controller
	{

		public function __construct()
		{
			$this->model = model('UserAddressesModel');
		}


		public function updateCOPAddress()
		{
			$q = request()->inputs();
			
			$r = $this->model->add([
				'userid'  => $q['userid'],
				'address' => $q['address'],
				'type'    => 'COP'
			]);

			if($r){
				ee(api_response("Updated"));
			}else{
				ee(api_response("Something went wrong" , false));
			}
		}
	}