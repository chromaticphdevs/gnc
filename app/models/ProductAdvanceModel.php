<?php

	class ProductAdvanceModel extends Base_model
	{
		private $table_name = 'single_box_advances';

		public function single_box_loan($userid , $branchid , $addtionalBoxes)
		{
			$currentRequest = $this->get_unpaid_boxes($userid);

			if(!empty($currentRequest))
			{
				if(count($currentRequest) > 0) {
					Flash::set("Pay all product loan first before loaning again");
					return false;
				}
			}
 
			$code = $this->make_code();

			$make_query = "
				INSERT INTO $this->table_name(userid , branchid , amount , code , status)
				VALUES('$userid' , '$branchid' , 260 , '$code' , 'pending');";

			if($addtionalBoxes > 0)
			{
				for($i = 0 ; $i < $addtionalBoxes ; $i++)
				{
					$code = $this->make_code();
					$make_query .= "
					INSERT INTO $this->table_name(userid ,branchid ,amount , code , status)
					VALUES('$userid' ,'$branchid' , 260 , '$code' , 'pending');";
				}
			}

			try{
				$this->db->query($make_query);
				$this->db->execute();
				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
			}
		}

		private function make_code()
		{
			/*$prefix = random_number(2);
			$middle = random_number(4);
			$suffix = random_number(3);
			return "{$prefix}-{$middle}-{$suffix}";*/

		    $day = date("d");
			$month = date("m");
			$year = date("Y");
			$suffix = random_number(3);

		    return "P{$day}{$month}{$year}-{$suffix}";
		}


		public function get_list($userid)
		{
			$this->db->query(
				"SELECT pd.* , branch_name
					FROM $this->table_name as pd

					LEFT JOIN ld_branch on
					ld_branch.id = pd.branchid

					WHERE userid = '$userid'
					ORDER BY pd.id "
			);

			//return $this->db->resultSet();


			$result = $this->db->resultSet();

			
			foreach($result as $key => $row)
			{

 				++$key;

				if($key % 4 == 0){

					if($row->status == "paid")
					{
							
						$this->db->query(
							"SELECT * FROM `user_activations` WHERE userId = '$userid' AND single_product_code = '$row->code' AND position = '$key'"
						);

						$check_code = $this->db->single();	

						if(empty($check_code))
						{
							$activation_code = $this->auto_get_code($row->branchid);


							if(!empty($activation_code))
							{

								$this->db->query(
											"INSERT INTO `user_activations`( `activation_code`, `position`, `single_product_code`, `userId`, `note`) VALUES ('$activation_code', '$key', '$row->code', '$userid', 'ok')"
										);
		
							    $this->db->execute();

							}

						}

					}	 	

				}     		

			}


			return $result;
             
		}

		public function auto_get_code($branch_id)
		{


			$this->db->query(
					"SELECT * FROM `ld_activation_code` WHERE branch_id='$branch_id' and activation_level='starter' and status='Unused' and status2='Unsold' LIMIT 1 "
			);

			$result = $this->db->single();

			if(!empty($result)){

				$activation_code = $result->activation_code;

				//get date today
				date_default_timezone_set('Asia/Manila');
				$date = date('Y-m-d') ;

				//add 2 days at date today for expiration date
				$date = date_create($date);
				date_add($date,date_interval_create_from_date_string("2 days"));
				$date = date_format($date,"Y-m-d");

				$note_data = "auto get code if user has 4 or more single product";

				$this->db->query(
					"UPDATE ld_activation_code SET status2 = 'sold', `expiration_date`='$date', note = '$note_data' WHERE activation_code = '$activation_code'"
				);

				$this->db->execute();

				return $activation_code;
			}
		}


		public function get_unpaid_boxes($userid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name
					WHERE userid = '$userid'
					and status !='paid' order by status desc"
			);

			return $this->db->resultSet();
		}

		public function get_user_activations($userid)
		{
			$this->db->query(
				"SELECT activation_code, position, single_product_code, 
				
				(SELECT status FROM ld_activation_code WHERE activation_code = user_activations.activation_code) as code_status

				 FROM `user_activations` WHERE userId = '$userid'"
			);


			return $this->db->resultSet();
		}

		public function get_list_by_status($status)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name
					where status = '$status'"
			);

			return $this->db->resultSet();
		}
		
		public function get_total_paid_boxes($userid)
		{
			$this->db->query(
				"SELECT count(id) as total_borrow
					FROM $this->table_name
						WHERE userid = '$userid' and status = 'paid'"
			);
			$result = $this->db->single();

			if(!empty($result)){
				return $result->total_borrow;
			}
			return 0;
		}

		public function get_addition_boxes($borrow)
		{
			$addtionalBoxes = 0;
			try{
				$addtionalBoxes = floor(abs($borrow / 7));
			}catch(Exception $e)
			{
				$addtionalBoxes = 0;
			}

			return $addtionalBoxes;
		}

	}
