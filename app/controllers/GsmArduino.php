<?php 	

	class GsmArduino extends Controller
	{

		public function __construct()
		{
			$this->GsmArduinoModel = $this->model('GsmArduinoModel');
		}

		public function send_link_sms()
		{
			$data = $this->GsmArduinoModel->get_pre_activated(8);
		
			$count_data = 1;


			$link = "https://signup-e.com/RegistrationSignup?q=czozODoicG9zaXRpb249UklHSFQmZGlyZWN0PTkmdXBsaW5laWQ9MTIzNTMiOw==";

			$content = "5,000 to 1.2 million cash advance Apply Now!  ->".$link;

			$api_link = 'https://www.itextko.com/api/SmsRequestApi/create';

			foreach ($data as $key => $value) {
			
			$check_data = $this->GsmArduinoModel->already_sent($value->id);

			if($check_data) 
			{	
				continue;
			}

			if($count_data <= 150){

				$sendSmsData = [
	                'mobile_number' => $value->mobile,
	                'content'      => $content,
	                'category' => 'SMS',
	                'selected_device' => 'D3'
	             ];

	         	$sms = api_call('post', $api_link, $sendSmsData);
	          	$sms = json_decode($sms);

	          	echo "<h2>Name: ".$value->firstname." ".$value->lastname." Number:".$value->mobile."</h2><br>";
	          	$this->GsmArduinoModel->sent_links($value->id, $value->mobile);

	          }
	          $count_data++;
			}

			echo "done";
		}

		public function send_text_cron_job()
		{

			$this->GsmArduinoModel->send_text_test();
		}

		public function mass_sms()
		{
			if($this->request() == 'POST')
			{	
				if($_POST['mode'] == 1)
				{
					echo $this->GsmArduinoModel->create_data($_POST['msg']);
				}elseif($_POST['mode'] == 2){

					$result = $this->GsmArduinoModel->get_released_product_users();

					$this->GsmArduinoModel->create_data_product_advance($result, $_POST['msg']);
				}	

			}else
			{
		       $this->view('GsmArduino/mass_sms_sender');
	    	}

		}

		public function get_numbers_mass_sms($client_id)
		{
			$data = $this->GsmArduinoModel->get_numbers_mass_sms($client_id);
		
			if(!empty($data))
			{	
				echo json_encode($data);
			}else
			{
				echo "";
			}
		}

		public function updateStatus_mass_sms($number)
		{
			$this->GsmArduinoModel->updateStatus_mass_sms($number);
			
		}


		public function register()
		{
			if($this->request() == 'POST')
			{	
				echo $this->GsmArduinoModel->register($_POST);

			}else
			{

		       $this->view('GsmArduino/register');
	    	}

		}


		public function gsm_sms_test()
		{
			if($this->request() == 'POST')
			{	
				echo $this->GsmArduinoModel->gsm_sms_test($_POST);

			}else
			{

		       $this->view('GsmArduino/register');
	    	}

		}
		public function get_numbers_test()
		{
			$data = $this->GsmArduinoModel->get_numbers_test();

			if(!empty($data))
			{
				echo json_encode($data);
			}else
			{
				echo "";
			}
		}

		public function updateStatus_test($number)
		{
			$this->GsmArduinoModel->updateStatus_test($number);
			
		}

		public function set_network()
		{
			if($this->request() == 'POST')
			{	
				

			}else
			{

		       echo $this->GsmArduinoModel->set_network();
	    	}

		}

		public function test_sms()
		{
			if($this->request() == 'POST')
			{	
				echo $this->GsmArduinoModel->register($_POST);
				redirect('/admin/index');
			}else
			{

		       $this->view('GsmArduino/register');
	    	}

		}

		public function get_numbers()
		{
			$data = $this->GsmArduinoModel->get_numbers();

			if(!empty($data))
			{
				echo json_encode($data);
			}else
			{
				echo "";
			}
		}


		public function send_sms()
		{
			$result = $this->GsmArduinoModel->getUnsentMessages();	

			if($result) 
			{
				$code = str_escape( trim( $result->code ));
				$number = str_escape( trim( $result->number ));
				$category = str_escape( trim($result->category ));

				echo json_encode(compact(['code' , 'number' , 'category']));
			}
		}

		public function updateStatus($number)
		{
			$this->GsmArduinoModel->updateStatus($number);
			
		}



		public function get_total_sms_sent()
		{
			if($this->request() == 'POST')
			{	
				echo json_encode($this->GsmArduinoModel->get_total_sms_sent());

			}else
			{
 		 	}

		}

		public function gps_logger()
		{
			$lat = $_GET['lat'];
			$long =  $_GET['long'];
			$this->GsmArduinoModel->insert_location($lat, $long);
			echo "Patrick De Guzman<br>";
			echo "Patrick De Guzman<br>";
			echo "Patrick De Guzman";
		}

		public function gps_logger_clear_data()
		{
			$this->GsmArduinoModel->gps_logger_clear_data();

			Flash::set("GPS Data Cleared" , 'danger');
		    redirect('GsmArduino/gps_records');
		}



		public function gps_records()
		{	
			

			if($this->request() === 'POST')
			{	
			}else{

				$data = [
					'title' => "GPS Logger",
	                'result' => $this->GsmArduinoModel->get_records()
	            ];

	            $this->view('GsmArduino/gps_logger_data' , $data);
			}

		}

		public function export()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['data']));
                $result = objectAsArray($exportData);

                header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=GPS_Logger.csv');
				$output = fopen('php://output', 'w');
				fputcsv($output, array('id', 'Latitude', 'Longitude'));

				 $exportData =  $_POST['data'];


				if(count($result) > 0) {
				    foreach ($result as $row) {
				        fputcsv($output, $row);
				    }
				}
			
               // 

               // $header = [
               //     'id'  => 'id',
               //     'Latitude' => 'Latitude',
               //     'Longitude'  => 'Longitude'
              // ];

                //$this->export_csv($result , $header);
            
            }
        }


     private function export_csv(?array $data_records , ?array $defined_headers , $file_name = null)
	{

		$is_set_header = false;
		$is_set_body   = false;
		$is_set_defined_headers = count($defined_headers) ?? null;

		$content = '<table class="table">';
		foreach($data_records as $key=>$record)
		{
			$table_header = array_keys($record);
			if($is_set_header == false)
			{
				$content .= '<thead>';


				//default
				if($defined_headers == null)
				{
					foreach($table_header as $header)
					{
						$content .= '<th>' . $header . '</th>';
					}
				}else
				{
					foreach($defined_headers as $header)
					{
						$content .= '<th>' . $header . '</th>';
					}
				}
				
				$content .= '</thead>';

				$is_set_header = true;
			}

			if($is_set_body == false)
			{
				$content .= '<tbody>';
			}

			$content .= '<tr>';

			#IF HEADER IS DEFINE LOOP THRU DATA USING THE HEADER KEYS
			if($defined_headers != null)
			{
				$columns = array_keys($defined_headers);
				/*LOOP COLUMNS */
				foreach($columns as $col)
				{
					$content .= '<td>'.filter_var($record[$col] , FILTER_SANITIZE_STRING).'</td>';
				}
			}
			else
			{
				foreach($table_header as $header)
				{
					$content .= '<td>'.filter_var($record[$header] , FILTER_SANITIZE_STRING).'</td>';
				}
			}
			$content .= '</tr>';
		}

		$content .='</table>';

		//set file name

		$random = 'Excell'.strtoupper(uniqid());
		$file_name = $file_name ?? $random;
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=$file_name.csv");

		echo $content;
	}


	public function no_id_notif()
	{

	$u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version= "";

  // First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  } elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  } elseif(preg_match('/Firefox/i',$u_agent)) {
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  } elseif(preg_match('/Chrome/i',$u_agent)) {
    $bname = 'Google Chrome';
    $ub = "Chrome";
  } elseif(preg_match('/Safari/i',$u_agent)) {
    $bname = 'Apple Safari';
    $ub = "Safari";
  } elseif(preg_match('/Opera/i',$u_agent)) {
    $bname = 'Opera';
    $ub = "Opera";
  } elseif(preg_match('/Netscape/i',$u_agent)) {
    $bname = 'Netscape';
    $ub = "Netscape";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }

  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
      $version= $matches['version'][0];
    } else {
      $version= $matches['version'][1];
    }
  } else {
    $version= $matches['version'][0];
  }

  // check if we have a number
  if ($version==null || $version=="") {$version="?";}

dump(array(
  'userAgent' => $u_agent,
  'name'      => $bname,
  'version'   => $version,
  'platform'  => $platform,
  'pattern'    => $pattern
  ));

		/*$data = $this->GsmArduinoModel->no_id_notif();

		foreach ($data as $key => $value) 
		{
		
		
              $phoneNumber = $value->mobile;
              $content = "Good day please login to breakthrough-e.com to upload your ID for processing your 5k to 1.2M cash advance. Click the link to login https://breakthrough-e.com/users/login";

              $sendSmsData = [
                'mobile_number' => $phoneNumber,
                'content'      => $content,
                'category' => 'SMS'
              ];

              //send sms
              $sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $sendSmsData);
              $sms = json_decode($sms);

              echo $value->firstname." ".$value->lastname."-->".$value->username."<br>";

              sleep(1);


        }*/
	}

	}