<?php
	
	function user_page_focus_redirect_to($user_page_focus) {
		$redirectTo = '';
		switch($user_page_focus) {
			case PAGE_AUTO_FOCUS['UPLOAD_ID_PAGE']:
				$redirectTo = '/UserIdVerification/upload_id_html';
			break;

			case PAGE_AUTO_FOCUS['REFERRAL_PAGE']:
				$redirectTo = '/UserDirectsponsor/index';
			break;

			case PAGE_AUTO_FOCUS['BANK_DETAIL_PAGE'] :
				$redirectTo = '/UserBankController/index';
			break;

			break;

			case PAGE_AUTO_FOCUS['CASH_ADVANCE_PAGE']:
				$redirectTo = '/LoanController/requirements';
			break;

			default:
				$redirectTo = '/FNCashAdvance/index';
		}

		return $redirectTo;
	}
	function convert_to_number($string)
	{
		return preg_replace("/[^0-9.]/", "", $string);
	}

	function number_only($string)
	{
		return preg_replace("/[^0-9]/", "", $string);
	}
	
	function _wordLib() {
		$response = require_once APPROOT.DS.'config/words.php';
		return $response;
	}
	function _products() {
		return [
			1 => [
				'id' => 1, 'name' => 'BREAKTHROUGH COFFEE - STARTER', 'amount' => '300.00'
			],
			2 => [
				'id' => 2, 'name' => 'BREAKTHROUGH COFFEE - GOLD', 'amount' => '400.00'
			],
			3 => [
				'id' => 3, 'name' => 'BREAKTHROUGH COFFEE - DISTRIBUTOR','amount' => '500.00'
			]
		];
	}

	function uncommon_sort_qualifers($a, $b) {
        return strcmp($b->directTotal,$a->directTotal);
    }	

	
	/*Valid Parameters*/

	/*
	*$sendSmsData = [
	    'mobile_number' => $res->mobile,
	    'code'      => $OTP_code,
	    'category' => 'OTP'
	 ];
	*
	*/
	function SMS( $smsData = [] )
	{
		$sms = api_call('post','https://www.itextko.com/api/SmsRequestApi/create' , $smsData);
	}
	
	function tocPosition($paymentTotal)
	{	

		if( $paymentTotal >= 280 && $paymentTotal <= 1405 )
			return 2;

		if( $paymentTotal > 1405 && $paymentTotal <= 2485 )
			return 3;

		if( $paymentTotal > 2485 && $paymentTotal <= 3445 )
			return 4;

		if( $paymentTotal > 3445 && $paymentTotal <= 4565 )
			return 5;

		if( $paymentTotal > 4565 && $paymentTotal <= 5845 )
			return 6;

		if( $paymentTotal > 5845 && $paymentTotal <= 7285 )
			return 7;

		if( $paymentTotal > 7285 && $paymentTotal <= 8885 )
			return 8;

		if( $paymentTotal > 8885 && $paymentTotal <= 10805 )
			return 9;


		if( $paymentTotal > 10805 && $paymentTotal <= 13045 )
			return 10;

		if( $paymentTotal > 13045 && $paymentTotal <= 15605 )
			return 11;

		if( $paymentTotal > 15605 && $paymentTotal <= 18485 )
			return 12;

		if( $paymentTotal > 18485 && $paymentTotal <= 21685 )
			return 13;

		if( $paymentTotal > 21685 && $paymentTotal <= 25525 )
			return 14;

		if( $paymentTotal > 25525 && $paymentTotal <= 30005 )
			return 15;

		if( $paymentTotal > 30005 && $paymentTotal <= 34805 )
			return 16;

		if( $paymentTotal > 34805 && $paymentTotal <= 40565 )
			return 17;

		if( $paymentTotal > 40565 && $paymentTotal <= 46325 )
			return 18;
	}

	function model($model,$constructorParam = [])
	{
		$model  = ucfirst($model);

		if(file_exists(MODELS.DS.$model.'.php')){
			require_once MODELS.DS.$model.'.php';

			if (!empty($constructorParam)) {
				return new $model(...$constructorParam);
			}
			return new $model;
		}
		else{
			die($model . 'MODEL NOT FOUND');
		}
	}
	
	function activationlevels()
	{
		$levels = [
			'starter' , 'bronze' , 'silver' , 'gold' , 'platinum' , 'diamond', 'Product Loan', 'Rejuve Set', 'Rejuve Set for Activated', 'Product Repeat purchase'
		];

		return array_map('strtoupper', $levels);
	}

	function stocktypes()
	{
		$stocktypes = [
            'box',
            'item',
            'sack',
            'kilo',
        ];

        return array_map('strtoupper' , $stocktypes);
	}
	

	function code_library_category()
	{
		$category = [
			'activation', 'non-activation'
		];

		return array_map('strtoupper', $category);
	}

	function flash_err($message = null)
	{
		if(is_null($message)) {
			$message = "SNAP! something went wrong please contact the webmasters";
		}

		Flash::set($message , 'danger');
	}

	function err_nosession($sessionName = null , $url = null)
	{
		$isError = false;
		if(!is_null($sessionName))
		{
			if(is_array($sessionName))
			{
				$isOk = false;
				foreach($sessionName as $key => $row) {
					if(isset($_SESSION[$sessionName]))
						$isOk = true;
				}
				if(!$isOk)
					$isError = true;
			}else{
				if(!isset($_SESSION[$sessionName]))
					$isError = true;
			}
		}else{
			if(!isset($_SESSION['USERSESSION']))
				$isError = true;
		}

		if($isError){
			Flash::set("Something went wrong , please try again" , 'danger');
			if(is_null($url)) {
				return redirect("users/login");
			}else{
				return redirect($url);
			}
		}
	}


	function err_default()
	{
		Flash::set("Something went wrong , please try again" , 'danger');
		return redirect("users/login");
	}

	function ee($data)
	{
		echo json_encode($data);
	}

	function api_response($data , $status = TRUE)
	{
		return json_encode([
			'status' => $status,
			'data'   => $data
		]);
	}
	function validate_mobile($mobile)
	{
		return preg_match('/^[0-9]{11}+$/', $mobile);
	}

	function validate_email($email)
	{
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			return false;
		return true;
	}

	function sum_number($numbers = array()) {

		$total = 0;
		foreach($numbers as $key => $row) {

			$total += $row;
		}

		return $total;
	}

	function compress_img($file)
	{
		$image = new ImageResize($file);
		$image->scale(50);
		$image->save('sampler123.jpg');

		try{
			$image->save('test_lang');
			echo 'OK';
		}catch(Exception $e)
		{
			echo $e->getMessage();
		}

	}


	function check_access()
	{
		$canAccess = false;

		if(Session::check('USERSESSION') && Session::get('USERSESSION')['type'] == '1')
		{
			$canAccess = true;
		}

		if(Session::check('BRANCH_MANAGERS')){
			$canAccess = true;
		}

		var_dump(Session::check('BRANCH_MANAGERS'));
	}

	function isSubmitted()
    {
        $request = $_SERVER['REQUEST_METHOD'];

        if(strtolower($request) === 'post')
            return true;
        return false;
    }
	
	// ITEXMO SEND SMS API - PHP - CURL METHOD
	// Visit www.itexmo.com/developers.php for more info about this API

	function itexmo($number,$message,$apicode,$passwd = null)
	{
		$ch = curl_init();

		/** IF PASSWORD PARAMETER IS NULL USE DEFAULT PASSWORD */
		if(is_null($passwd)) {
			$passwd = ITEXMO_PASS;
		}

		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
		curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
		curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
					http_build_query($itexmo));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
		curl_close ($ch);
	}


	//return sim network (SMART, TnT, GLOBE, TM, SUN)
	function sim_network_identification($number)
	{

		$number_prefix = substr($number,0,4);


		$Smart_TNT=array("dummy_data","0907","0908","0909","0910","0911","0912","0913","0914","0968","0969","0970","0971","0981","0982","0989","0992","0998","0999","0919","0920","0921","0929","0930","0938","0939","0940","0946","0947","0948","0949","0950","0951","0960","0961","0968","0969","0970","0918");

		$Globe_TM=array("dummy_data","0965","0966","0967","0975","0994","0995","0997","0915","0916","0917","0926","0927","0928","0935","0936","0945","0953","0954","0955","0956","0963","0964","0906","0905","0977","0978","0979","0996","0987");

		$SUN=array("dummy_data","0972","0922","0923","0924","0925","0931","0932","0933","0934","0941","0942","0943","0944","0952","0962");

		if(!empty(array_search($number_prefix,$Smart_TNT)))
		{
			$network="Smart or TNT";
		}
		elseif(!empty(array_search($number_prefix,$Globe_TM)))
		{
			$network="Globe or TM";
		}
		elseif(!empty(array_search($number_prefix,$SUN)))
		{
			$network="Sun";
		}else
		{
			$network="unidentified";
		}
		return $network;
	}


	function itexmoCurl($data = false)
	{
		$url = "https://www.itexmo.com/php_api/apicode_info.php?apicode=ST-BREAK884834_MERSX";
            $method = 'GET';

            $curl = curl_init();
            switch ($method)
            {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);

                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_PUT, 1);
                    break;
                default:
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }


            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($curl);

			curl_close($curl);

			$result = json_decode($result);

			$result =$result->{"Result "};

			return $result;
	}

	function crop_string($string , $length = 20)
    {
        if(strlen($string) > $length)
        {
            return substr($string, 0 , $length) . ' ...';
        }return $string;
	}


	function export(?array $data_records , ?array $defined_headers , $file_name = null)
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
		header("Content-Type:application/xls");
		header("Content-Disposition: attachment; filename=$file_name.xls");

		echo $content;
	}

	function objectAsArray($exportData)
	{
		$converted = [];

		foreach($exportData as $count => $item)
		{
			$converted []  = get_object_vars($item);
		}

		return $converted;
	}


	function upload_file($filename , $uploadPath)
	{
		$uploadFile = new UploaderFile();

		$uploadFile->setFile($filename)
		->setPath($uploadPath)
		->upload();

		if(!empty($uploadFile->getErrors()))
				return [
						'status' => 'failed' ,
						'result' => [
								'err'  => $uploadFile->getErrors(),
								'name' => $uploadFile->getName()
						]
				];

		return [
				'status' => 'success',
				'result' => [
						'name' => $uploadFile->getName() ,
						'oldname' => $uploadFile->getNameOld(),
						'extension' => $uploadFile->getExtension(),
						'path'   => $uploadFile->getPath()
				]
		];
	}

	function upload_image($filename , $uploadPath)
    {
        $uploaderImage = new UploaderImage();

        $uploaderImage->setImage($filename)
        ->setPath($uploadPath)
        ->upload();

        if(!empty($uploaderImage->getErrors()))
            return [
                'status' => 'failed' ,
                'result' => [
                    'err'  => $uploaderImage->getErrors(),
                    'name' => $uploaderImage->getName()
                ]
            ];

        return [
            'status' => 'success',
            'result' => [
                'name' => $uploaderImage->getName() ,
                'oldname' => $uploaderImage->getNameOld(),
                'extension' => $uploaderImage->getExtension(),
                'path'   => $uploaderImage->getPath()
            ]
        ];
    }


	function path_upload($args = null)
	{
		return PUBLIC_ROOT.DS.'uploads'.DS.$args;
	}

	function path_upload_get($args = null)
	{
		return URL.DS.'public'.DS.'uploads'.DS.$args;
	}

	function dd($data)
	{

		$data = json_encode($data);
		print_r($data);
		// die();
	}

	function dump($data)
	{
		echo '<pre>';
			print_r($data);
		echo '</pre>';
		die();
	}

	function str_escape($value)
  {
      $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
      $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

      return str_replace($search, $replace, $value);
  }

	function writeLog($file , $log)
	{
		$path = PUBLIC_ROOT.DS.'writable';

		if(!is_dir($path)){
			mkdir($path);
		}

		$fileName = $path.DS.$file;

		$myfile = fopen($fileName, "a") or die("Unable to open file!");

		fwrite($myfile, $log);

		fclose($myfile);
	}
	
	 function api_call($method, $url, $data = false)
    {
        $curl = curl_init();

        switch (strtoupper($method))
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        return $result;
        curl_close($curl);
	}
	

	function ROUTER_CONTROLLER_RUN($handler , $parameters = [])
	{
		$handler = explode('@' , $handler);
		
		list($controller , $action) = $handler;

		require_once('../app/controllers/'.$controller.'.php');

		$controller = new $controller;

		call_user_func_array([$controller , $action], $parameters);
	}

	function whoIs($prop = null)
	{
		$user = null;

		if(!empty(Session::get('USERSESSION')) ){
			$user = Session::get('USERSESSION');
			$user['whoIs'] = 'user';
		}

        if(!is_null($prop)){
            if(is_array($prop)) 
            {
                $str = '';
                foreach($prop as $key => $row) {
                    if($key >= 0)
                        $str .= " "; 
                    if(is_array($user)) {
                        $str.= $user[$row];
                    } else {
                        $str .= $user->$row;
                    }
                }
                return trim($str);
            } else {
                if(is_array($user))
                    return $user[$prop];
                if(is_object($user))
                    return $user->$prop;  
            }
        } 

        return $user ?? '';
	}

	function _route($routeParam , $parameterId = '' , $parameter = [])
    {
        $routeParam = explode(':' , $routeParam);

        $routeKey = '';
        $method  = '';

        if( count($routeParam) > 1) {
            list( $routeKey , $method) = $routeParam;
        }

        $parameterString = '';

        if( !empty($parameterId) )
        {
            if(is_array($parameterId))
            {
                $parameterString .= "?";

                $counter = 0;
                foreach($parameterId as $key => $row) 
                {
                    if( $counter > 0)
                        $parameterString .= "&";

                    $parameterString .= "{$key}={$row}";
                    $counter++;
                }
            }else{
                //parameter is id
                $parameterString = '/'.$parameterId.'?';
            }
        }

        if(is_array($parameter) && !empty($parameter))
        {
            if( empty($parameterString) )
                $parameterString .= '?';
            $counter = 0;
            foreach($parameter as $key => $row) 
            {
                if( $counter > 0)
                    $parameterString .='&';
                $parameterString .= "{$key}={$row}";
                $counter++;
            }
        }

		return "/{$routeKey}/{$method}{$parameterString}";
    }


	function authRequired() {
		if(empty(whoIs())) {
			Flash::set("You are not authorized to access this page.");
			return redirect(BASECONTROLLER);
		}
		
		return true;
	}

	function get_session_type()
	{
		$type = null;
		if(Session::check('BRANCH_MANAGERS'))
		{	
			$type = 'manager';
		}else if(Session::check('USERSESSION'))
		{	
			$type = 'user';
		}
		
		return $type;
	}


	function csrf()
	{
		$csrf = get_token_random_char(19);
		Session::set('csrf' , $csrf);
		return $csrf;
	}

	function csrfValidate($csrf)
	{
		if( isEqual( Session::get('csrf') , $csrf ))
			return true;
		return false;
	}

	function load(array $pathOrClass , $path = null)
    {
      if(is_null($path)) {
        foreach($pathOrClass as $key => $row) {
          require_once $row.'.php';
        }
      }else{
        foreach($pathOrClass as $key => $row) {
          require_once $path.DS.$row.'.php';
        }
      }
    }

	function _mail($receiver , $subject , $body , $emailCc = null , $emailBCc=null)
	{

		$GLOBALS['func_error'] = '';

		$mailer = MailMaker::getInstance();

		$mailer->setSubject($subject)
		->setBody($body);

		if(!is_null($emailCc) && !empty($emailCc))
		{
			if(is_array($emailCc)) {
				foreach($emailCc as $cc) {
					$mailer->addCC($cc);
				}
			}else{
				$mailer->addCC($emailCc);
			}
		}


		if(!is_null($emailBCc) && !empty($emailCc))
		{
			if(is_array($emailBCc)) {
				foreach($emailBCc as $bcc) {
					$mailer->addBCC($bcc);
				}
			}else{
				$mailer->addBCC($emailBCc);
			}
		}

		if(is_array($receiver))
		{
			try
			{
				$mailer->sendToMany($receiver);
			}catch(Exception $e)
			{
				$GLOBALS['func_error'] = "Email fatal error.";
				return false;
			}
		}else
		{
			$mailer->setReciever($receiver);
			
			try{

				if(URL == 'http://dev.bk_mlm') {
					echo $body;
					die();
				}
				$mailer->send();
				return true;
			}catch(Exception $e) {
				$GLOBALS['func_error'] = "Email fatal error.";
				return false;
			}
		}

		return true;
	}

	function listOfValidIds() {
		return [
			'Philippine passport',
			'Drivers license',
			'SSS UMID Card',
			'PhilHealth ID',
			'TIN Card',
			'Postal ID',
			'Voters ID',
			'Professional Regulation Commission ID',
			'Senior Citizen ID',
			'OFW ID',
			'Company ID',
			'NBI Clearance',
			'Police Clearance',
			'School ID',
			'Barangay Clearance',
			'Barangay ID',
			'Fraternity ID',
			'Selfie With ID',
			'Other ID'
		];
	}

	function _unitTest($conditionTrue, $message) {
		$db = Database::getInstance();
		$dateTime = today();
		if($conditionTrue) {
			$result = "CORRECT";
		} else {
			$result = "FAIL";
		}

		$db->query(
			"INSERT INTO dev_system_logs(result, message, created_at)
				VALUES('{$result}', '{$message}', '{$dateTime}')"
		);

		return $db->execute();
	}

	function createReferralLink($userId = null) {
		$userId = is_null($userId) ? whoIs()['id'] : $userId;
		$shortenerLinkModel = model('LinkShortenerModel');
	  
		$linkLeft = seal(['user_id' => $userId, 'position' => 'LEFT', 'upline' => $userId]);
		$leftLinkRedirectTo = URL.DS."/UserController/referralLink?q={$linkLeft}";
	  
		$shortenedLink = $shortenerLinkModel->add($leftLinkRedirectTo, whoIs('username'), whoIs('id'));
		$shortenedLink = $shortenerLinkModel->getShortenedLink($shortenedLink->shortened_key);

		return $shortenedLink;
	}

	/**
	 * entries
	 * 5,10,2
	 */
	function convertInterestRateToDecimal($interestRate) {
		$retVal = 0.0;
		//convert to percentage decimal
		if($interestRate < 10) {
			$retVal = floatval("0.0$interestRate");
		} else {
			$retVal = floatval("0.{$interestRate}");
		}
		return $retVal;
	}