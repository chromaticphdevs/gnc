<?php

	class LDPayinModel extends Base_model
	{
		
		public function make_payin($purchaserid , $amount , $type , $origin)
		{

			$this->db->query(
				"INSERT INTO ld_payin_transactions(purchaser , amount  , type , origin)
				VALUES('$purchaserid' , '$amount' , '$type' , '$origin')"
			);

			try
			{
				$this->db->execute();
				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
				return false;
			}
		}

		public function group_by_amount()
		{
			$today=date_create($this->get_date_today());	
			date_sub($today,date_interval_create_from_date_string("7 days"));
			$mydate=date_format($today,	"Y-m-d");

			$this->db->query(
				"SELECT *,COUNT(*) as count FROM `ld_payin_transactions` 
				 WHERE DATE(dateandtime) > '$mydate'
				 GROUP BY amount DESC"
			);

			return $this->db->resultSet();
		}

		public function get_payins($startdate)
		{

			$today=date_create($this->get_date_today());	
			date_sub($today,date_interval_create_from_date_string("7 days"));
			$mydate=date_format($today,	"Y-m-d");
 			
 	
			$this->db->query(
				"SELECT * FROM ld_payin_transactions
					where  DATE(dateandtime) > '$mydate' ORDER BY dateandtime DESC"
			);

			$resultSet  = $this->db->resultSet();

			$total = 0;

			foreach ($resultSet as $key => $row) {
				$total += $row->amount;
			}

			return [
				'list' => $resultSet,
				'total' => $total
			];
		}


		public function get_payins_with_option($limit)
		{	
			
			
			$today=$this->get_date_today();	
			$this->set_time_zone();

			if($limit=="today")
			{
				
				$this->db->query(
					"SELECT * FROM ld_payin_transactions
					 WHERE DATE(dateandtime) = '$today' ORDER BY dateandtime DESC"                  
		        );

		        $resultSet  = $this->db->resultSet();

			}elseif(substr($limit, 0 , 4)=="days")
			{
				$days=trim($limit,"days");

				$this->db->query(
					"SELECT * FROM ld_payin_transactions
					 WHERE DATEDIFF('$today',DATE(dateandtime)) <= {$days} ORDER BY dateandtime DESC"                  
		        );

		        $resultSet  = $this->db->resultSet();
			}else{

				$this->db->query(
				"SELECT * FROM ld_payin_transactions ORDER BY dateandtime DESC"
				);
	
				$resultSet  = $this->db->resultSet();
			}

			$total = 0;

			foreach ($resultSet as $key => $row) {
				$total += $row->amount;
			}

			return [
				'list' => $resultSet,
				'total' => $total
			];
			
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
