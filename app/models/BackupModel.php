<?php 	

	class BackupModel extends Base_model
	{

		public function __construct()
		{
			parent::__construct();

			$this->userModel = new User_model();
		}
		/*algortihm*/
		public function get_binary_structure($userid)
		{
			$user = $this->userModel->get_user($userid);

			$downlines = [];

			$users     = [];

			/*put userid in the downline*/
			$downlines[] = $user->id;


			$resultArray = [];
			do{

				$sql = "SELECT * FROM users where upline in ('".implode("','", $downlines)."')";

				$this->db->query(
					$sql
				);

				$result = $this->db->resultSet();

				if($result) {
					$downlines = [];
					foreach($result as $key => $row) 
					{
						$users[]     = $row;
						$downlines[$key] = $row->id;
					}

				}else{
					$downlines = [];
				}

			}while(!empty($downlines) or $downlines != false);

			return $users;
		}

		public function insert_users($usersForBackup)
		{	
			/*14526- lastid*/

			$address = 'change your address';

			$sql = '';
			foreach($usersForBackup as $key => $row) {

				$sql .= "INSERT INTO user_migrate(firstname , lastname , username, 
				password , direct_sponsor , upline , L_R  , user_type , 
				address , mobile , status , max_pair , is_activated , 
				activated_by , oldid)

				VALUES('$row->firstname' , '$row->lastname' , '$row->username' , 
				'$row->password' , '$row->direct_sponsor' , '$row->upline' , '$row->L_R'
				, '$row->user_type' , '$address' , '$row->mobile' , '$row->status' , 
				'$row->max_pair' , '$row->is_activated' , '$row->activated_by' , '$row->id');";

			};

			try{

				$this->db->query($sql);

				$this->db->execute();
				//get last id
			}catch(Exception $e){

				die(var_dump($e->getMessage()));
			}
		}
	}