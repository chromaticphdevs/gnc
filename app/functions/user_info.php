<?php 
	
	function check_user_contacts($userid)
	{
		$con = Database::getInstance();
		
		$con->query(
			"SELECT COUNT(*) as contacts FROM `user_contacts` 
			 WHERE `userid` = '{$userid}'"
		);

		return $con->single()->contacts;
	}

	function check_user_social_media($userid)
	{
		$con = Database::getInstance();
		
		$con->query(
			"SELECT COUNT(*) as social_media FROM `user_social_media` 
			 WHERE `userid` = '{$userid}' AND `status` != 'deny'"
		);

		return $con->single()->social_media;
	}

	function check_user_id($userid)
	{
		$con = Database::getInstance();
		
		$con->query(
			"SELECT COUNT(*) as uploaded_id FROM `users_uploaded_id` 
			 WHERE `userid` = '{$userid}'  AND `status` != 'deny'"
		);

		return $con->single()->uploaded_id;
	}