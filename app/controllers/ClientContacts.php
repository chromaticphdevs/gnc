<?php

	class ClientContacts extends Controller
	{	
		 public function __construct()
        {
            $this->ClientContactsModel = $this->model('ClientContactsModel');
            $this->UserNumberModel = $this->model('UserNumberModel');
        }


		public function index()
		{	
			err_nosession();

			$userInfo = SESSION::get("USERSESSION");
			$mainForm = 'formPurchaseAndPay';

			$data = [
			  'userInfo' =>$userInfo,
	          'input' => [
	            'required' => [
	              'form' => $mainForm,
	              'class' => 'form-control',
	              'required' => ''
	            ],

	            'form' => $mainForm
	          ]
	        ];
			return $this->view('contact_collection/index',$data);
		}


		public function contacts()
		{	
			err_nosession();

			$userInfo = SESSION::get("USERSESSION");
			$mainForm = 'formPurchaseAndPay';

			$data = [
			  'userInfo' =>$userInfo,
			  'contact_list' => $this->ClientContactsModel->get_contacts($userInfo['id']),
	          'input' => [
	            'required' => [
	              'form' => $mainForm,
	              'class' => 'form-control',
	              'required' => ''
	            ],

	            'form' => $mainForm
	          ]
	        ];
			return $this->view('contact_collection/contacts',$data);
		}

		public function save_contacts()
		{	
			err_nosession();

			$post = request()->inputs();

			$number2_temp = '';
			if(isset($post['number2']))
			{
				$number2_temp=$post['number2'];
			}

			$check_number = $this->ClientContactsModel->check_number($post['number1'],$number2_temp);
			if ($check_number ) {
				Flash::set("Mobile number Already Used {$check_number->number}","warning");
      			return request()->return();
			}

			$check_number1 =  $this->UserNumberModel->check_number($post['number1']);

            if($check_number1)
            {
              
                Flash::set('Mobile number Already Used','warning');
                return request()->return();
            }

            if(isset($post['number2']))
            {
	            $check_number2=  $this->UserNumberModel->check_number($post['number2']);

	            if($check_number2)
	            {
	              
	                Flash::set('Mobile number Already Used','warning');
	                return request()->return();
	            }
	        }   


			$result = $this->ClientContactsModel->save($post);

			if(!$result)
			{	
				Flash::set('Error please Try Again','warning');
				return request()->return();
			}

			Flash::set("Contacts Saved");

			$user_social_media = check_user_social_media($post['user_id']);

			if($user_social_media == 0 AND isset($post['number2']))
			{
				redirect('UserSocialMedia/add_link');
			}else{
				return request()->return();
			}
      		
		}

		public function send_link($number)
		{
			err_nosession();

			$content = "5,000 to 1.2 million cash advance Apply Now!  ->".getUserLink();

			$api_link = 'https://www.itextko.com/api/SmsRequestApi/create';

			$sendSmsData = [
                'mobile_number' => $number,
                'content'      => $content,
                'category' => 'SMS'
             ];

         	$sms = api_call('post', $api_link, $sendSmsData);
          	$sms = json_decode($sms);

          	Flash::set("Link Sent");
          	return request()->return();
		}

	}
?>
