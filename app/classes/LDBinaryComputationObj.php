<?php 	

	class LDBinaryComputationObj extends BaseObj
	{
		public $totalPoints;
		public $totalPair;
		public $totalFlushout;
		public $totalDeduct;
		public $totalAmount;

		public $left_vol;
		public $right_vol;
		public $left_carry;
		public $right_carry;

		
		public function getTotalPoints()
		{
			return $this->totalPoints;
		}

		public function getTotalPair()
		{
			return $this->totalPair;
		}

		public function getTotalFlushoutPoints()
		{
			return $this->totalFlushout;
		}

		public function getTotalDeductPoints()
		{
			return $this->totalDeduct;
		}

		public function getTotalAmount()
		{
			return $this->totalAmount;
		}
	}

	