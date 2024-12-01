<?php 	

	class LDGeneologyModel extends Base_model
	{
		public function binary()
		{

		}
		/*userid reffering to sne userid*/
		public function downline($userid = null, $position)
		{
			$position = strtoupper($position);
			if(is_null($userid))
			{
				$genology = new LDGeneologyObj(null);
			}else{

				$this->db->query(
				"SELECT * FROM users where upline = '$userid' and L_R = '$position' order by id desc limit 1"
				);

				$result = $this->db->single();

				$genology = new LDGeneologyObj($result);
			}

			return $genology;
		}

		public function get_user_as_sne($dbbid) 
		{
			$this->db->query("SELECT * FROM users where dbbi_id = '$dbbid'");

			return $this->db->single();
		}
	}