<?php 	

	class LogisticModel extends Base_model
	{
		public $table = 'logistics_orders';
		
		// public $logisticEndpoint = 'http://dev.bk_logistic';

		public $logisticEndpoint = 'https://logistics.breakthrough-e.com';

		public function getByOrder($orderId)
		{
			$this->db->query(
				"SELECT * FROM $this->table
					WHERE order_id = '$orderId' 
					order by id desc"
			);

			return $this->db->single();
		}


		public function getCompleteAndAPI($id)
		{
			$this->shipment = model('FNProductReleaseModel');


			$logistic = $this->dbHelper->single(...[
				$this->table,
				'*',
				" id = '$id'"
			]);

			$endpoint = $this->logisticEndpoint. '/api/shipment/get';

			$carier  = api_call('get', $endpoint , [
				'reference' => $logistic->logistic_reference
			]);

			$carier = json_decode($carier);
			$logistic->carrier = false;

			if($carier->status) 
				$logistic->carrier = $carier->data;

			$logistic->shipment = $this->shipment->getCompleteMetaById($logistic->order_id);
			
			return $logistic;
		}
	}