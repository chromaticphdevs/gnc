<?php

	class Itext extends Controller
	{


		
		public function send($number)
		{	
			
				$code1=random_number();
				$code2=random_number();
				$code3=random_number();
				$CODE=substr($code1,0,2).''.substr($code2,0,2);


				$message = "TEST code = ".$CODE;

				itexmo($number,$message , ITEXMO,ITEXMO_PASS);	


		}


	}