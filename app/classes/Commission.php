<?php

namespace app\Classes
{
	class Commission{

		private $db;

		private $user_id;

		public function __construct($user_id , $db)
		{
			$this->user_id = $user_id;
			$this->db = $db;
			
		}

		public function __clone()
		{

		}
		
	}
}