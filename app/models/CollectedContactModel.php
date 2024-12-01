<?php

	class CollectedContactModel extends Base_model
	{
		public $table = 'collected_contacts';
		public $table_name = 'collected_contacts';


		public function __construct()
		{
			parent::__construct();

			$this->user = model('User_model');
		}


		public function storeMultiple($contacts = [])
		{	

			if( empty($contacts) ){
				$this->addError("Contacts cannot be empty");
				return false;
			}
			//get network
			$contactsWithNetwork = [];

			$today = today();

			//set direct to null
			$direct =  null;

			foreach($contacts as $key => $row)
			{
				$mobileNumber = trim( str_escape($row->mobile_number) );

				//set direct sponsor
				if( is_null($direct) )
					$direct = $row->direct;

				$userExist = $this->getByNumber( $mobileNumber );

				if($userExist)
					continue;

				$contactsWithNetwork [] = [
					'mobile_network' => sim_network_identification($mobileNumber),
					'mobile_number'  => $mobileNumber,
					'name'           => $row->name,
					'direct'         => $row->direct,
					'created_at'     => $today
				];
			}

			$sql = " INSERT INTO {$this->table}(mobile_number , mobile_network , name , direct , created_at) VALUES";

			$directName = 'Breakthrough International';

			$registrationLink = getUserLink($direct , $direct);

			$user = $this->user->get_user( $direct );

			if($user)
				$directName = $user->firstname;

			$saveContacts = [];
			//save contacts


			if( empty($contactsWithNetwork) ){
				$this->addError("All contacts has been already notified");
				return false;
			}

			foreach($contactsWithNetwork as $key => $row) 
			{

				$mobileNumber = trim( $row['mobile_number'] );
				$name = trim($row['name']);

				$content = "Join our cash assistance program without collateral!";
				
				$content .= " you are referred by {$directName}";
				$content .= " Click the link to join :";
				$content .= $registrationLink;

				SMS( [
					'mobile_number' => $mobileNumber,
					'content' => $content ,
					'category' => 'SMS'
				]);

				if( $key > 0)
					$sql .= " , ";
				
				$sql .= "('{$mobileNumber}' , '{$row['mobile_network']}' , 
				'{$name}' , '{$row['direct']}' , '{$row['created_at']}')";
			}

			$this->db->query( $sql );

			return $this->db->execute();
		}


		private function getByNumber($mobileNumber)
		{
			$mobileNumber = trim( str_escape($mobileNumber) );

			$this->db->query(
				"SELECT * FROM {$this->table}
					WHERE mobile_number = '{$mobileNumber}'"
			);

			return $this->db->single();
		}
		public function store($val)
		{
			$mobileNumber = trim( str_escape($val['mobileNumber']) );

			$this->db->query(
				"SELECT * FROM {$this->table}
					WHERE mobile_number = '{$mobileNumber}'"
			);
			//search user

			$isExist = $this->db->single();

			if($isExist){
				$this->addError("Mobile Number already exists");
				return false;
			}

			$res = parent::store([
				'mobile_number'  => $mobileNumber,
				'name'           => $val['name'],
				'mobile_network' => $val['mobile_network'],
				'direct'         => $val['direct'],
				'created_at'     => today()
			]);

			if(!$res) {
				$this->addError(" Something went wrong with our database ");
				return false;
			}


			return true;
		}
	}