<?php

	function get_token_random_char($length = 12 , $prefix = false)
	 {
		 $bytes = random_bytes($length);

		 if($prefix)
			 return $prefix.'-'.strtoupper(substr(bin2hex($bytes), 0 , $length));
		 return strtoupper( substr(bin2hex($bytes), 0 , $length) );
	 }

	function random_gen($length = 12){

		$bytes = random_bytes($length);

		return substr(bin2hex($bytes), 0 , $length);
	}


	function random_number($length = 12)
    {
      $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(1, 9);
        }

        return $result;
    }
    
	function to_number($number)
	{
		return number_format($number , 2);
	}

	function var_dump_pre($data)
	{
		echo '<pre>';
			var_dump($data);
		echo '</pre>';
	}


	function seal($val = null)
	{
		try{
			if($val == null)
			{
				throw new Exception("Cannot Serialize Null value");
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
			die();
		}


		return base64_encode(serialize($val));
	}

	function unseal($val = null)
	{
		try{
			if(!unserialize(base64_decode($val)))
			{
				throw new Exception("String is not Serialized Properly");
			}
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}

		return unserialize(base64_decode($val));
	}
