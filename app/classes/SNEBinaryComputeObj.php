<?php 	

	class SNEBinaryComputeObj
	{

		public function set_incomming_points($points , $position)
		{
			$this->incommingPoints[
				'points'   => $points ,
				'position' => $position
			];

			return $this;
		}
		public function set_points($left , $right)
		{
			$this->left  = $left;
			$this->right = $right;

			return $this;
		}

		public function set_current_pair($curPair)
		{
			$this->curPair = $curPair;
		}

		public function set_max_pair($maxPair)
		{
			$this->maxPair = $maxPair;

			return $this;
		}

		/*proccess mehtods*/
		/*get pair*/
		private function combine_points()
		{
			$incommingPoints = $this->incommingPoints;

			$left   = $this->left;
			$right  = $this->right;
			/*if the position is left then add to left*/
			if(strtolower($incommingPoints['position']) === 'left'){
				$left += $incommingPoints['points'];
			}

			return [
				$left , $right
			];
		}

		private function compute_points()
		{
			$settings = 100;

			list ($left , $right) = $this->combine_points();

			//check who is lesser;
			$lesserPoints = $left < $right ? $left : $right;

			$pairCounter   = 0;
			//if reached 100 then test if can pair
			if($lesserPoints >= $settings) {

				try{
					$pairCounter = abs($lesserPoints  / 100);

					return [
						$left  = $left  -($pairCounter * 100),
						$right = $right -($pairCounter * 100),
						$pairCounter,
						$pairCounter * 100
					];

				}catch(Excetion $e) 
				{
					die($e->getMessage());
				}
			}else{

				return [
					$left , 
					$right ,
					0,
					0
				];
			}
		}
		/*computations*/

		public function reachedMaxPair()
		{
			$curPair = $this->curPair;
			$maxPair = $this->maxPair;

			if($curPair >= $maxPair) 
				return true;
			return false;
		}

		public function isOverPair()
		{
			list($left , $right , $pairs , $amount) = $this->compute_points();

			$maxPair = $this->maxPair;
			$curPair = $this->curPair;

			if(($maxPair - $curPair) < $pairs)

				$this->overPair = $pairs - ($maxPair - $curPair);

				return true;
			return false;
		}


		public function getComputation()
		{
			list($left , $right , $pairs , $amount) = $this->compute_points();

			$this->leftcarry = $left;

			$this->rightcarry = $right;

			$this->pair = $pairs;

			$this->amount = $amount;
		}

		public function getOverPair()
		{
			return $this->overPair;
		}
		
		public function getPoints($position)
		{
			if($position == 'left') {
				return $this->left;
			}

			if($position == 'right'){
				return $this->right;
			}
		}

		public function getCarry($position)
		{
			if($position == 'left') {
				return $this->leftcarry;
			}

			if($position == 'right'){
				return $this->rightcarry;
			}
		}

		public function getAmount()
		{
			return $this->amount;
		}

		public function getPair()
		{
			return $this->pair;
		}
	}