<?php 	

	class BranchInventoryModel extends Base_model
	{

		private $table_name = 'product_stocks';


		public function create($stockinfo)
		{
			extract($stockinfo);

			$description = filter_var($description , FILTER_SANITIZE_STRING);

			$this->db->query(
				"INSERT INTO $this->table_name(quantity , description , branchid)
				VALUES('$quantity' , '$description' , '$branchid')"
			);

			try{
				$this->db->execute();
				return true;

			}catch(Exception $e) {

				die($e->getMessage());
				return false;
			}
		}

		public function get_logs()
		{
			$this->db->query(
				"SELECT * ,branch_name 
					FROM $this->table_name as stock

					left join ld_branch as branch 

					on branch.id = stock.branchid
					
					ORDER BY created_at desc"
			);

			return $this->db->resultSet();
		}

	}
?>