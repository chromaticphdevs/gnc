<?php
	require_once APPROOT.DS.'libraries/phpmailer_6/vendor/autoload.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	class MailMaker
	{
		private static $instance = null;

		private $phpmailer = null;

		private $recipientIsArray = false;

		//prevent Mailmaker from direct instanciation
		private function __construct(){

			$this->phpmailer = new PHPMailer(true);

			$this->setDefaults();
		}

		public static function getInstance()
		{
			if(self::$instance == null)
			{
				self::$instance = new MailMaker();
			}
			return self::$instance;
		}

		private function setDefaults()
		{
			$this->phpmailer->isSMTP();
			$this->phpmailer->Host       =  THIRD_PARTY['phpmailer']['host'];
			$this->phpmailer->Port       =  587;
			$this->phpmailer->SMTPAuth   =  true;
			$this->phpmailer->SMTPSecure = 'tls';
			$this->phpmailer->Username   =  THIRD_PARTY['phpmailer']['username'];
			$this->phpmailer->Password   =  THIRD_PARTY['phpmailer']['password'];
			$this->phpmailer->setFrom(THIRD_PARTY['phpmailer']['username'], THIRD_PARTY['phpmailer']['name']);
		}
		public function setSubject($subject)
		{
			$this->phpmailer->Subject = $subject;
			return $this;
		}

		public function setBody($body)
		{
			$this->phpmailer->Body = $body;
			return $this;
		}

		public function addCC($email)
		{
			if(!empty($email))
			$this->phpmailer->addCC($email);
		}

		public function addBCC($email , $name = null)
		{
			if(!empty($email))
			$this->phpmailer->addBCC($email, $name);
		}

		/*
		*@params email reciever ,
		*@params name  optional reciever name
		**/
		public function setReciever($email , $name = '')
		{
			$this->phpmailer->addAddress($email, $name);     // Add a recipient
			return $this;
		}

		public function setReplyTo($email , $name = '')
		{
			$this->replyTo = ['email' => $email , 'name' => $name];
			return $this;
			// $this->phpmailer->addReplyTo($email , $name);
		}

		public function addAttachment($path = null, $name = null, $encoding= null , $type= null)
		{
			if(is_null($encoding)) {
				$this->phpmailer->AddAttachment($path);
			}else{
				$this->phpmailer->AddAttachment($path, $name,  $encoding , $type);
			}

			return $this;
		}
		public function send()
		{
			if(isset($this->replyTo))
			{
				$this->phpmailer->addReplyTo($this->replyTo['email'], $this->replyTo['name']);
			}else
			{
				$this->phpmailer->addReplyTo(THIRD_PARTY['phpmailer']['replyTo'],THIRD_PARTY['phpmailer']['replyToName']);
			}

			$this->phpmailer->isHTML(true);
			try{
				$this->phpmailer->send();
			}catch(Exception $e)
			{

			}
			$this->phpmailer->clearAddresses();
			$this->phpmailer->clearAllRecipients();
			$this->phpmailer->clearAttachments();
		}


		public function convertArrayRecipient($recipient)
		{
			$has_commma = stripos($recipient , ",");

			if($has_commma){
				$this->recipientIsArray = true;
				return explode("," , $recipient);
			}
			return $recipient;
		}

		public function sendToMany($recieverList = array())
		{
			$this->phpmailer->SMTPKeepAlive = true;
			foreach($recieverList as $key => $receiver)
			{
				$this->phpmailer->addAddress($receiver , '');
				$this->phpmailer->isHTML(true);

				try {
					$this->phpmailer->send();
				} catch (Exception $e) 
				{
					
				}
				$this->phpmailer->clearAddresses();
				$this->phpmailer->clearAllRecipients();
				$this->phpmailer->clearAttachments();
			}
		}


	}
