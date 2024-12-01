<?php

	class CommissionBeta extends Controller
	{

		public function start()
		{

			$binaryCommission = $this->model('Commissiontrigger_model');

			$commissions = array(
				'unilevelAmount'   => 5,
				'drcAmount'        => 100, 
				'binaryPoints'     => 100
			);

			$order_id = 1;

			$distribution = 5;

			$origin = 'sne';
			//9746
			//10879
			$purchaser = 10879;

			$binaryCommission->submit_commissions($purchaser , $commissions , $order_id , $distribution , $origin);
		}
	}