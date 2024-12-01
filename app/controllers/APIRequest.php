<?php 	

	class APIRequest extends Controller
	{


		public function connect()
		{
			
			// $curl = curl_init();

			$url = "http://www.socialnetwork-e.com/APITest/get_commissions";

			// curl_setopt($curl, CURLOPT_URL, $url);

			// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			// curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

			// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			// curl_setopt($curl, CURLOPT_POST, 1);

			// curl_setopt($curl , CURLOPT_POSTFIELDS , json_encode($postData));

			

			$postData = [
				"name"   => "Mark Angelo Gonzales" , 
				"age"    => "21" ,
				"gender" => "Male"
			];

			$data_string = json_encode($postData);                                                                                   
			$ch = curl_init($url); 
			                                                                     
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen($data_string))                                                                       
			);                                                                                                                   


			$output = curl_exec($curl);

			print_r($output);


			curl_close($curl);

		}
	}