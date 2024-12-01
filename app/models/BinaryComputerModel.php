<?php 	

	class BinaryComputerModel extends Base_model
	{

		public function set_max_pair($maxPair)
		{
			$this->maxPair = $maxPair;
		}

		public function set_current_pair($currentPair)
		{
			$this->currentPair = $currentPair;
		}

		public function get_currnet_pair()
		{
			return $this->currentPair;
		}

		public function set_points($points  , $position) 
		{
			if($position == 'left') {
				$this->leftpoint = $points;
			}

			if($position == 'right') {
				$this->rightpoint = $points;
			}
		}

		public function set_incomming_points($points , $position)
		{

			$this->incommingPoints = [
				$points , $position
			];
		}

		/*check if the user has reached max pair*/
		public function reachedMaxPair()
		{
			$maxPair     = $this->maxPair;
			$currentPair = $this->currentPair;

			//pag si max pair mas malaki kay current pair edi reached maxed na
			if($currentPair >= $maxPair && $currentPair != 0){
				return true;
			}else{
				return false;
			}
		}


		public function make_computation()
		{
			list($points , $position) = $this->incommingPoints;

			$leftpoint   = $this->leftpoint;
			$rightpoint  = $this->rightpoint;

			if(strtolower($position) == 'left') {
				$leftpoint += $points;
			}

			if(strtolower($position) == 'right') {
				$rightpoint += $points;
			}

			$this->compute_points($leftpoint , $rightpoint);
		}
		public function hasCommission()
		{
			if(isset($this->commission)) {
				return true;
			}return false;
		}


		private function compute_points($leftpoint , $rightpoint)
		{
			$treshold = 100;

			//get lowest
			if($leftpoint > $rightpoint) {
				$lowest = [
					'position' => 'right' ,
					'points'   => $rightpoint
				];
			}else{
				$lowest = [
					'position' => 'left' ,
					'points'   => $leftpoint
				];
			}

			if($lowest['points'] >= 100) {
				
				//check
				$pair        = abs($lowest['points'] / 100);

				$maxPair     = $this->maxPair;
				$currentPair = $this->currentPair;
				

				$remainingPair = $maxPair - $currentPair;//3 //7
				//check if pair overspilled;
				if($remainingPair > $pair) 
				{
					/*initiate commission*/
					$commission = $pair * 100;
					$leftcarry  = $leftpoint  - $commission;
					$rightcarry = $rightpoint - $commission;

					$this->setCommission($leftpoint , $rightpoint , $leftcarry , $rightcarry , 
						$commission , $pair);
				}else{
					/*initiate flushout*/

					$pair       = $pair - $remainingPair;
					//flushed out points
					$points     = $lowest['points'] - ($pair * 100);//points thal will be flushed out

					$commission = $remainingPair * 100;
					$leftcarry  = $leftpoint  - $commission;
					$rightcarry = $rightpoint - $commission;

					$this->setCommission($leftpoint , $rightpoint , $leftcarry , $rightcarry , 
						$commission , $remainingPair);

					$this->setFlushOut($points , $lowest['position']);
				}
			}else{
			}
		}

		private function setCommission($leftpoint , $rightpoint , 
			$leftcarry , $rightcarry , $amount , $pair)
		{
			$this->commission = [
				'leftpoint'  => $leftpoint,
				'rightpoint' => $rightpoint,
				'leftcarry'  => $leftcarry,
				'rightcarry' => $rightcarry,
				'amount'     => $amount,
				'pair'       => $pair
			];
		}


		public function get_points($position)
		{
			if($position == 'left') {
				return $this->commission['leftpoint'];
			}
			if($position == 'right') {
				return $this->commission['rightpoint'];
			}
		}


		public function get_carry($position)
		{
			if($position == 'left') {
				return $this->commission['leftcarry'];
			}
			if($position == 'right') {
				return $this->commission['rightcarry'];
			}
		}

		public function get_amount(){
			return $this->commission['amount'];
		}

		public function get_pair(){
			return $this->commission['pair'];
		}
		private function setFlushOut($points , $position)
		{
			$this->flushout = [
				$points,
				$position
			];
		}

		public function hasFlushOut()
		{	
			/*check if property flushout is set*/
			if(isset($this->flushout))
				return true;
			return false;
		}

		public function getFlushOut()
		{
			return $this->flushout;
		}

	}