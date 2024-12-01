<?php 	

	function isEqual($subject , $toMatch)
	{
		$subject = strtolower(trim($subject));

        if(is_array($toMatch))
         return in_array($subject , array_map('strtolower', $toMatch));
        return $subject === strtolower(trim($toMatch));
	}

	function keypairtostr($arr)
	{
		$strArr = '';

		foreach($arr as $key => $value){
			$strArr .= " {$key} = '$value'";
		}
		
		return $strArr;
	}

    function str_link_fix($link) {
        return str_replace('\\', '/', trim($link));
    }

	function strObscure($string , $startAt = 0)
    {
        $cutString = substr($string , $startAt);
        
        $strReplaceCount = strlen($cutString);

        $obscuredTexts = '';

        for($i = 0 ; $i < $strReplaceCount ; $i++)
        {
            $obscuredTexts .= '*';
        }

        return substr_replace($string , $obscuredTexts , $startAt);
    }