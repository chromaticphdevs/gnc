<?php

	class PrintingExpenseModel extends Base_model
	{

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}



		public function upload_expense_info($data, $image)
		{	

			extract($data);

   			$data_query = [
                "printing_expense",
                [
                    'machine_type'   => $machine_type,
                    'client' => $client,
                    'agent'   => $agent,
                    'agent_number'  => $agent_number,
                    'job_order_number' => $job_order,
                    'uploader_name'   => $name,
                    'reading'  => $meter_readings,
                    'image'   => $image,
                    'note'  => $note,
                    'date_time'  => today()
                   
                ]
            ];
            $last_inserted_id = $this->dbHelper->insert(...$data_query);

            if($total_running > 0 and $amount_total_running > 0)
            { 	
				$this->save_computation($data, $last_inserted_id);	
            }

            return  $last_inserted_id;
		}

		public function get_all_expenses()
		{
			$this->db->query(

                "SELECT *
				 FROM `printing_expense` 
				 ORDER BY `printing_expense`.`date_time` DESC"
            );

            return $this->db->resultSet();
		}

		
		public function get_last_job_order($machine_type)
		{
			$this->db->query(

                "SELECT *
				 FROM `printing_expense` 
				 WHERE machine_type = '$machine_type'
			     Order By date_time DESC LIMIT 1"
            );

            return $this->db->resultSet();
		}


		public function save_computation($data, $id)
		{
			$data_query = [
                "printing_computation",
                [
                    'previous_reading'   => $data['previous_meter_readings_id'],
                    'current_reading' => $id,
                    'running'   => $data['total_running'],
                    'amount'  => $data['amount_total_running'],
                    'discount'   => $data['discount'],
                    'payment'  => $data['amount_total_running'] -  $data['discount'],
                    'date_time'  => today()
                ]
            ];

            return $this->dbHelper->insert(...$data_query);
		}
	}
