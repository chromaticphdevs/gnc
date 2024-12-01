<?php 	
	
	require LIBS.DS.'messagejet/vendor/autoload.php';
  	use \Mailjet\Resources;
	class Mailer
	{
		//if want to get instance
		private static $instance = null;

		private $messageJet = null;

		private $error;
		public function __construct()
		{
			$this->messageJet = new \Mailjet\Client('1484df1bc9ec31a7278878ef3da06cec','09df8e7ede863620a7798c7de63b11d5',true,['version' => 'v3.1']);
		}

		public function getInstance()
		{
			if(self::$instance == null){
				self::$instance = new Mailer();
			}

			return self::$instance;
		}

		public function setFrom($email , $name)
		{
			$this->from = [
				'Email' => $email ,
				'Name'  => $name
			];
			return $this;
		}

		public function setTo($email , $name)
		{
			$this->to = [
				'Email' => $email ,
				'Name'  => $name
			];
			return $this;
		}

		public function setSubject($subject)
		{
			$this->subject = $subject;
			return $this;
		}

		public function setBody($body)
		{
			$this->body = $body;
			return $this;
		}

		public function send()
		{
			try
			{	$body= [
			     
			        'Messages' => [
			          [
			            'From'     => [$this->from],
			            'To'       => [$this->to],
			            'Subject'  => $this->subject,
			            'TextPart' => "A text",
			            'HTMLPart' => $this->body,
			            'CustomID' => "AppGettingStartedTest"
			          ]
			        ]
			      ];

			    $response = $this->messageJet->post(Resources::$Email, ['body' => $body]);
			    
			    if($response->success())
			    {
			    	return true;
			    }else
			    {
			    	return false;
			    }
			}catch(Exception $e)
			{
				echo $e->getMessage();
			}
		}

		private function prepareMail()
		{
			return [
	        'Messages' => [
	          [
	            'From' => $this->from,
	            'To' => $this->to,
	            'Subject' => $this->subject,
	            'HTMLPart' => $this->body,
	            'CustomID' => "AppGettingStartedTest"
	          ]
	        ]
	      ];
		}

		public function error()
		{
			return $this->error;
		}
	}