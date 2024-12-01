<?php

	class Binary extends Controller
	{
		private $_userId;

		public function __construct()
		{
			$this->binary_model = $this->model('binary_model');
		}

		public function downlines($user_id = null)
		{	
			if(Auth::user_position() === '1')
			{
				if($user_id != null)
				{
					$this->_userId = $user_id;
				}else{
					$this->_userId = Session::get('USERSESSION')['id'];
				}
			}
			else{
				$this->_userId = Session::get('USERSESSION')['id'];
			}

			$treshold = 7;

			$data = [
				'tree' => $res = $this->binary_model->getDownlines( $this->_userId )
			];

			$this->view('binary/index' , $data);
		}

		private function getMainDownlines($user_id)
		{
			$this->db->query(
				"SELECT id from users where upline = :user_id"
			);
			$this->db->bind(':user_id' , $user_id);

			return $this->db->resultSet();
		}
	}