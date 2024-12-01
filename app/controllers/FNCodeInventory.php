<?php

	class FNCodeInventory extends Controller
	{

		private $companies = [
			'break-through' , 'sne'
		];

		// private $activationLevels = [
		// 	'starter' , 'bronze' , 'silver' , 'gold' , 'platinum' , 'diamond', 'Product Loan', 'Rejuve Set', 'Rejuve Set for Activated', 'Product Repeat purchase'
		// ];

		public function __construct()
		{
			$this->codeInventoryModel = $this->model('FNCodeInventoryModel');
			$this->branchModel = $this->model('FNBranchModel');

			$this->activationLevels = activationlevels();
		}

		/*
		*Show codes
		*/
		public function index()
		{

			$data = [
				'title' => 'Code Inventory',
				'codes' => $this->codeInventoryModel->getFiltered("code.status = 'available'", 'code.id desc' , '100'),
				'branches' => $this->branchModel->get_list_asc('name'),
				'levels'   => $this->activationLevels,
				'status'   => [
					'Available','Released','Used','Expired'
				]
			];


			if(isset($_GET['filter']))
			{
				/*
				*Can be filtered by 
				*Branch , Code Status 
				*Level
				*
				*With Result Limiter
				*/

				/*
					First Array is where , order by , limit
				*/

				$limiter = empty($_GET['limit']) ? 100 : $_GET['limit'];

				$filters = [
					" code.branchid like '%{$_GET['branch_id']}' 
						AND code.level = '{$_GET['level']}'
						AND code.status = '{$_GET['status']}'" ,

					' code.id ',

					$limiter
				];

				$data['codes'] = $this->codeInventoryModel->getFiltered(...$filters);
				
			}

			return $this->view('finance/code/v2/index' , $data);
		}


		public function create()
		{
			$data = [
				'title' => 'Code Inventory',
				'branches' => $this->branchModel->get_list(),
				'companies' => $this->companies,
				'activationLevels' => $this->activationLevels,
				'codeStorages'     => $this->codeInventoryModel->get_code_storage_list()
			];

			return $this->view('finance/code/v2/create' , $data);
		}


		public function store()
		{

			$post = request()->inputs();

			$data = [
				'codeid'     => $post['codeid'] ,
				'branchid'   => $post['branchid'],
				'company'    => $post['companies'],
				'quantity'   => $post['quantity']
			];

			$result = $this->codeInventoryModel->generate_codes($data);

			Flash::set("Code Generated {$post['quantity']}");

			if(!$result)
				flash_err();

			return redirect("FNCodeInventory");
				$result = $this->codeInventoryModel->generate_codes($data);
		}

		/*
		*OLD
		*SUBJECT FOR DELETION
		*/

		public function make_code()
		{
			if($this->request() === 'POST')
			{
				$result =
					$this->codeInventoryModel->make_code_info($_POST);

				if($result)
				{
					Flash::set("Codes has been created");
				}

				redirect('FNCodeInventory/make_code');
			}

			$data = [
				'title' => 'Code Inventory',
				'codes' => $this->codeInventoryModel->get_list("ORDER BY id desc"),
				'branches' => $this->branchModel->get_list(),
				'companies' => $this->companies,
				'activationLevels' => $this->activationLevels,
				'codeStorages'     => $this->codeInventoryModel->get_code_storage_list()
			];


			return $this->view('finance/code/make_code' , $data);
		}

		/*
		*OLD
		*SUBJECT FOR DELETION
		*/
		public function generate_codes()
		{
			if($this->request() === 'POST')
			{
				$data = [
					'codeid'     => $_POST['codeid'] ,
					'branchid'   => $_POST['branchid'],
					'quantity'   => $_POST['quantity'],
					'company'    => $_POST['company']
				];

				$result = $this->codeInventoryModel->generate_codes($data);

				if($result) {
					Flash::set("Code Generated {$_POST['quantity']}");
				}

				redirect('FNCodeInventory/make_code');
			}
		}

		public function get_list()
		{
			if(!Session::check('BRANCH_MANAGERS'))
		    {
		      die("Branch Manger must be logged in");
		    }

	      	$user = Session::get('BRANCH_MANAGERS');

	      	$userid = $user->id;

			$data = [
				'codes' => $this->codeInventoryModel->get_branch_code($user->branchid),
			];

			$this->view('finance/code/get_list' , $data);
		}

		/*purchase code*/

		public function purchase_code()
		{
			if(!Session::check('BRANCH_MANAGERS')) {

				?>
			 		<h3>Branch Manager Account Must be logged in.</h3>
			 		<a href="/FNIndex/index">Return</a> |
			 		<a href="/FNManager/login">Log in as branch manager</a>
				<?php
				die();
			}

			$branchManager = Session::get('BRANCH_MANAGERS');
			$branchid = $branchManager->branchid;

			if($this->request() === 'POST')
			{
				//search code
				$searchCode = $this->codeInventoryModel->get_available_code_by_level($_POST['branchid'] , 
					$_POST['level'],$_POST['quantity']);

				if($searchCode) {

					$token = Session::set('searchToken' , seal(random_number()));

					$item_ids = "";
					foreach ($searchCode as $key => $value) {
						$item_ids .= "&codeseal[]=".$value->id;
					}
					redirect("FNCodeInventory/purchase_code/?token={$token}{$item_ids}");

				}else{
					Flash::set("Code not Found" , 'danger');

					redirect('FNCodeInventory/purchase_code');
				}

			}else{
				$data = [
					'title' => 'Purchase Code',
					'activationLevels' => $this->activation_level(),
					'inventory_summary' => [
						'starter' => $this->codeInventoryModel->get_total_code($branchid , 'starter'),
						'bronze' => $this->codeInventoryModel->get_total_code($branchid , 'bronze'),
						'silver' => $this->codeInventoryModel->get_total_code($branchid , 'silver'),
						'gold' => $this->codeInventoryModel->get_total_code($branchid , 'gold'),
						'platinum' => $this->codeInventoryModel->get_total_code($branchid , 'platinum'),
						'diamond' => $this->codeInventoryModel->get_total_code($branchid , 'diamond'),
					],
					'branchid' => $branchid
				];

				if(isset($_GET['codeseal']))
				{
					$token = $_GET['token'];

					if($token !== Session::get('searchToken')) {
						Flash::set("Token does not matched" , 'danger');

						redirect('FNCodeInventory/purchase_code');
						return;
					}

					$codeid = $_GET['codeseal'];
					$code = [];

                    for($row = 0; $row < count($codeid); $row++)
                    {

                      $value = $this->codeInventoryModel->get_code($codeid[$row]);

                      array_push($code,
                      		array($value->get_code_secret(), $value->branch_name, $value->company,
                      			  $value->get_drc_amount(), $value->get_unilevel_amount(), $value->binary_point,
                      			  $value->level, $value->max_pair, $value->get_amount(), $value->box_eq, $value->id)
                      			);
                    }

					$data = [
						'code' => $code
					];

					Session::set('searchToken' , seal(random_number()));

					//check if token is matched
					$this->view('finance/code/purchase_code_relase' , $data);
				}else{

					$codePurchaseModel = $this->model('FNCodePurchaseModel');

					$data['purchases'] =  $codePurchaseModel->get_list_by_branch($branchid);

					if($branchManager->type == 'cashier') {
						$data['purchases'] =  $codePurchaseModel->get_list_by_branch_status($branchid , 'claimed');
					}

					$this->view('finance/code/purchase_code' , $data);
				}

			}

		}


		public function purchase_code_releasing()
		{

		}

		private function activation_level()
		{
			return [
				'starter' , 'bronze' , 'silver' , 'gold' , 'platinum' , 'diamond'
			];
		}

		private function change_token(){}

	}

?>
