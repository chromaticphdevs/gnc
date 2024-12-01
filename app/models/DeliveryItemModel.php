<?php 	

	class DeliveryItemModel extends Base_model
	{
		public $table = 'product_delivery_item_info';


		public function getByDelivery($deliveryId)
		{
			$data = [
				$this->table,
				'*',

				" delivery_id = '$deliveryId' "
			];
			
			return $this->dbHelper->resultSet(...$data);
		}
	}