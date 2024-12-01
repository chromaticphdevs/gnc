<?php

	class FNItemInventoryModel extends Base_model
	{
		private $table_name = 'fn_item_inventories';
		/**
		 * DO NOT REMOVE
		 */
		public $table = 'fn_item_inventories';

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}


		public function make_item($iteminventoryinfo)
		{
			extract($iteminventoryinfo);

			$data = [
				$this->table_name,
				[
					'branchid' => $branchid,
					'quantity' => $quantity,
					'description' => $description
				]
			];

			return
				$this->dbHelper->insert(...$data);
		}

		public function get_list($params = null)
		{
			$this->set_time_zone();
			/**
			 * NEW
			 * INVENTORY table joined
			 * in_products table
			 */
			$this->db->query(
				"SELECT inventory.* , branch.name as branch_name, p.name as p_name,
				 SUBSTRING(inventory.description, 37, LENGTH(inventory.description)) as loan_number,
				 (SELECT userid FROM `fn_product_release` WHERE code = TRIM(loan_number) ) as userID,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = userID) as fullname
				 	FROM $this->table_name as inventory
				 	left join fn_branches as branch
				 		ON branch.id = inventory.branchid
					LEFT join in_products as p on
						inventory.product_id = p.id
				 		$params"
			);
			return $this->db->resultSet();
		}

		public function get_list_decrease()
		{
			return
				$this->get_list(" ORDER BY inventory.created_at desc ");
		}

		public function getListDecreaseWithLimit($limit)
		{
			return
				$this->get_list(" ORDER BY inventory.created_at desc LIMIT $limit");
		}

		public function get_by_branch()
		{
			$this->db->query(
				"SELECT  branch.id as branch_id,branch.name as branch_name , SUM(inventory.quantity) as total_qty
				 	FROM $this->table_name as inventory
				 	left join fn_branches as branch
				 	ON branch.id = inventory.branchid  GROUP BY  inventory.branchid ");

			return $this->db->resultSet();
		}



		public function get_branch_inventory($branchid)
		{
			$where = " WHERE inventory.branchid = '{$branchid}'";

			return
				$this->get_list( $where );
		}


		public function get_branch_inventory_with_name($branchid)
		{
			$this->db->query(
				"SELECT *,(SELECT name FROM fn_branches WHERE id= branchid) as branch_name,
				 SUBSTRING(description, 37, LENGTH(description) ) as loan_number,
				 (SELECT userid FROM `fn_product_release` WHERE code = TRIM(loan_number) ) as userID,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = userID) as fullname
				  FROM fn_item_inventories
				  WHERE  branchid = '$branchid' ORDER BY created_at DESC");
			return $this->db->resultSet();
		}


		public function get_branch_logs($branchid)
		{

			if($branchid == "all_logs")
			{

				return
					$this->get_list(" ORDER BY inventory.created_at desc ");

			}else
			{
				return
					$this->get_list("WHERE inventory.branchid = '{$branchid}'  ORDER BY inventory.created_at desc");
			}
		}

		/*
		*FN ITEM INVENTORIES CHECK PRODUCT STOCKS TOTAL
		*/

		public function getProductStocksByBranch($product_id , $branch_id)
		{
			$this->db->query(
				"SELECT sum(quantity) as total_stock
					FROM $this->table
						WHERE product_id = '$product_id'
						AND branchid = '$branch_id'"
			);
			return $this->db->single()->total_stock ?? 0;
		}


		public function get_branch_inventory_all($branchid)
		{
			$this->db->query(
				"SELECT SUM(quantity) as quantity,
				(SELECT name FROM in_products WHERE id = product_id) as product_name,
				(SELECT name FROM fn_branches WHERE id = branchid) as branch_name
				FROM `fn_item_inventories` WHERE branchid = '$branchid' GROUP by product_id");

			return $this->db->resultSet();
		}

		/**
		*Get stocks summary by branch
		*group them by product
		*
		*Sub-Query in products to get the stocking type of the product
		*/
		public function getSummaryByBranch($branch_id)
		{
			$this->db->query(
				"SELECT product.name , inventory.product_id , 
					sum(quantity) as total_stock,
					(SELECT stock_type FROM in_products
						WHERE id = inventory.product_id)
					as stock_type

					FROM $this->table as inventory
					LEFT JOIN in_products as product 
						ON product.id = inventory.product_id

					WHERE branchid = '$branch_id'

					GROUP BY inventory.product_id"
			);

			return $this->db->resultSet();
		}

		public function search_user($userId)
		{
			$this->db->query(

                "SELECT id, CONCAT(firstname,' ',lastname)as fullname,
                 email ,mobile,status
				 FROM `users` 
				 WHERE id='$userId'"
            );

            return $this->db->single();

		}

		public function upload_delivery_info($userid,$control_number,$image,$added_by)
		{
			$this->db->query(
				"INSERT INTO `fn_delivery_info`(`userid`, `control_number`, `image`, `added_by`) 
				 VALUES ('$userid','$control_number','$image','$added_by')");

       		return $this->db->execute();
		}

		public function get_delivery_info_for_user($userid)
		{
			$this->db->query(

                "SELECT *
				 FROM `fn_delivery_info` 
				 WHERE userid='$userid'"
            );

            return $this->db->resultSet();
		}

		public function getGroupedQuantity($userId)
		{
			$this->db->query(
				"SELECT quantity FROM fn_item_inventories
					GROUP BY quantity"
			);

			return $this->db->resultSet();
		}

		public function getGroupedQuantity_branch($branchid)
		{
			$this->db->query(
				"SELECT quantity FROM fn_item_inventories 
				 WHERE branchid = '$branchid'
					GROUP BY quantity"
			);

			return $this->db->resultSet();
		}



		public function getByQuantity($branchid , $quantity)
		{
			$this->db->query(
				"SELECT *,(SELECT name FROM fn_branches WHERE id= branchid) as branch_name,
				 SUBSTRING(description, 37, LENGTH(description) ) as loan_number,
				 (SELECT userid FROM `fn_product_release` WHERE code = TRIM(loan_number) ) as userID,
				 (SELECT CONCAT(firstname,' ',lastname) FROM users WHERE id = userID) as fullname
				  FROM fn_item_inventories
				  WHERE  branchid = '$branchid'

				  AND quantity = '$quantity' ORDER BY created_at DESC");
			return $this->db->resultSet();
		}

	}
