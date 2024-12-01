<?php 	

	class LDDevicetokenModel extends Base_model
	{
		private $table_name = 'ld_device_tokens';

		public function create($numoftoken)
		{
			$queryMaker = " INSERT INTO $this->table_name(code , token) VALUES";

			$counter = 0;

			for($i = 0 ; $i <= $numoftoken ; $i++)
			{
				$code  = $this->code_maker();
				$token = $this->token_maker();

				if($counter <  $i) 
				{
					$queryMaker .= ',';

					$counter++;
				}

				$queryMaker .= "('$code' , '$token')";
			}

			try
			{
				$this->db->query($queryMaker);

				$this->db->execute();

				return true;
			}catch(Exception $e) {
				die($e->getMessage());
			}
		}

		public function get_list($params = null)
		{
			$this->db->query(
				"SELECT * FROM $this->table_name order by id desc "
			);

			return $this->db->resultSet();
		}


		private function code_maker()
		{
			return random_number(2).'-'.random_number(4). '-' .random_number(3);
		}

		private function token_maker()
		{
			$newToken = md5(uniqid('m@rkPogi( .)( .)', true)).md5(uniqid('m@rkPogi( .)( .)', true));

			return $newToken;
		}


		public function activate_device($activation_code)
		{

			$activation = $this->get_activation($activation_code);


			// die(var_dump($activation));

			if(!$activation)
			{
				Flash::set("{$activation_code} not found" , 'danger' , 'msg');
				return false;
			}else if($activation->is_used)
			{
				Flash::set("{$activation_code} already used" , 'danger' , 'msg');
				return false;
			}


			$this->setDeviceCookie($activation->token , $activation->id);

			/*add device*/
			$this->db->query(
				"INSERT INTO ld_devices(tokenid , token) 
				VALUES('{$activation->id}' , '{$activation->token}')"
			);

			$this->db->execute();

			/*set token to used*/
			$this->db->query(
				"UPDATE $this->table_name set is_used = true 
					WHERE id = '{$activation->id}'"
			);

			$this->db->execute();

			return true;
		}

		public function get_activation($activation_code)
		{

			$this->db->query(
				"SELECT * FROM $this->table_name where code = '$activation_code'"
			);

			return $this->db->single();
		}

		private function setDeviceCookie($cookie , $cookieid)
		{	
			$cookieName = seal('dbbicookie');

			$data = [
				$cookieid , $cookie
			];

			Cookie::set($cookieName , json_encode($data));

			return true;
		}

		public function getDeviceCookie()
		{
			return Cookie::get(seal('dbbicookie'));
		}
	}