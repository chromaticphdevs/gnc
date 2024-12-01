<?php 

	class TocProductLoan extends Controller
	{

		public function __construct()
		{
			$this->model = model('TocProductLoanModel');
			$this->toc = model('TOCModel'); 
		}

		/*
		*create a loan
		*move order to shipment
		*/
		public function loan()
		{
			$q = request()->inputs();

			$paramData = [
				'codeId' => $q['code_id'],
				'amount' => $q['amount'],
				'quantity' => $q['quantity'],
				'delivery_fee' => $q['delivery_fee'],
				'shipping_details' => $q['shipping_details'],
				'user_id' => $q['user_id'],
				'shipping_track_number' => $q['shipping_track_number']
			];

			$res = $this->model->loan($paramData);
			$this->toc->updateLoanId($q['user_id'], $this->model->autoloan['loanId']);

			if($res) {
				Flash::set("Loan Created! : Loan Tracking #{$this->model->reference} Shipping Tracking#{$this->model->productDeliveryModel->reference} ");
			}

			return request()->return();
		}


		public function addToDelivery()
		{
			$q = request()->inputs();

			$res = $this->model->save_shiping_number( $q['user_id'] , $q['shipping_track_number'] , $q['loan_id'] );

			$this->model->fnproductReleaseModel->dbupdate([
				'shipment_status' => 'delivered'
			] , $q['loan_id']);
			
			Flash::set("Added to delivery");

			return request()->return();
		}
	}