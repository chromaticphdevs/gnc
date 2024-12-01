<?php 	

	class Authorization
	{

		public static function setAccess(array $hasAccess ,$callBack = null)
		{
			if(isEqual('admin', $hasAccess)) {
				return true;
			}
			
			if(in_array(whoIs('type'), $hasAccess)) {
				return true;
			}
			FireunAuthorize();
		}
	}