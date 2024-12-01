<?php 	

	class Device extends Controller
	{

		public function __construct()
		{
			$this->DeviceModel = $this->model('DeviceModel');
		}



		public function change_state()
		{

	    	$this->DeviceModel->change_state($_GET['category'],$_GET['status']);
	    	redirect('/admin/index');
		}

	

	}