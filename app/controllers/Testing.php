<?php 	

	class Testing extends Controller{

		public function index(){}

		public function commission()
		{
			
		}
		function is_decimal( $val )
		{
		    return is_numeric( $val ) && floor( $val ) != $val;
		}
		public function genBinary()
		{
			$treshold = 5;

			$pair = 0;

			$names = array();

			$root = 1;

			for($i = 1 ; $i <= $treshold ; $i++)
			{
				$level = $i;

				if($level == 1)
				{
					continue;
				}else if($level == 2)
				{
					$pair = 2;

					$index1 = $level.'|'.'1';
					$index2 = $level.'|'.'2';

					$names[$index1] = 'rootleft';
					$names[$index2] = 'rootright';
				}
				else
				{
					$prev = $pair;
					$pair *= 2; //4
					for($pair_l = 1 ; $pair_l <= $pair ; $pair_l++)
					{
						
						$index = $level.'|'.$pair_l;
						$names[$index] = 'cannot get prev id :' .($level-1);
					}
				}
			}


			var_dump_pre($names);
		}
	}