<?php

	class FNCashInventory extends Controller
	{

		public function __construct()
		{
			$this->cashInventoryModel = $this->model('FNCashInventoryModel');

			// $this->user = Session::get('BRANCH_MANAGERS');

			$this->branchModel = $this->model('FNBranchModel');
		}

		public function get_list()
		{

			check_access();

			$cashInventories = $this->cashInventoryModel->get_list_descending();

			$data = [
				'title' => 'Over All Cash Inventory',
				'branches' => $this->branchModel->get_list(),
				'cashInventories' =>$cashInventories,
			];

			if(isset($_GET['branchid']))
			{
				$branchid = $_GET['branchid'];

				switch ($branchid) {
					case 'all':
						$data['cashInventories'] = $this->cashInventoryModel->get_list();
						break;

					default:
						$data['cashInventories'] = $this->cashInventoryModel->get_branch_inventory_with_name($branchid);
				}


			}

			/*
			*Total Stock amount of the branch
			*/

			$cashTotal = $this->cashInventoryModel->computeTotal($data['cashInventories']);

			$data['cashTotal'] = $cashTotal;

			return $this->view('finance/cash/cash_inventory' , $data);
		}

		public function get_transactions()
		{

			if(!Session::check('BRANCH_MANAGERS'))
			{
				die("BRANCH MANAGER ACCOUNT REQUIRED");
			}

			$user = Session::get('BRANCH_MANAGERS');
			$branchid = $user->branchid;

			$cashInventories = $this->cashInventoryModel->get_branch_inventory_with_name($branchid);
			$totalCash = 0;
			foreach ($cashInventories as $data => $value)
			{
				 $totalCash += $value->amount;
			}

			$data = [
				'title' => "Cash Transactions",
				'cashInventories' => $cashInventories,
				'cashTotal' => $totalCash
			];


			$this->view('finance/cash/cash_inventory' , $data);
		}
	}
?>
