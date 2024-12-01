<?php 
	
	class Book3 extends Controller
	{	

		public function index()
		{
			if(Session::check('USERSESSION'))
			{
				$user_status = Session::get('USERSESSION')['status'];
				
				if($user_status == 'silver' OR $user_status == 'gold')
				{
					$filePath = 'uploads/docs/ThinkandGrowRichebook.pdf';

					redirect($filePath);
				}else
				{
					Flash::set("Please Activate You're Account" , 'danger');

					redirect('Users/index');
				}
				
			}else
			{

				Flash::set("Please Login" , 'danger');

				redirect('Users/login');
			}
		} 

	}