<?php 
	
	/**
	 * 
	 */
	class TimekeepingStory extends Controller
	{	

		public function __construct()
		{
			$this->tkapp = model('TimekeepingAppModel');
		}
		
		function index()
		{
			if(!isset($_GET['userToken'])){
				Flash::set("Invalid Request" , 'danger');
				return request()->return();
			}


			$userToken = $_GET['userToken'];

			//get timesheets

			$timekeeping = $this->tkapp->apiGetByTokenComplete($userToken);

			$timesheets= $timekeeping->timesheets;

			// dump($timekeeping);

			$data = [
				'timesheets' => $timesheets,
				'accountToken'   => $timekeeping->domain_user_token
			];

			return $this->view('timekeeping/story' , $data);
		}


		function expanded()
		{
			if(!isset($_GET['userToken'])){
				Flash::set("Invalid Request" , 'danger');
				return request()->return();
			}


			$userToken = $_GET['userToken'];

			//get timesheets

			$timekeeping = $this->tkapp->apiGetByTokenComplete($userToken);

			$timesheets= $timekeeping->timesheets;


			$data = [
				'timesheets' => $timesheets,
				'accountToken'   => $timekeeping->domain_user_token
			];

			return $this->view('timekeeping/story_expanded' , $data);
		}
	}