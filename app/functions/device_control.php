<?php 
	function otp_sms($state = null)
	{	
		$con = Database::getInstance();
		//if state is null send device status
		if(empty($state))
		{
			$con->query(
				"SELECT `otp_sms` FROM `device_control`"
			);

			return $con->single()->otp_sms;
		}else
		{
			$con->query(
				"UPDATE `device_control` SET `otp_sms` = '$state'"
		    );
			return $con->execute();
		}
	}


	function registration_sms($state = null)
	{
		$con = Database::getInstance();
		//if state is null send device status
		if(empty($state))
		{
			$con->query(
				"SELECT `registration_sms` FROM `device_control`"
			);

			return $con->single()->registration_sms;
		}else
		{
			$con->query(
				"UPDATE `device_control` SET `registration_sms` = '$state'"
		    );
			return $con->execute();
		}
	}