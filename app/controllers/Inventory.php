<?php 	

	class Inventory extends Controller
	{

		/*
		*The inventory controll panel
		*/
		public function __construct()
		{
			/*check account login*/

			if(Session::check('USERSESSION') || Session::check('BRANCH_MANAGER')) 
			{

			}else{
				return redirect("users/login");
			}
		}

		public function index()
		{
			return $this->view('inventory/control_panel');
		}

		
		public function control_panel()
		{
			return $this->view('inventory/control_panel');
		}
	}