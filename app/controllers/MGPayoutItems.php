<?php 	

	class MGPayoutItems extends Controller
	{

		public function __construct()
		{
			$this->payoutModel    = $this->model('MGPayoutModel');
			$this->payoutItemModel = $this->model('MGPayoutItemModel');

			
		}
		public function get_list($payoutid)
		{

			$data = [
				'payout' => [
					'details'  => $this->payoutModel->get_payout($payoutid),
					'itemList' => $this->payoutItemModel->get_list($payoutid)
				],

				'payoutid' => $payoutid
			];

			$this->view('mgpayout/item_list' , $data);
		}
	}