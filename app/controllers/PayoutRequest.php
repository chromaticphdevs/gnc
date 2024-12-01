<?php 	

	class PayoutRequest extends Controller
	{

		public function __construct()
		{
			$this->payout = model('PayoutRequestModel');
			$this->pera = model('BankPeraModel');
		}

		public function index()
		{
			$payouts = $this->payout->getWithMeta(null , " FIELD(status , 'pending' ,'released' , 'approved' , 'cancel') asc ");
			
			$data = [
				'payouts' => $payouts
			];

			return $this->view('payout_request/index' , $data);
		}

		public function create()
		{

		}

		public function show($id)
		{
			$payout =  $this->payout->getMeta($id);

			$pera   = $this->pera->getByUser($payout->userId);

			$data = [
				'payout' => $payout,
				'pera'   => $pera
			];

			return $this->view('payout_request/show' , $data);
		}
	}