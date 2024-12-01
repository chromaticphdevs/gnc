<?php 	

	class INStockBranchModel extends Base_model
	{

		public $table = 'fn_item_inventories';



		public function __construct()
		{
			parent::__construct();

			$this->fninventory = new FNItemInventoryModel();
		}

		public function getStockMovementWithLimit($branchid , $limit)
		{
			$params = "
				WHERE inventory.branchid = '$branchid'
				LIMIT $limit
			";

			return $this->fninventory->get_list($params);
		}

		public function getStockMovementByProduct($branchid , $product_id , $limit = null)
		{
			if(!is_null($limit))
				$limit = " LIMIT {$limit}";

			$params = "
				WHERE inventory.branchid = '$branchid'
				AND inventory.product_id = '$product_id'
			";

			return $this->fninventory->get_list($params);
		}

		public function getStockSummary($branch_id)
		{
			return $this->fninventory->getSummaryByBranch($branch_id);
		}
	}