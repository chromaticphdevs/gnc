<?php

	class FNCashInventoryModel extends Base_model
	{

		private $table_name = 'fn_cash_inventories';

		public $table = 'fn_cash_inventories';


		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function make_cash(array $cashDetails)
		{
			return parent::store($cashDetails);
		}
		//OLD REVERT IF ERROR OCCUR
		// public function get_list($params = null)
		// {
		// 	$this->db->query(
		// 		"SELECT cash.* , branch.name as branch_name
		// 			FROM $this->table_name as cash
		// 			left join fn_branches as branch
		//
		// 			on branch.id = cash.branchid
		//
		// 			$params"
		// 	);
		//
		// 	return
		// 		$this->db->resultSet();
		// }


		public function get_list($params = null)
		{

			if(is_null($params))
				$params = " ORDER BY id desc";

				$this->db->query(
						"SELECT cash.* , branch.name as branch_name,
						SUBSTRING(description	, 24, 11) as loan_number,
	 				 (SELECT userid FROM `fn_product_release` WHERE code = TRIM(loan_number) ) as userID,
	 				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = userID) as fullname

							FROM $this->table_name as cash
							left join fn_branches as branch
							on branch.id = cash.branchid

							$params"
					);
			return $this->db->resultSet();
		}




		public function get_list_descending()
		{
			return
				$this->get_list(" ORDER BY cash.id desc ");
		}
		public function get_branch_inventory($branchid)
		{
			$where = " WHERE cash.branchid = '{$branchid}' order by cash.id desc";

			return $this->get_list($where);
		}

		public function get_branch_amount_total($branchid)
		{
			$this->db->query(
				"SELECT sum(amount) as total
					FROM $this->table_name WHERE branchid = '{$branchid}'"
			);

			return $this->db->single()->total ?? 00;
		}

		public function get_branch_inventory_with_name($branchid)
		{
			$user = Session::get('BRANCH_MANAGERS');
			$cashier_id = $user->id;

			$this->set_time_zone();
			$this->db->query(
				"SELECT *,
				 (SELECT name FROM fn_branches WHERE id= branchid) as branch_name,
				 SUBSTRING(description	, 24, 11) as loan_number,
				 (SELECT userid FROM `fn_product_release` WHERE code = TRIM(loan_number) ) as userID,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = userID) as fullname
				  FROM fn_cash_inventories
				  WHERE  branchid = '$branchid' AND cashier_id = '$cashier_id' ORDER BY id DESC");

			return $this->db->resultSet();
		}

		public function get_branch_total($branchid)
		{

			$this->db->query("SELECT sum(amount) as amount_total
				FROM $this->table_name as cash
				where cash.branchid = '$branchid'");

			$result= $this->db->single();

			if($result) {
				return $result->amount_total;
			}

			return 0;
		}


		public function get_branch_all_total()
		{

			$this->db->query("SELECT branchid,
				(SELECT name FROM fn_branches WHERE id = branchid ) as branch_name,
				 sum(amount) as total
				 FROM `fn_cash_inventories`  GROUP BY branchid");

			return
				 $this->db->resultSet();
		}

		public function computeTotal($cashInventories)
		{
			$total = 0;
			if(!empty($cashInventories)) {

				foreach($cashInventories as $key => $row){
					$total += $row->amount;
				}
			}

			return $total;
		}
	}
