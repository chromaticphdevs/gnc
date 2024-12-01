<?php 	
	
	class CSR_PayoutRequest extends Controller
	{

		public function __construct()
		{
			$this->model = model('PayoutRequestModel');
		}

		public function make_request()
		{
			$q = $_POST;

			$whoIs = whoIs();

			$params = [
				$whoIs['id'],
				$whoIs['whoIs'],
				$q['amount']
			];

			$res = $this->model->timesheetEarningRequest(
				...$params
			);

			Flash::set("Your csr income has been sent to your pera-e account");
				if(!$res)
					Flash::set( $this->model->getErrorString() , 'danger');

			return request()->return();
		}
	}