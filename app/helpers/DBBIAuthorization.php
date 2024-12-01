<?php 	

	class DBBIAuthorization
	{

		public static function setAccess(array $hasAccess ,$sessionName = 'user',$callBack = null)
		{
			if(Session::check($sessionName)){
				$user = Session::get($sessionName);
				if(!in_array($user['type'], $hasAccess)){
					FireunAuthorize();
				}
			}else{
				if(is_null($callBack)){
					redirect('users/login');
				}else{
					$callBack(); //run var as function
				}
				
			}
		}
	}