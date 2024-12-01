<?php 	

	class LiveSearchModal extends Base_model
	{
		
		public function brgy($key_word)
		{

			extract($key_word);

			$this->db->query(
				"SELECT brgyDesc FROM `refbrgy` WHERE brgyDesc LIKE '%$key_word%' LIMIT 5"
			);

			$result = $this->db->resultSet();
			
			
			echo '<select class="input100" name="brgy" id="brgy_select" onclick="brgy_click()" required>'; 

					 foreach($result as $data)
					 {
							echo "
									 <option value='{$data->brgyDesc}'>{$data->brgyDesc}</option> 
							              
							   ";
					}
		
			echo '</select>';
		
		}


		public function city($key_word)
		{

			extract($key_word);

			$this->db->query(
				"SELECT citymunDesc FROM `refcitymun` WHERE citymunDesc LIKE '%$key_word%' LIMIT 5"
			);

			$result = $this->db->resultSet();


			echo '<select class="input100" name="city" id="city_select" onclick="city_click()"  required>'; 

					 foreach($result as $data)
					 {
							echo "
									 <option value='{$data->citymunDesc}'>{$data->citymunDesc}</option> 
							              
							   ";
					}
		
			echo '</select>';
		
		}

		public function province($key_word)
		{

			extract($key_word);

			$this->db->query(
				"SELECT provDesc FROM `refprovince` WHERE provDesc LIKE '%$key_word%' LIMIT 5"
			);

			$result = $this->db->resultSet();


			echo '<select class="input100" name="province" id="province_select" onclick="province_click()"  required>'; 

					 foreach($result as $data)
					 {
							echo "
									 <option value='{$data->provDesc}'>{$data->provDesc}</option> 
							              
							   ";
					}
		
			echo '</select>';
		
		}

		public function region($key_word)
		{

			extract($key_word);

			$this->db->query(
				"SELECT regDesc FROM `refregion` WHERE regDesc LIKE '%$key_word%' LIMIT 5"
			);

			$result = $this->db->resultSet();


			echo '<select class="input100" name="region" id="region_select" onclick="region_click()"  required>'; 

					 foreach($result as $data)
					 {
							echo "
									 <option value='{$data->regDesc}'>{$data->regDesc}</option> 
							              
							   ";
					}
		
			echo '</select>';
		
		}




		
	}