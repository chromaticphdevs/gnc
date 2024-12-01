<?php

	class MGPayinModel extends  Base_model
	{
		public function get_list_by_date($datestart = null , $dateend = null) 
		{

			if(is_null($datestart)) 
			{
				$this->db->query(
					"SELECT sum( ANY_VALUE(price)) as amount_total , ANY_VALUE(price) as price, count(price) as count_total,  ANY_VALUE(activation_level) as activation_level
						FROM ld_activation_code WHERE

						status = 'used'

						GROUP BY activation_level
						"
				);
			}else{
				$this->db->query(
					"SELECT sum( ANY_VALUE(price)) as amount_total , ANY_VALUE(price) as price, count(price) as count_total,  ANY_VALUE(activation_level) as activation_level
						FROM ld_activation_code 
						WHERE created_on >'{$dateend}' and status = 'used'

						GROUP BY activation_level
						"
				);

			}
			

			$resultSet = $this->db->resultSet();

			$total = 0;

			if(!empty($resultSet)) 
			{
				foreach($resultSet as $row => $key) 
				{
					$total += $key->amount;
				}
			}
			
			return [
				'list'  => $resultSet,
				'total' => $total
			];
		}
	}