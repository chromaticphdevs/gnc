<?php 	

	class FNSingleboxModel extends Base_model
	{

		private $table_name = 'fn_single_box_loans';

		private $boxAmount = 375.00;

		public function make_assistance($singleboxinfo)
		{
			extract($singleboxinfo);

			$currentRequest = $this->get_unpaid_boxes($userid);

			if(!empty($currentRequest))
			{
				if(count($currentRequest) >= 12) {
					Flash::set("Pay all product loan first before loaning again" , 'danger');
					return false;
				}
			}

			$code = $this->make_code();

			$status = 'pending';

			$boxAmount = $this->boxAmount;

			$make_query = "
				INSERT INTO $this->table_name(userid , code , amount , branchid , status)
				VALUES('$userid' , '$code' , '$boxAmount' , '$branchid' , '$status');";

			if($addtionalBoxes > 0)
			{
				for($i = 0 ; $i < $addtionalBoxes ; $i++)
				{
					$code = $this->make_code();
					$make_query .= "
					INSERT INTO $this->table_name(userid ,code ,amount , branchid , status)
					VALUES('$userid' ,'$code' , '$boxAmount' , '$branchid' , 'pending');";
				}
			}

			try{
				$this->db->query($make_query);

				$this->db->execute();

				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());

				return false;
			}
		}


		public function get_user_assistance($userid = null)
		{
			$this->db->query(
				"SELECT boxloan.* , branch.name as branch_name 
					FROM $this->table_name as boxloan 
					left join fn_branches as branch 
					on branch.id = boxloan.branchid 
					WHERE boxloan.userid = '$userid'"
			);

			return 	
				$this->db->resultSet();
		}


		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT boxloan.* , branch.name as branch_name , 
					concat(firstname , ' ' , lastname) as customer

					FROM $this->table_name as boxloan 
					left join fn_branches as branch 
					on branch.id = boxloan.branchid

					left join users as user 
					on user.id = boxloan.userid 
					$params"
			);

			return 	
				$this->db->resultSet();
		}

		public function get_code($boxid)
		{
			$data = [
				$this->table_name , 
				'*',
				"id = '$boxid'"
			];

			return 	
				$this->dbHelper->single(...$data);
		}

		public function get_info_by_code($code)
		{
			$data = [
				$this->table_name , 
				'*',
				"code = '$code'"
			];

			return 	
				$this->dbHelper->single(...$data);
		}

		public function get_paid_count($userid)
		{
			$this->db->query("SELECT count(id) as paid_total from $this->table_name 
					where userid = '$userid' and status = 'paid'");

			$result = $this->db->single();

			if($result) {
				return $result->paid_total;
			}

			return 0;
		}

		public function update_code($boxid , $status)
		{
			$data = [
				$this->table_name ,
				[
					'status' => $status
				],
				" id = '$boxid'"
			];

			return 	
				$this->dbHelper->update(...$data);
		}
		
		public function get_list_order_branch()
		{
			return 
				$this->get_list( " ORDER by branch.name , customer , status asc");
		}

		public function get_by_branch($branchid)
		{
			$where = " WHERE boxloan.branchid = '$branchid'";

			return 	
				$this->get_list($where);
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

		public function get_unpaid_boxes($userid)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name
					WHERE userid = '$userid'
					and status !='paid' order by status desc"
			);

			return $this->db->resultSet();
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


	}