<?php 	

	class Sne extends Controller
	{

		public function __construct()
		{
			$this->sneModel = $this->model('SneModel');

			$this->userModel = $this->model('user_model');
		}

		public function get_toppers()
		{
			Authorization::setAccess(['admin']);
			//get highest money

			$top = 0;
			$no_of_days = null;

			if(isset($_GET['top'])) {

				$top = $_GET['top'];
			}else{

				$top = 10;
			}


			if(isset($_GET['no_of_days'])) {

				$no_of_days = $_GET['no_of_days'];
			}


			$commissions['directSponsors'] = $this->sneModel->get_toppers_directsponsors($top , $no_of_days);
			$commissions['unilevels'] = $this->sneModel->get_toppers_unilevels($top , $no_of_days);
			$commissions['mentors'] = $this->sneModel->get_toppers_mentors($top , $no_of_days);
			$commissions['binary']  = $this->sneModel->get_toppers_binary($top , $no_of_days);

			$commissions['overAll'] = $this->sneModel->get_toppers_overall($top , $no_of_days);
			/*get all users*/


			$data = [
				'top'  => $top ,
				'commissions' => $commissions,
				'user_activated_count' =>  $this->sneModel->over_all_user_lvl_activated(),
				'amount_code_used_byLevel' => $this->sneModel->over_all_amount_code_used_byLevel()
			];



			$this->view('sne/top' , $data);
		}
	}