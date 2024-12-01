<?php 	

	class API_TocController extends Controller
	{

		public function __construct()
		{
			$this->toc = model('TOCModel');
		}

		public function moveToShipment()
		{
			$userId = request()->input('userId');
			
			$isUpdate = $this->toc->moveToShipping( $userId , 0);

			if($isUpdate) {
				ee(api_response("Shipped"));
			}else{
				ee(api_response("Something went wrong"));
			}
		}
	}