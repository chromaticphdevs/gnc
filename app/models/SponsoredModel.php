<?php 	
	/*get users sponsored users summary*/
	class SponsoredModel extends Base_model
	{
		public function getSummary($userid , $status)
		{
			$sql = "SELECT count(id) as total from users 
			where direct_sponsor = '$userid' 
			and status = '$status'";
			$this->db->query($sql);

			$res = $this->db->single();

			if($res)
				return $res->total;
			return 0;
		}
	}