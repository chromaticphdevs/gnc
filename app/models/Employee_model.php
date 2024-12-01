<?php

	class Employee_model extends Base_model
	{

		private $table_name = 'user_employees';


		public function index()
		{
			$this->login();
		}
		public function  create($emp)
		{

			extract($emp);

			$suffix = $this->username_suffix();

			$password = random_number() .'-'. $suffix;

			if($this->get_password($password))
			{
				//error
				Flash::set('Secret Exists');
				return false;
			}else
			{
				$this->db->query(
					"INSERT INTO $this->table_name(password , firstname , lastname , gender , access_type , job_name , hourly_rate)

					VALUES('$password' , '$firstname' , '$lastname' , '$gender' , '$access' ,'$job_name' , '$hourly_rate')"
				);

				$lastid = $this->db->insert();


				redirect('employee/list');
			}
			
		}

		public function get_password($pwd)
		{
			$this->db->query("SELECT * from $this->table_name where password = '$pwd'");

			$res = $this->db->single();

			if($res)
				return $res;
			return 0;
		}

		public function get_list($params = null)
		{
			$this->db->query("SELECT emp.* ,emp.id as empid , comp.name as compname , comp.id as compid 
				FROM $this->table_name as emp 
				left join tk_company as comp
				on comp.id = emp.companyid

				$params");

			return $this->db->resultSet();
		}
		public function logout($logid)
		{
			if($this->insert_action_log($logid , 'timeout'))
			{
				Flash::set('timed out');
				redirect('employee/login');
			}else
			{
				die("DIEEEE");
			}
		}
		public function login($emp,$rawImage)
		{
			extract($emp);

			return $this->login_emp($userid , $rawImage);
		}

		private function login_emp($userid , $rawImage)
		{

			$this->db->query("SELECT * FROM $this->table_name where id = '$userid'");

			$res = $this->db->single();

			if($res)
			{
				$userid = $res->id;

				//if no logs
				if(empty($this->get_last_log($userid)))
				{
					$image = $this->renderPhoto($rawImage);

					if($logid = $this->insert_emp_logs($userid , 'login'))
					{
						if($this->insert_log_image($logid , $image) && $this->insert_action_log($logid , 'timein'))
						{
							return [
								'status'  => true,
								'message' => 'user has logged in',
								'userid' => $userid
							];	
						}else
						{
							return [
								'status' => false ,
								'message' => 'Error on database'
							];
						}
					}else{
						return [
							'status' => false ,
							'message' => 'Error on database'
						];
					}
				}else
				{
					$isNotCheckedIn = $this->isNotCheckedIn($userid);
					if($isNotCheckedIn)
					{	
						//insert image
						$image = $this->renderPhoto($rawImage);

						if($logid = $this->insert_emp_logs($userid , 'login'))
						{
							if($this->insert_log_image($logid , $image) && $this->insert_action_log($logid , 'timein'))
							{
								return [
									'status'  => true,
									'message' => 'redirect to login',
									'userid' => $userid
								];
							}else
							{
								return [
									'status' => false ,
									'message' => 'Error on database'
								];
							}
						}else{
							return [
								'status' => false ,
								'message' => 'Error on database'
							];
						}
					}else
					{
						Flash::set('You are logged in a while ago.');
						
						return [
							'status'  => true,
							'message' => 'redirect to panel',
							'userid' => $userid
						];
					}
				}

				

			}else
			{
				Flash::set('Invalid Username / Password');
			}
			
			return false;
		}

		private function isNotCheckedIn($userid)
		{
			$ulog = $this->get_last_log($userid);

			if(!empty($ulog))
			{
				$this->db->query("
				SELECT * FROM user_emp_action_logs 
				where emp_logsid = '$ulog->id' and action = 'timeout' 
				");

				return $this->db->single();	
			}
			return false;
			
		}

		private function get_last_log($userid)
		{
			$this->db->query(
				"SELECT * from user_emp_logs where userid = '$userid' order by id desc limit 1");
			return $this->db->single();
		}
		private function get_latest_log($userid)
		{
			$this->db->query("SELECT id from user_emp_logs where userid = '$userid' order by id desc");


			$res = $this->db->single();

			if($res)
				return $res->id;
			return 0;
		}
		private function insert_emp_logs($userid , $action)
		{
			$this->db->query("INSERT INTO user_emp_logs(userid) VALUES('$userid')");

			return $this->db->insert();
		}

		private function insert_log_image($logid , $image)
		{
			$this->db->query("INSERT INTO user_emp_log_pictures(emp_logsid , image) VALUES('$logid' , '$image')");

			return $this->db->insert();
		}
		private function username_suffix()
		{
			$this->db->query("SELECT max(id) as key_id from $this->table_name");

			$res = $this->db->single();

			if($res)
			{
				return $res->key_id;
			}else
			{
				return 1;
			}
		}

		private function insert_action_log($logid , $action)
		{
			$this->db->query("INSERT INTO user_emp_action_logs(emp_logsid , action) VALUES('$logid' , '$action')");

			return $this->db->insert();
		}

		//photo render
		private function renderPhoto($image)
		{
			$img = $image;
		    $folderPath = PUBLIC_ROOT.DS.'assets/';
		  
		    $image_parts = explode(";base64,", $img);
		    $image_type_aux = explode("image/", $image_parts[0]);
		    $image_type = $image_type_aux[1];
		  
		    $image_base64 = base64_decode($image_parts[1]);
		    $fileName = uniqid() . '.png';
		  
		    $file = $folderPath . $fileName;
		    file_put_contents($file, $image_base64);

		    return $fileName;
		}
	}