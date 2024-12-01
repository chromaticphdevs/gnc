<?php 	

	class UserTools extends Controller
	{


		public function __construct()
		{
			
			$this->UserToolsModel = $this->model('UserToolsModel');
			$this->activationLevels = activationlevels();
			
		}

		public function get_top_performer()
		{	
			$branchid = $this->check_session();

			if($this->request() === 'POST')
			{	
			
				$data = [
					'title' => "Top ".$_POST['top']." Performer",
	                'result' => $this->UserToolsModel->get_top_performer($_POST['top'],$_POST['status']),
	                'status' => $_POST['status']
	            ];

	            $this->view('tools/top_performer' , $data);

			}else{

				$data = [
					'title' => "Top 100 Performer",
	                'result' => $this->UserToolsModel->get_top_performer("today","all")
	            ];

	            $this->view('tools/top_performer' , $data);

			}

		}

		public function export()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['users']));


                $result = objectAsArray($exportData);

                $header = [
                    'username'  => 'Username',
                    'fullname' => 'Fullname',
                    'email'  => 'Email',
                    'mobile'  => 'Phone #',
                    'total_DS' => 'Total Direct Referral'
                ];

                export($result , $header);
            }
        }



		public function export_2()
        {
            if($this->request() === 'POST')
            {
                $exportData = (array) unserialize(base64_decode($_POST['users']));


                $result = objectAsArray($exportData);

                $header = [
                    'username'  => 'Username',
                    'firstname' => 'Firstname',
                    'lastname' => 'Lastname',
                    'address'  => 'Address',
                    'mobile'  => 'Phone #'
                ];

                export($result , $header);
            }
        }


		public function user_search_tool()
		{


			if($this->request() === 'POST')
			{	
				
				$data = [
					'title' => " Search Address",
					'levels'   => $this->activationLevels,
	                'result' => $this->UserToolsModel->user_search_tool($_POST['address'],$_POST['level'])
	            ];
	            $this->view('tools/user_search_tool' , $data);

			}else{

				$data = [
					'title' => " Search Address",
	                'levels'   => $this->activationLevels
	            ];
	            $this->view('tools/user_search_tool', $data);

			}
		}

		public function user_report()
	    {
	        /*SEARCH USER*/
	        check_session();
	      

			$list = $this->UserToolsModel->get_saved_report();

	    	if(!empty($list))
	    	{
				$data = [
	            'result' => $this->UserToolsModel->get_user_invites($list)
		        ];
		      
		        $this->view('tools/user_reports_sponsor' , $data);
	    	}

	    	 $this->view('tools/user_reports_sponsor');
	    	
	    }

	    public function add_to_report()
	    {	
	    	if(empty($_POST['user_id']))
	    	{
	    		Flash::set("User Not Found" , 'danger');
	    		redirect('UserTools/user_report');
	    	}

	    	//$list = SESSION::get("UserList");

	    	//$UserList = [];

	    	//$check_data = array_search($_POST['user_id'],$UserList);

			$check_data = $this->UserToolsModel->check_to_list_sql($_POST['user_id']);
	    	
	    	if(empty($check_data))
	    	{
	    		//array_push($UserList, $_POST['user_id']);

	    		$this->UserToolsModel->add_to_list_sql($_POST['user_id']);

	    		$list = $this->UserToolsModel->get_saved_report();

		    	Session::set('UserList' , $list);
		    	
		    	$data = [
	                'result' => $this->UserToolsModel->get_user_invites($list)
	            ];

	            $this->view('tools/user_reports_sponsor' , $data);

	    	}else{
	    		
	    		Flash::set("User already added" , 'danger');
	    		redirect('UserTools/user_report');
	    	}

	    
	    }

	    public function remove_to_report($userid)
	    {	
	    	//$list = SESSION::get("UserList");

	    	//$UserList = $list;

	    	//unset($UserList[$index]); 

	    	//array_diff($UserList, [$userid]);

	    	//Session::set('UserList' , $UserList);

	    	$this->UserToolsModel->delete_to_list_sql($userid);

	    	Flash::set("user has been removed");
	    	redirect('UserTools/user_report');
	    }

	    public function reset_report()
	    {
	    	//Session::remove('UserList');	
	    	$this->UserToolsModel->reset_list_sql();
	    	Flash::set("List has been Reset");
	    	redirect('UserTools/user_report');
	    }
	    

		private function check_session()
		{
			
			if(Session::check('BRANCH_MANAGERS'))
			{	
				$user = Session::get('BRANCH_MANAGERS');
				$branchid = $user->branchid;
				return $branchid;
				
			}else if(Session::check('USERSESSION'))
			{	
				$branchid = 8;	
				return $branchid;

			}else{
				redirect('user/login');
			}
		}

	}