<?php 	

	class ReligionModal extends Base_model
	{
		
		public function list($key_word)
		{

			extract($key_word);

			$this->db->query(
				"SELECT id, name FROM `religions` WHERE name LIKE '%$key_word%' LIMIT 5"
			);

			$result = $this->db->resultSet();


			echo '<select class="input100" name="religion_id" id="religion_select" onclick="religion_click()" required>'; 

					 foreach($result as $data)
					 {
							echo "
									 <option value=".$data->id.">".$data->name."</option> 
							              
							   ";
					}
		
			echo '</select>';
		
		}


		
	}