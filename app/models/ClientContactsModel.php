<?php

	class ClientContactsModel extends Base_model
	{
		
		public function save($data)
		{	
			extract($data);	

			if(empty($number1))
			{
				return false;
			}

			$number1 = str_replace(' ', '', $number1);

			$content = "5,000 to 1.2 million cash advance Apply Now!  ->".getUserLink();

			$api_link = 'https://www.itextko.com/api/SmsRequestApi/create';

			 $sendSmsData = [
                'mobile_number' => $number1,
                'content'      => $content,
                'category' => 'SMS'
             ];

          	//send sms
         	$sms = api_call('post', $api_link, $sendSmsData);
          	$sms = json_decode($sms);


          	$sql = "INSERT INTO user_contacts(`userid` , `contact_name`, `number` )
				VALUES('$user_id' , '$name1' , '$number1')";


          	if(isset($number2))
          	{
	          	$number2 = str_replace(' ', '', $number2);
		        $sendSmsData = [
		            'mobile_number' => $number2,
		            'content'      => $content,
		            'category' => 'SMS'
		        ];

		        //send sms
		        $sms = api_call('post',$api_link , $sendSmsData);
		        $sms = json_decode($sms);

		        $sql .= ",('$user_id' , '$name2' , '$number2')";
	    	}

			$this->db->query($sql);

			try
			{
				$this->db->execute();
				return true;
			}catch(Exception $e)
			{
				die($e->getMessage());
				return false;
			}
		}

		public function check_number($number1, $number2)
		{
			$this->db->query("SELECT * 
							  FROM user_contacts 
							  WHERE `number` = '$number1' || `number` = '$number2' ");

			return $this->db->single();
		}

		public function get_contacts($userid)
		{
			$this->db->query("SELECT * 
							  FROM user_contacts 
							  WHERE `userid` = '$userid'");

			return $this->db->resultSet();
		}

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
	   		$this->db->execute();
		}

		public function get_date_today()
		{
			date_default_timezone_set("Asia/Manila");
			return date("Y-m-d");
		}
	}
