<?php

  class FNProductReleaseModel extends Base_model
  {
    public $table = 'fn_product_release';

    public function getGroupedQuantity($userId)
	{
		$this->db->query(
			"SELECT quantity FROM fn_product_release
				GROUP BY quantity"
		);

		return $this->db->resultSet();
	}

	public function get($id)
	{
		return parent::single([
			
		]);
	}
	public function getCompleteMeta()
	{
		$this->library = model('INCodelibraryModel');
		$this->user = model('User_model');

		/*ON SHIPPED ITEMS*/

		$onShippedItems = $this->dbHelper->resultSet(...[
			'logistics_orders',
			'*'
		]);

		$onShippedItemIds = [];

		foreach($onShippedItems as $key => $item)
		{
			array_push($onShippedItemIds, $item->order_id);
		}

		$shipments = $this->dbHelper->resultSet(...[
			$this->table,
			'*',
			"id not in ('".implode("','", $onShippedItemIds)."')",
			' id asc '
		]);

		foreach($shipments as $shipmentKey => $shipment) {

			$shipment->parcel = $this->library->dbget($shipment->code_id);
			$shipment->user   = $this->user->getPublic($shipment->userid);
		}

		return $shipments;
	}

	public function getCompleteMetaById($id)
	{
		$this->library = model('INCodelibraryModel');
		$this->user = model('User_model');

		$shipment= $this->dbHelper->single(...[
			$this->table,
			'*',
			" id = '{$id}' ",
			' id asc '
		]);

		$shipment->parcel = $this->library->dbget($shipment->code_id);
		$shipment->user   = $this->user->getPublic($shipment->userid);

		return $shipment;
	}

	public function getTotal($userId)
    {
        $this->db->query(
            "SELECT SUM(amount) as total , MAX(id) as loan_id
                FROM $this->table
                WHERE userid = '$userId'
                GROUP BY userid "
        );

        return $this->db->single();
    }
   	

   	public function getAdvanceList($shipmentStatus)
   	{
   		$userModel = model('User_model');
   		$copModel = model('UserAddressesModel');

   		$results = parent::db_get_results("shipment_status = '$shipmentStatus' AND category = 'advance-payment'");

   		foreach($results as $key => $row)
   		{
   			//get user
   			$row->user = $userModel->get_user( $row->userid );
   			//get cop
   			$row->cop = $copModel->getCOP( $row->userid );
   		}

   		return $results;
   	} 

   	public function getAdvanceProductList()
   	{
   		$userModel = model('User_model');
   		$copModel = model('UserAddressesModel');

   		$results = parent::db_get_results("`code_id` = 5 AND `quantity` = 60 AND `delivery_fee`=1500 AND `status` = 'Approved' AND `category` = 'product-loan' ORDER BY `id` DESC");

   		foreach($results as $key => $row)
   		{
   			//get user
   			$row->user = $userModel->get_user( $row->userid );
   			//get cop
   			$row->cop = $copModel->getCOP( $row->userid );
   		}

   		return $results;
   	} 
  }