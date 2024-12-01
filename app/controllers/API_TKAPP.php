<?php 	
	
	class API_TKAPP extends Controller
	{

		public function __construct()
		{
			$this->tkapp = model('TimekeepingAppModel');
			$this->accountModel = model('FNAccountModel');
		}

		public function relogin()
		{
			$domainUserToken = request()->input('domain_user_token');

			$tkappData = $this->tkapp->getByAccess($domainUserToken);

			if($tkappData) {
				$result = $this->accountModel->get_account($tkappData->user_id);
				Session::set('BRANCH_MANAGERS' , $result);

				return redirect('timekeeping');
			}else{
				die("Invalid Request!");
			}
			
		}
	}