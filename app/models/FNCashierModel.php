<?php 	
	class FNCashierModel extends Base_model
	{



		public function get_cash_inventory_today($branchId)
		{	
			date_default_timezone_set("Asia/Manila");
			$today=date("Y-m-d");
			
			$this->set_time_zone();

			$this->db->query(

                "SELECT SUM(amount) as total, 
                (SELECT name FROM fn_accounts WHERE id =frp.cashier_id) as name,
                (SELECT type FROM fn_accounts WHERE id =frp.cashier_id) as type  
                FROM `fn_product_release_payment` as frp 
                WHERE status = 'Approved' 
                AND date(date_time) = '$today' 
                AND branchId ='$branchId' 
                GROUP by cashier_id"               
            );

            return $this->db->resultSet();

		}

		public function get_cash_inventory_all($branchId)
		{
			$this->db->query(

                "SELECT SUM(amount) as total, 
                (SELECT name FROM fn_accounts WHERE id =frp.cashier_id) as name,
                (SELECT type FROM fn_accounts WHERE id =frp.cashier_id) as type  
                FROM `fn_product_release_payment` as frp 
                WHERE status = 'Approved' AND branchId ='$branchId' GROUP by cashier_id"               
            );

            return $this->db->resultSet();

		}

		public function get_cash_inventory_limit_by_days($branchId, $days)
		{	
			$today=$this->get_date_today();	
			$this->set_time_zone();

			$this->db->query("SELECT SUM(amount) as total,  
				(SELECT name FROM fn_accounts WHERE id =frp.cashier_id) as name, 
				(SELECT type FROM fn_accounts WHERE id=frp.cashier_id) as type , 
				(SELECT name FROM fn_branches WHERE id= {$branchId}) as branch_name 
				FROM `fn_product_release_payment` as frp  
				WHERE status = 'Approved' and DATEDIFF('$today', DATE(date_time)) <= {$days}
				AND branchId = {$branchId} GROUP by cashier_id ORDER BY total DESC");

			return $this->db->resultSet();

		}


		public function get_cashier_wallet_info()
		{
			$this->db->query("SELECT *,(SELECT name FROM fn_branches WHERE id = fn_a.branchid) as branch_name,
					        (SELECT IFNULL(SUM(amount),0) FROM fn_cash_inventories WHERE cashier_id = fn_a.id) as amount FROM `fn_accounts` as fn_a
					        	WHERE type = 'cashier' OR type = 'branch-manager'
					        	ORDER by branch_name");

            return $this->db->resultSet();
		}

		public function get_cashier_balance($cashier_id)
		{
			$this->db->query("SELECT IFNULL(SUM(amount),0) as amount
							  FROM fn_cash_inventories
							  WHERE cashier_id = $cashier_id");

            return $this->db->single()->amount;

		}

	
		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}
		public function get_date_today()
		{
			date_default_timezone_set("Asia/Manila");
			return date("Y-m-d");
		}

	}


