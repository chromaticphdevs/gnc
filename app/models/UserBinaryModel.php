<?php 	
	
	class UserBinaryModel extends Base_model
	{

		public $table_name = 'binary_transactions';
		public $table = 'binary_transactions';

		public function __construct($userid)
		{
			parent::__construct();

			$this->userid = $userid;
			$this->binaryComputationObj = new BinaryComputationObj();
		}

		public function get_left_vol()
		{
			$userid = $this->userid;

			$this->db->query("SELECT left_vol as totalVol
				FROM $this->table_name 
				WHERE userid = '$userid'
				ORDER BY id desc");

			return $this->db->single()->totalVol ?? 0;
		}

		public function get_right_vol()
		{
			$userid = $this->userid;

			$this->db->query("SELECT right_vol as totalVol
				FROM $this->table_name 
				WHERE userid = '$userid'
				ORDER BY id desc");
			
			return $this->db->single()->totalVol ?? 0;
		}

		public function get_right_carry()
		{
			$userid = $this->userid;

			$this->db->query("SELECT right_carry as totalCarry
				FROM $this->table_name 
				WHERE userid = '$userid'
				ORDER BY id desc");
	
			return $this->db->single()->totalCarry ?? 0;
		}

		public function get_left_carry()
		{
			$userid = $this->userid;

			$this->db->query("SELECT left_carry as totalCarry
				FROM $this->table_name 
				WHERE userid = '$userid'
				ORDER BY id desc");
			
			return $this->db->single()->totalCarry ?? 0;
		}

		/*TEMPORARY*/

		
		public function get_pair()
		{
			$userid = $this->userid;
			//get from database binary_pv_pair_counter
			$this->db->query("SELECT ifnull(sum(pair) ,0) as totalPair 
				FROM binary_pv_pair_counter 
				WHERE date(dt) = date(now()) and user_id = '$userid'");

			return $this->db->single()->totalPair ?? 0;
		}

		public function get_pair_total()
		{
			$userid = $this->userid;

			$this->db->query(
				"SELECT ifnull(sum(pair) , 0) as totalPair
					FROM binary_pv_pair_counter
					WHERE user_id = '$userid'"
			);

			return 
				$this->db->single()->totalPair ?? 0;
		}

		public function get_total_amount()
		{
			$userid = $this->userid;

			$this->db->query("SELECT sum(amount) as totalAmount
				FROM $this->table_name 
				WHERE userid = '$userid'");
			
			return $this->db->single()->totalAmount ?? 0;
		}

		public function save_flushout()
		{
			$userid = $this->userid;

			$data = [
				$this->table_name, 
				[
					'userid' => $userid,
					'left_vol' => 0,
					'right_vol' => 0,
					'left_carry' => 0,
					'right_carry'=>0,
					'amount' => 0,
					'pair' => 0,
					'description' => "Your binaries have been flushed"
				]
			];

			return $this->dbHelper->insert(...$data);
		}

		public function save_transactions(BinaryPointObj $binaryPoint , $maxpair)
		{
			$userid = $this->userid;
			$currentPair = $this->get_pair();

			$giftCert = new GiftCertificateModel();
			/*binary computation*/
			$recentTransaction = $this->get_recent_transaction($userid);
			/*get previous transaction*/

			$description = '';

			$binaryCompute = $this->binaryComputationObj;

			$binaryCompute->add_point($binaryPoint->get_point() , $binaryPoint->get_position())
			->set_left($recentTransaction->left_carry)
			->set_right($recentTransaction->right_carry)
			->compute();
			

			if($binaryCompute->get_pair() > 0) 
			{
				$validPair = $maxpair - $currentPair;//10 valid pair//

				if($validPair > $binaryCompute->get_pair()){
					$validPair = $binaryCompute->get_pair();
				}

				/*if computed pair or incomming pair is greated than valid pair then cut the incomming pair to valid to get the flushed out points*/

				$flushedPair = $binaryCompute->get_pair() > $validPair ? $binaryCompute->get_pair() - $validPair : 0;

				$totalPair = $validPair + $this->get_pair_total();//0

				$totalGiftCheque = $giftCert->get_total($userid);//0

				$giftCheque = ($totalPair - ($totalGiftCheque * 3));//0
				/*instanciate if has gc values*/
				$gcQuantity = 0;//

				$deductCommissionAmount = 0;//

				if($giftCheque >= 3) {
					/*gift check quantity*/
					$gcQuantity = floor($giftCheque / 3);//1
					/*create gift  certificate*/
					$giftCert->make_giftcert($userid , $gcQuantity , 100);
					/*Multiply $deductCommissionAmount to quantity of the giftcheck*/
					$deductCommissionAmount = $gcQuantity * 100;
					/*deduct on binary*/
				}

				$pair          = $validPair;
				$amountEarned  = ($pair * 100) - $deductCommissionAmount;
				$flushedAmount = $flushedPair  * 100;

				/*refresh binary computation*/

				$binaryCompute->add_point($binaryPoint->get_point() , $binaryPoint->get_position())
				->set_left($recentTransaction->left_carry)
				->set_right($recentTransaction->right_carry)
				->compute();

				$leftVol       = $binaryCompute->get_left_vol() - $amountEarned;
				$rightVol      = $binaryCompute->get_left_vol() - $amountEarned;
				$leftCarry     = $binaryCompute->get_left_carry() - $amountEarned;
				$rightCarry    = $binaryCompute->get_right_carry() - $amountEarned;

				$description = '';

				if($flushedAmount > 0 ) {
					$description .= " |Amount has been flushed {$flushedAmount}| ";
				}

				if($amountEarned > 0){
					$description .= " |You have earned {$amountEarned}| ";
				}

				if($giftCheque > 0){
					$description .= " |{$deductCommissionAmount} Pesos binary income has been converted to {$gcQuantity} Gift Cheque| ";
				}

				$description .= " |Leg Movement {$binaryPoint->get_position()} increased by {$binaryPoint->get_point()}| ";

				$data = [
					$this->table_name,
					[
						'userid'      => $userid,
						'left_vol'    => $binaryCompute->get_left_vol(),
						'right_vol'   => $binaryCompute->get_right_vol(),
						'left_carry'  => $binaryCompute->get_left_carry(),
						'right_carry' => $binaryCompute->get_right_carry(),
						'pair'        => $pair,
						'amount'      => $amountEarned,
						'description' => $description
					]
				];

				try{

					$this->dbHelper->insert(...$data);

					if($flushedAmount > 0 ) {
						$this->save_flushout();
					}

					return $data[1];
					
				}catch(Exception $e) {
					die($e->getMessage());
				}
			}else{

				$data = [
					$this->table_name,
					[
						'userid'      => $userid,
						'left_vol'    => $binaryCompute->get_left_vol(),
						'right_vol'   => $binaryCompute->get_right_vol(),
						'left_carry'  => $binaryCompute->get_left_carry(),
						'right_carry' => $binaryCompute->get_right_carry(),
						'pair'        => $binaryCompute->get_pair(),
						'amount'      => $binaryCompute->get_amount(),
						'description' => "Leg Movement {$binaryPoint->get_position()} increased by {$binaryPoint->get_point()}"
					]
				];

				try{

					$this->dbHelper->insert(...$data);
					return $data[1];
					
				}catch(Exception $e) {
					die($e->getMessage());
				}

			}
			

			return true;
		}


		public function first_transaction($leftVol , $rightVol , 
			$amount , $pair)
		{
			$userid = $this->userid;

			$binaryCompute = $this->binaryComputationObj;

			$binaryCompute->set_left($leftVol)
			->set_right($rightVol)
			->compute();

			$data = [
				$this->table_name,
				[
					'userid'      => $userid,
					'left_vol'    => $leftVol,
					'right_vol'   => $rightVol,
					'left_carry'  => $binaryCompute->get_left_carry(),
					'right_carry' => $binaryCompute->get_right_carry(),
					'pair'        => $pair,
					'amount'      => $amount,
					'description' => "Your First Binary Transaction! Php: {$amount}"
				]
			];

			try{
				return 	
					$this->dbHelper->insert(...$data);

			}catch(Exception $e) {
				die($e->getMessage());
			}
			
		}

		public function get_total_transactions()
		{
			$userid = $this->userid;

			$this->db->query("SELECT count(id) from $this->table_name 
				where userid = '$userid'");

			return $this->db->single()->total_transaction ?? 0;
		}
		

		public function get_recent_transaction()
		{
			$userid = $this->userid;

			$sql = "SELECT * FROM $this->table_name
				WHERE userid = '$userid' order by id desc";

			$this->db->query($sql);

			return $this->db->single();
		}

		public function get_list()
		{
			$userid = $this->userid;

			$sql = "SELECT * FROM $this->table_name
				WHERE userid = '$userid' order by created_at desc";

			$this->db->query($sql);

			return $this->db->resultSet();
		}	
	}