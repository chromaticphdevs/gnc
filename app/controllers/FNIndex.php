<?php

	class FNIndex extends Controller
	{

		public function __construct()
		{
			$this->itemInventoryModel = $this->model('FNItemInventoryModel');
			$this->itemReleaseModel = $this->model('FNProductReleaseModel');
			$this->cashInventoryModel = $this->model('FNCashInventoryModel');
			$this->branchModel = $this->model('FNBranchModel');
			$this->CashAdvanceModel = $this->model('FNCashAdvanceModel');
			$this->CallCenter = model('CallCenterModel');
		}


		public function index()
		{
			// check_access();

			$data = [
				'title' => 'Financing Module'
			];

			$auth = whoIs();
		
			$this->CallCenter->revoke_access($auth['id']);

			if(Session::check('USERSESSION'))
			{
				$branchid = Session::get('USERSESSION')['branchId'];

				$data = [
					'title' => 'Branch Management' ,
				];


				return $this->view('finance/module_selection2' , $data);
			}else{
				if($auth['type'] == "customer-service-representative")
				{
					return redirect('/DashboardCSR');
				}elseif($auth['type'] == "stock-manager")
				{
					return redirect('/FNUserSteps/all_toc_position');
				}else
				{
					return redirect('/Timekeeping');
				}
				
			}
		}
	}
?>
