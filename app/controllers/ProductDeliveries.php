<?php 	

	class ProductDeliveries extends Controller
	{

		public function __construct()
		{
			$this->model = model('ProductDeliveryModel');
		}


		public function index()
		{
			$results = $this->model->getAll();

			$status = $_GET['status'] ?? '';
			
			$data = [
				'deliveries' => $results,

				'status'     => $status
			];

			return $this->view('finance/product_deliveries/index' , $data);
		}

		public function update()
		{
			$q = request()->inputs();

			$deliveryId = $q['delivery_id'];
			$action = $q['action'];

			$u = $this->model->dbupdate([
				'status' => $action
			] , $deliveryId);

			if($u) {
				Flash::set("Deliveries updated!");
			}

			return request()->return();
		}
	}