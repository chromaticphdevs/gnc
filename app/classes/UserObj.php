<?php 	

	class UserObj
	{

		public $id ,$firstname,$middlename,
		$lastname,$email,$password,
		$phone, $user_type,$active_status,
		$created_on, $fullname;
		public function getClass()
		{
			$table_name = 'ld_users';
			$db = new Database();
			$userid = $this->id;

			$sql = "SELECT ld_groups_attendees.groupid,ld_lenders_groups.name,ld_lenders_groups.day,ld_lenders_groups.time  
					FROM $table_name 
					INNER JOIN ld_groups_attendees ON ld_users.id=ld_groups_attendees.userid 
					JOIN ld_lenders_groups ON ld_groups_attendees.groupid=ld_lenders_groups.id 
					WHERE ld_users.id=$userid";

			$db->query($sql);
		
			return $db->single();
		}
	}

?>