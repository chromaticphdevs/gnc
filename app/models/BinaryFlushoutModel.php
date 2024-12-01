<?php 	

	class BinaryFlushoutModel extends Base_model
	{

		public function make_flushout($userid)
		{
			/*delete all legs*/
			$this->db->query(
				"DELETE FROM binary_pvs where c_id = '$userid'"
			);
			try{
				$this->db->execute();

				$this->db->query(
					"DELETE FROM binary_pv_pair_deduction where user_id = '$userid'"
				);

				$this->db->execute();

				return true;
			}catch(Exception $e) {
				return false;
			}
		}
	}