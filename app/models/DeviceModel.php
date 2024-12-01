
<?php 	

	class DeviceModel extends Base_model
	{

		public function change_state($category, $status)
		{

			$this->db->query(

			   "UPDATE `device_control` 
				SET `$category` = '$status'"
			);

			$this->db->execute();
		}

		public function get_device_state()
		{
			$this->db->query(
				"SELECT * FROM device_control"
			);

			return $this->db->single();			
		}

	}