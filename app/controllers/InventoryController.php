<?php 
	use Classes\Loan\LoanService;
	use CLasses\Inventory\InventoryService;

	load(['LoanService'],CLASSES.DS.'Loan');
	load(['InventoryService'],CLASSES.DS.'Inventory');

	class InventoryController extends Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->model = model('InventoryModel');
		}

		public function index()
		{
			$data = [
				'inventories' => $this->model->dbget_desc('id'),
				'navigationHelper' => $this->navigationHelper
			];
			
			return $this->view('inventory/index', $data);
		}
		/**
		 * BRANCH DISTRIBUTION
		 */
		public function distributeBoxOfCoffee()
		{

			if (request()->isPost()) {
				$post = request()->inputs();
				$isOk = $this->model->distributeBoxOfCoffee($post);

				if ($isOk) {
					Flash::set("Box of Coffee Distributed");
				} else {
					Flash::set("Unable to distribute box of coffee");
				}
				return redirect('InventoryController');
			}

			$data = [
				'title' => 'Stocks Branch Box of Coffee Distribution',
				'boxOfCoffeePrice' => LoanService::BOX_OF_COFEE_PRICE,
				'branches' => LoanService::BRANCHES,
				'movement' => [
					InventoryService::MOVEMENT_ADD,
					InventoryService::MOVEMENT_DEDUCT
				]
			];

			return $this->view('inventory/box_of_coffee_distribution',$data);
		}
	}