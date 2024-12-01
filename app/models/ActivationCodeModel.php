<?php 	

	class ActivationCodeModel extends Base_model
	{

		public function get_by_code($code) {

			$this->db->query(
				"SELECT * FROM ld_activation_code where activation_code = '{$code}'"
			);

			return $this->db->single();
		}

		public function get_list()
		{
			$this->db->query(
				"SELECT * FROM ld_activation_code 	
					order by id desc limit 200"
			);

			return $this->db->resultSet();
		}

		public function update_to_use($codeid , $userid) 
		{

			date_default_timezone_set('Asia/Manila');
			$date= date('Y-m-d') ;
			$time=date("H:i:s");

			$this->db->query(
				"UPDATE ld_activation_code SET user_id='$userid', activated_date='$date', activated_time='$time', status='Used' WHERE id='$codeid'"
			);

			return $this->db->execute();
		}

		public function create_code($productID){

			extract($productID);
			$product_quantity=0;
			for($i=1; $i<=$numbers_of_code; $i++)
			{

				$code1=random_number();
				$code2=random_number();
				$code3=random_number();
				$activation_code=substr($code1,0,3).'-'.substr($code2,0,3).'-'.substr($code3,0,1);

				$this->db->query(
						"SELECT * FROM `products` WHERE id='$productID'"
					);
				
				$product_info = $this->db->single();

				$activation_level  = $this->get_activation_level($product_info->binary_pb_amount);

				$activation_code=strtoupper($activation_level[0].''.$activation_level[1]).'-'.$activation_code;

				$this->db->query("INSERT INTO `ld_activation_code`( `activation_code`, `product_id`,`activation_level`,`package_quantity`, `price`, `drc_amount`, `unilvl_amount`, `binary_pb_amount`, `com_distribution`, `max_pair`, `status`, `branch_id`, `status2`, `company`) 
					VALUES ('$activation_code','$productID', '$activation_level', '$product_info->package_quantity','$product_info->price','$product_info->drc_amount','$product_info->unilvl_amount','$product_info->binary_pb_amount','$product_info->com_distribution','$product_info->max_pair','Unused','$branch','Unsold','$company')");
		
				$this->db->execute();		

			}

			Flash::set("Activation Code created");
			redirect('/Activation/create_code');

		}

		private function get_activation_level($binary_points)
		{

			if($binary_points >= 16600) {
				return 'diamond';
			}

			if($binary_points >= 8000) {
				return 'platinum';
			}

			if($binary_points >= 3100) {
				return 'gold';
			}

			if($binary_points >= 1500) {
				return 'silver';
			}

			if($binary_points >= 700) {
				return 'bronze';		
			}

			if($binary_points >= 100) {
				return 'starter';
			}
		}
	}