<?php 	

	class FNCodePurchaseModel extends Base_model
	{

		private $table_name = 'fn_code_purchases';

		public function make_purchase($userid , $codeid , $branchid)
		{
			$reference = $this->make_reference();

			$data = [
				$this->table_name ,
				[
					'userid'    => $userid, 
					'codeid'    => $codeid,
					'branchid'  => $branchid,
					'reference' => $reference,
					'status'    => 'pending'
				]
			];

			return 	
				$this->dbHelper->insert(...$data);
		}

		public function get_purchase($purchaseid)
		{
			$data = [
				$this->table_name , 
				'*',
				" id = '$purchaseid'"
			];

			return 	
				$this->dbHelper->single(...$data);
		}

		public function get_by_user($userid)
		{
			$this->db->query(

				"SELECT purchase.* , branch.name as branch_name 
					FROM $this->table_name AS purchase 

					LEFT JOIN fn_branches as branch

					on branch.id = purchase.branchid

					WHERE purchase.userid = '$userid' "
			);

			return $this->db->resultSet();
		}

		public function get_list($params = null) 
		{
			$this->db->query(
				"SELECT purchase.* , concat(u.firstname , ' ' , u.lastname) as fullname ,
				 branch.name as branch_name ,code.code as code_reference , code.level as level , code.box_eq 

				 FROM $this->table_name as purchase 

				 LEFT JOIN fn_code_inventories as code 
				 on purchase.codeid = code.id 

				 LEFT JOIN fn_branches as branch 
				 on purchase.branchid = branch.id 

				 LEFT JOIN users as u 
				 on u.id = purchase.userid

				 $params"
			);

			return 	
				$this->db->resultSet();
		}

		public function get_list_by_branch($branchid)
		{
			$where = " WHERE purchase.branchid = '{$branchid}'";

			return
				$this->get_list($where);
		}

		public function get_list_by_branch_status($branchid , $status)
		{
			$where = " WHERE purchase.branchid = '{$branchid}' and purchase.status = '$status' ORDER BY id desc";
			return
				$this->get_list($where);
		}
		public function get_by_reference($reference)
		{
			$data = [
				$this->table_name , 
				'*',
				" reference = '{$reference}'"
			];

			return 	
				$this->dbHelper->single(...$data);
		}
		private function make_reference()
		{
			/*get last id*/
			$data = [
				$this->table_name , 
				[
					'id'
				],
				null,
				"id desc" ,
				"1"
			];

			$lastid = $this->dbHelper->single(...$data);

			if(!$lastid){
				$lastid = 0;
			}else{
				$lastid = $lastid->id;
			}

			$prefix = random_number(3);
			$mid    = random_number(4);
			$suffix = $lastid;

			return "{$prefix}-{$mid}-{$suffix}";
		}

		public function update_status($purchaseid , $status)
		{
			$data = [
				$this->table_name , 
				[
					'status' => $status
				], 
				" id = '$purchaseid'"
			];
			
			return 	
				$this->dbHelper->update(...$data);
		}

		public function update_status_search_codeid($codeid , $status)
		{
			$data = [
				$this->table_name , 
				[
					'status' => $status
				], 
				" codeid = '$codeid'"
			];
			
			return 	
				$this->dbHelper->update(...$data);
		}
	}