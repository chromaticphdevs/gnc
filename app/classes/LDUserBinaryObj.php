<?php 	

class LDUserBinaryObj extends BaseObj
{
	public $id , $username;

	public $sponsor , $upline , $downline , $position , $downlinePosition;

	public $type, $accountLevel;

	public $maxPair , $currentPair , $max_pair; 

	public $left , $right;

	public function isReachedLimitDailyPair()
	{
		$maxPair      = $this->maxPair;
		$currentPair  = $this->currentPair;

		if($maxPair == $currentPair)
			return true;
		return false;
	}


	public function computeIncommingPoints($incommingPoints)
	{
		return $this->binaryUpdated($incommingPoints);
	}

	public function binaryUpdated($incommingPoints)
	{

		$position = $incommingPoints['position'];
		$points   = $incommingPoints['points'];

		$left  = $this->left; //550
		$right = $this->right;//000

		if(strtolower($position) == 'left') 
		{
			$left += $points; 
		}else if(strtolower($position) =='right'){
			$right += $points; //300
		}else{
			die("{$position}");
		}

		$pairtreshold  = 100;

		$maxPair       = $this->maxPair;

		$currentPair   = $this->currentPair;

		$remainingPair = $maxPair - $currentPair;

		$totalPair     = $this->computePair($this->getBinaryVolume($pairtreshold , $left) , 
						 $this->getBinaryVolume($pairtreshold , $right));
		
		$binary        = new LDBinaryComputationObj();

		//initialize mergedPoints
		$mergedPoints;

		//set total points
		if($position == 'left'){
			$mergedPoints = $left;
		}else{
			$mergedPoints = $right;
		}

		if($totalPair != 0) 
		{

			if($remainingPair <= $totalPair) 
			{
				$totalPair          = $remainingPair;
				$totalPoints        = $remainingPair * $pairtreshold;
				$totalFlushout      = $points - ($remainingPair * $pairtreshold);
				$totalAmount        = $totalPoints ;
				$totalDeduct        = $totalPoints * (-1);

				$left_vol          = $left;
				$right_vol         = $right;
				$left_carry        = $left_vol  - $totalPoints;
				$right_carry       = $right_vol - $totalPoints;

				$binary->set_prop('totalPair' , $totalPair);
				$binary->set_prop('totalPoints' , $totalPoints);
				$binary->set_prop('totalFlushout' , $totalFlushout);
				$binary->set_prop('totalAmount' , $totalAmount);
				$binary->set_prop('totalDeduct' , $totalDeduct);

				$binary->set_prop('left_vol' , $left_vol);
				$binary->set_prop('right_vol' , $right_vol);
				$binary->set_prop('left_carry' , $left_carry);
				$binary->set_prop('right_carry' , $right_carry);
				

			}else{

				$totalPair     = $totalPair;
				$totalPoints   = $points;
				$totalFlushout = 0;
				$totalAmount   = $totalPair * $pairtreshold;
				$totalDeduct   = $totalAmount * (-1);

				$left_vol          = $left;
				$right_vol         = $right;
				$left_carry        = $left_vol  - $totalPoints;
				$right_carry       = $right_vol - $totalPoints;

				$binary->set_prop('totalPair' , $totalPair);
				$binary->set_prop('totalPoints' , $totalPoints);
				$binary->set_prop('totalFlushout' , $totalFlushout);
				$binary->set_prop('totalAmount' , $totalAmount);
				$binary->set_prop('totalDeduct' , $totalDeduct);

				$binary->set_prop('left_vol' , $left_vol);
				$binary->set_prop('right_vol' , $right_vol);
				$binary->set_prop('left_carry' , $left_carry);
				$binary->set_prop('right_carry' , $right_carry);


			}
		}else{
			//no pair
			/*total pair will remain the same*/
			$totalPair     = 0;
			$totalPoints   = $points;
			$totalFlushout = 0;
			$totalAmount   = 0;
			$totalDeduct   = 0;

			$left_vol          = $left;
			$right_vol         = $right;
			$left_carry        = $left_vol;
			$right_carry       = $right_vol;
			
			$binary->set_prop('totalPair' , $totalPair);
			$binary->set_prop('totalPoints' , $totalPoints);
			$binary->set_prop('totalFlushout' , $totalFlushout);
			$binary->set_prop('totalAmount' , $totalAmount);
			$binary->set_prop('totalDeduct' , $totalDeduct);

			$binary->set_prop('left_vol' , $left_vol);
			$binary->set_prop('right_vol' , $right_vol);
			$binary->set_prop('left_carry' , $left_carry);
			$binary->set_prop('right_carry' , $right_carry);
			

		}


		return $binary;	
	}
	
	public function getIncomingPair($left , $right)
	{
		$pairtreshold = 100;

		$left  = $this->get_volume_count($pairtreshold , $left);
		$right = $this->get_volume_count($pairtreshold , $right);
	}

	private function getBinaryVolume($pairtreshold , $points)
	{
		if($points >= $pairtreshold)
			return floor($points / $pairtreshold);
		return 0;
	}

	public function computePair($left , $right) 
	{
		return $left >= $right ? $right : $left;
	}
}