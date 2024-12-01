<?php 	

	class ShipmentSearch extends Controller 
	{

		public function __construct()
		{
			$this->model = model('FNDeliveryInfoModel');
		}

		public function index()
		{
			$data = [];

			if(isset($_GET['control_number']) && !empty($_GET['control_number']))
			{
				$controlNumber = $_GET['control_number'];

				if(empty($controlNumber))
				{
					Flash::set("invalid Request" , false);

					return request()->return();
				}

				$shipment = $this->model->getByControlNumber($controlNumber);

				$data['shipment'] = $shipment;
				
			}


			return $this->view('shipment/index' , $data);
		}


		public function search()
		{
			$data = [];

			
			dump($data);

			return $this->view('shipment/search' , $data);

		}
	}