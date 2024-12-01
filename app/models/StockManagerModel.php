<?php 	

	class StockManagerModel extends Base_model
	{
		/*beta*/
		public function release_stock($quantity , $description , $branchid)
		{

			$branchStocks = $this->get_branch_stock($branchid);


			if(count($branchStocks) < $quantity) 
			{
				Flash::set("Not Enough Stocks");

				return false;
			}

			$quantity  = $quantity * -1; //quantity to negative
			$description = filter_var($description ,FILTER_SANITIZE_STRING);

			$this->db->query(	
				"INSERT INTO product_stocks(quantity , description , branchid) 
				VALUES('$quantity' , '$description' , '$branchid')"
			);
			try{
				$this->db->execute();

				return true;
			}catch(Exception $e)
			{
				return false;
			}
		}

		private function get_branch_stock($branchid)
		{
			$this->db->query(
				"SELECT * FROM product_stocks where id = '$branchid'"
			);

			return $this->db->resultSet();
		}

		public function get_total_stocks()
		{
			$this->db->query(
				"SELECT SUM(quantity) as total FROM product_stocks"
			);

			$result = $this->db->single();

			if(!empty($result)) {
				return $result->total;
			}
			return 0;
		}
		
		public function get_stocks()
		{
			$this->db->query(
				"SELECT * FROM product_stocks"
			);

			return $this->db->resultSet();
		}

		public function add_stocks()
		{
			$this->db->query(
				"INSERT INTO product_stocks(quantity) VALUES('20')"
			);

			return $this->db->execute();
		}
	}