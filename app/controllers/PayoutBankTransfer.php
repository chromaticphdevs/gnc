<?php 	
	class PayoutBankTransfer extends Controller
	{

        public function __construct()
        {
        	$this->payout = model('PayoutRequestModel');
        }

		public function transferToPeraMultiple()
		{
			$posts = request()->inputs();

			$payouts = $posts['payouts'];

			$warnings = [];

			foreach($payouts as $key => $payout)
			{
				$payoutRequestId = unseal($payout);

				$response = $this->payout->moveRequesToPeraBank($payoutRequestId);

				if(!$response) {
					$warnings[] = $this->payout->error;
				}
			}

			if(!empty($warnings)) 
			{	
				$html = '';

				foreach($warnings as $warning) {
					$html .= "<p> {$warning} </p>";
				}
				Flash::set( $html , 'info');
			}else{
				Flash::set(" Transfer successfull ");
			}

			return request()->return();
		}

		public function transfer_money()
		{
			$post = request()->inputs();			/**
			 * Payour request id
			 */
			$payoutRequestId = $post['id'];

			$payoutRequestResponse = $this->payout->moveRequesToPeraBank($payoutRequestId);

			if($payoutRequestResponse){
				Flash::set("Payout transfered to Pera-E successful");
			}else{
				Flash::set($this->payout->error , 'danger');
				Flash::set( implode(',',$this->payout->errors) , 'warning');
			}
			
			return request()->return();
		}


		private function fireError($error)
		{
			Flash::set($error , 'danger');

			return request()->return();
		}
	}