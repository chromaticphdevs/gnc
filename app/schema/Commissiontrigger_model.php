<?php

	require_once(APPROOT.DS.'classes/UserBinaryPV.php');
	require_once(FNCTNS.DS.'crawler.php');
	/*
		truncate binary_pv_commissions;
		truncate binary_pvs;
		truncate binary_pv_pair_counter;;
		truncate binary_pv_pair_deduction;
	*/
	class Commissiontrigger_model extends Base_model
	{

		private $binary_pv = 'binary_pvs' ,
		$binary_pv_counter = 'binary_pv_counter',
		$binary_pv_pair_commission = 'binary_pv_commissions',
		$binary_pv_pair_deduction  = 'binary_pv_pair_deduction';


		public function __construct()
		{
			parent::__construct();

			$this->mentorModel = new MentorCommissionModel();

			$this->binaryFlushoutModel = new BinaryFlushoutModel();
		}
		//$user_id , $commissions , $order_id
		public function submit_commissions($purchaser , $commission , 
			$order_id , $distribution , $origin)
		{
			/*start switch*/
			$uplineSwitch = new UplineSwitchModel();

			$purchaserUpline = $uplineSwitch->get_upline($purchaser);

			/*check if upline is not activated*/
			if(!$uplineSwitch->upline_activated($purchaserUpline))
			{
				/*switch upline upline is not activated*/
				$uplineSwitch->make_switch($purchaserUpline->id , $purchaser);
			}

			$this->sponsors  = crawler_drc($purchaser);

			$this->uplines   = crawler_upline($purchaser);

			$directSponsorParameters = [
				$purchaser ,$order_id ,
				$commission['unilevelAmount'] , 
				$commission['drcAmount'] , 
				$distribution , $origin
			];

			$binaryCommissionParameters = [
				$order_id , $purchaser , 
				$commission['binaryPoints'] ,$origin
			];

			$res1 = $this->add_direct_sponsors_commissions(...$directSponsorParameters);
			$res2 = $this->add_binary_commissions(...$binaryCommissionParameters);

			if($res1 && $res2) {
				return true;
			}else{
				return false;
			}
		}

		private function add_direct_sponsors_commissions($purchaser,
		$order_id, $unilvl , $drc , $distribution , $origin)
		{

			$sponsors = $this->sponsors;
			$instance = 0;

			try{
				foreach($sponsors as $key => $sponsor) 
				{
					$sponsorid = $sponsor->id;
					$maxpair   = $sponsor->max_pair;
					if($maxpair != 0  && $sponsorid != 0) 
					{
						/*direct sponky*/
						if($key == 0) {

							$data = [
								$sponsorid ,
								$purchaser,
								'DRC',
								$drc,
								$origin
							];

							CommissionTransactionModel::make_commission(...$data);

							$mentor = [
								$order_id , $purchaser, 
								$sponsorid , $drc,
								$origin
							];

							$this->mentorModel->make_commission(...$mentor);
						}

						if($unilvl > 0) {
							/*unilevel dough*/
							$data = [
								$sponsorid ,
								$purchaser,
								'UNILEVEL',
								$unilvl,
								$origin
							];

							CommissionTransactionModel::make_commission(...$data);
						}
						
					}
				}

				return true;
			}catch(Exception $e) {

				die($e->getMessage());
				return false;
			}
		}
		/*
		*@param
		*purchaser
		*IP incomming-points
		*/


		public function add_binary_commissions($orderid , $purchaser , $points , $origin)
		{
			$uplines = crawler_upline($purchaser);

			$loop_counter = 0;

			try{

				if(!empty($uplines))
				{
					foreach($uplines as $upline)
					{

						if($upline->max_pair <= 0) {
							continue;
						}

						$userid        = $upline->id;
						$position      = $upline->downlinePosition;
						$maxpair       = $upline->max_pair;

						$binaryPointObj  = new BinaryPointObj($points , $position);

						$userBinaryModel = new UserBinaryModel($userid);

						$recentTransaction = $userBinaryModel->get_recent_transaction();
						/*check if reached maxpair*/
						if($maxpair > $userBinaryModel->get_pair()) {
							//getUsersPrevious-Transactions
							$computeBinary = new BinaryComputationObj();

							if($recentTransaction) {

								$newTransaction = $userBinaryModel->save_transactions(
									$recentTransaction->left_vol,
									$recentTransaction->right_vol,
									$binaryPointObj,
									$maxpair
								);

								/*transaction has commission*/
								if($newTransaction['amount']) {
									$commission = [
										$userid, 
										$purchaser, 
										'BINARY' , 
										$newTransaction['amount'] , 
										$origin
									];

									CommissionTransactionModel::make_commission(...$commission);
									
									/*insert pair counter*/
									$this->insert_pair_counter(0, $newTransaction['pair'] , $userid);
								}
							}else{

								$data = [
									$leftVol  = strtolower($position) == 'left'  ? $points : 0 ,
									$rightVol = strtolower($position) == 'right' ? $points : 0 ,
									$amount   = 0,
									$pair     = 0
								];

								$userBinaryModel->first_transaction(
									... $data
								);

							}
							
						}else{
							if($recentTransaction) {
								if($recentTransaction->pair != 0) {
									$userBinaryModel->save_flushout();
								}/*do nothing kase na flush out na*/
								/*throw flush out*/
							}
							
						}
					}// end for loop
				}// end upline empty check

				return true;
			}catch(Exception $e) {

				die(var_dump($e->getMessage()));
				return false;
			}
		}

		private function insert_pair_counter($binary_pv_com_id , $pair , $user_id)
		{
			if( $pair != 0)
			{
				$this->db->query(
					"INSERT INTO binary_pv_pair_counter(pair , binary_pv_com_id , user_id)
					 VALUES(:pair , :binary_pv_com_id , :user_id)"
				);

				$this->db->bind(':pair' , $pair);
				$this->db->bind(':binary_pv_com_id' , $binary_pv_com_id);
				$this->db->bind(':user_id' , $user_id);

				$this->db->execute();
			}

		}
	}
