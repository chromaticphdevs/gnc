<?php 	

	class LDCashAutoLoanObj
	{
		public function generate_cash_loan()
		{
			$multiply = 8;

			$base = 5000;

			$loanAmountList = [];

			for($i = 0 ; $i < 8 ; $i++)
			{
				if($i == 0) {
					array_push($loanAmountList, $base);
				}
				$base *= 2;
				/*if($base == 1280000)
				{
					array_push($loanAmountList, 10240000);
				}*/
				array_push($loanAmountList, $base);
			}

			return $loanAmountList;
		}
	}

?>