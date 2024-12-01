<?php

	class LDBranchModel extends Base_model
	{
		private $table_name = 'ld_branch';

		// public function create_branch($info, $userId)
		// {
		//
		// 	extract($info);
		//
		// 	$this->db->query(
		// 			"INSERT INTO `ld_branch`(`branch_name`, `address`, `note`, `created_by`)
		//			VALUES ('$branch_name','$branch_address','$note','$userId')"
		// 	);
		// 	$this->db->execute();
		//
		// 	Flash::set("New Branch Created");
		// 	redirect("/LDBranch/create");
		//
		// }

		public function create_branch($info , $userid)
		{
			extract($info);

			$note = filter_var($note , FILTER_SANITIZE_STRING);
			$address = filter_var($address , FILTER_SANITIZE_STRING);

			$this->db->query(
					"INSERT INTO `ld_branch`(`branch_name`, `address`, `note`, `created_by`)
					VALUES ('$branch_name','$address','$note','$userid')"
			);
			try{
				$this->db->execute();
				return true;
			}catch(Exception $e) {
				Flash::set($e->getMessage() , 'danger');
				return false;
			}
		}

		public function get_list()
		{
			$this->db->query(
				"SELECT * FROM $this->table_name"
			);

			return $this->db->resultSet();
		}

		public function get_main_branch()
		{
			$this->db->query(
				"SELECT * FROM $this->table_name where type = 'main-branch'"
			);

			return $this->db->single();
		}

		public function get_sub_branches()
		{
			$this->db->query(
				"SELECT * FROM $this->table_name where type = 'sub-branch'"
			);

			return $this->db->resultSet();
		}


		public function transfer_cash_branch($info, $main_branch_id)
		{

			extract($info);


			$this->db->query("SELECT balance as prev_balance FROM `ld_branch_vault` WHERE branch_id='$branch_id'");

			$result = $this->db->single();

			$new_balance=$result->prev_balance-$amount;

			if($new_balance > 0){

				//sub balance from branch selected
				$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `type`, `prev_balance`, `new_balance`, `note`) VALUES ('$branch_id','transfer','$result->prev_balance','$new_balance','transfer vault balance to main')");
				$this->db->execute();

				$this->db->query("UPDATE ld_branch_vault SET `balance`='$new_balance' WHERE branch_id='$branch_id'");
				$this->db->execute();

				//transfer amount to main
				$this->db->query("SELECT balance as prev_balance FROM `ld_branch_vault` WHERE branch_id='$main_branch_id'");

				$main_branch_balance = $this->db->single();

				$main_new_balance = $main_branch_balance->prev_balance+$amount;

				$this->db->query("INSERT INTO `ld_branch_vault_history`(`branch_id`, `type`, `prev_balance`, `new_balance`, `note`) VALUES ('$main_branch_id','transfer','$main_branch_balance->prev_balance','$main_new_balance','transfer vault balance to main')");
				$this->db->execute();

				$this->db->query("UPDATE ld_branch_vault SET `balance`='$main_new_balance' WHERE branch_id='$main_branch_id'");
				$this->db->execute();

				echo "Transfer Successfuly";

			}else{


				echo "Error Insufficient Balance";

			}




		}




	}
