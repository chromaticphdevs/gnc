<?php 	
	
	class INStockBranch extends Controller
	{

		public function __construct()
        {
            $this->fnbranch = $this->model('FNBranchModel');
            $this->itemInventory = $this->model('FNItemInventoryModel');
            $this->stockbranch = $this->model('INStockBranchModel');
        }

		public function show()
		{
			if(!isset($_GET['branch_id']))
				return requestInvalid();//invalid request

			$branch_id = $_GET['branch_id'];

			$data = [
				'branch_id' => $branch_id,
				'branch'    => $this->fnbranch->dbget($branch_id),
				'stockMovements' => $this->stockbranch->getStockMovementWithLimit( $branch_id , 100),
				'stockSummaries'   => $this->stockbranch->getStockSummary( $branch_id )
			];
			
			/*
			*Get stock movement by branch and product
			*/
			if(isset($_GET['product_id']))
				$data['stockMovements'] = $this->stockbranch->getStockMovementByProduct($branch_id , $_GET['product_id']);

			return $this->view('inventory/branchstock/show' , $data);
		}
	}