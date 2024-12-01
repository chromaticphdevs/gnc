<?php 	


	class APITest extends Controller
	{

		public function __construct()
		{
			$this->comModel = $this->model('CommissionTransactionModel');
		}
		public function get_commissions()
		{

			print_r($_POST);
			
		}
	}