<?php 

	class BinaryComputationObj
	{

		public static $binaryTreshold = 100;


		public function add_point($point , $position) 
		{	
			if(strtolower($position) == 'left') {
				$this->toAddPointLeft = $point;
			}

			if(strtolower($position) == 'right') {
				$this->toAddPointRight = $point;
			}

			return $this;
			
		}
		public function set_left($vol = 0)
		{
			$this->leftVol = $vol;
			return $this;
		}

		public function set_right($vol = 0)
		{
			$this->rightVol = $vol;
			return $this;
		}

		public function compute()
		{
			$leftVol  = $this->leftVol  + $this->getToAdd('left');
			$rightVol = $this->rightVol + $this->getToAdd('right');
			/*get lowest vol*/
			$lowest = $leftVol > $rightVol ? $rightVol : $leftVol;

			if($lowest >= self::$binaryTreshold) {
				/*make computation*/
				$pair       = floor($lowest / self::$binaryTreshold);
				$amount     = $pair * self::$binaryTreshold; //100 is the binary treshhold

				$leftCarry  = $leftVol  - $amount;
				$rightCarry = $rightVol - $amount;

				$returnValue = [
					$leftVol , 
					$rightVol,
					$leftCarry,
					$rightCarry,
					$pair,
					$amount
				];

				$this->setReturnValues(...$returnValue);
			}else{
				/*TRIGGER WHEN NO COMMISSION IS AVAILABLE*/
				$leftCarry  = $leftVol;
				$rightCarry = $rightVol;
				$pair    = 0;
				$amount  = 0;

				$returnValue = [
					$leftVol , 
					$rightVol,
					$leftCarry,
					$rightCarry,
					$pair,
					$amount
				];

				$this->setReturnValues(...$returnValue);
			}

		}

		public function setReturnValues($leftVol , $rightVol , $leftCarry , 
			$rightCarry , $pair , $amount) 
		{
			$this->leftVol    = $leftVol;
			$this->rightVol   = $rightVol;
			$this->leftCarry  = $leftCarry;
			$this->rightCarry = $rightCarry;
			$this->pair       = $pair;
			$this->amount     = $amount;
		}

		private function getToAdd($position) {

			if($position == 'left') {
				return $this->toAddPointLeft ?? 0;	
			}
			return $this->toAddPointRight ?? 0;
		}

		public function get_left_vol()
		{
			return $this->leftVol;
		}

		public function get_right_vol()
		{
			return $this->rightVol;
		}

		public function get_left_carry()
		{
			return $this->leftCarry;
		}

		public function get_right_carry()
		{
			return $this->rightCarry;
		}

		public function get_pair()
		{
			return $this->pair;
		}

		public function get_amount()
		{
			return $this->amount;
		}

	}