<?php

	class UserBinary extends Controller
	{

		public function __construct()
		{
			Authorization::setAccess(['admin' , 'user']);

			$this->binaryModel = new UserBinaryModel(Session::get('USERSESSION')['id']);
		}

		public function get_transactions()
		{
			$data = [
				'title' => ' Binary Transactions' ,
				'transactions' => $this->binaryModel->get_list(),
				'recent'   => $this->binaryModel->get_recent_transaction()
			];

			return $this->view('binary/transactions' , $data);	
		}


	}
