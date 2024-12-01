<?php 	

	class API_CallCenterAuthentication extends Controller
	{
		public function __construct()
		{
			$this->model = model('CallCenterAuthenticationModel');
			$this->toc = model('TOCModel');
		}

		public function authenticate()
		{
			$q = request()->inputs();

			$isLoggedIn = false;

			if( isEqual($q['type'] , 'breakthrough-manager') )
			{
				$isLoggedIn = $this->model->manager([
					'key' => $q['key'],
					'secret' => $q['secret']
				]);
			}


			if( isEqual($q['type'] , 'breakthrough-member') )
			{
				$isLoggedIn = $this->model->member([
					'key' => $q['key'],
					'secret' => $q['secret']
				]);
			}

			if($isLoggedIn) 
			{
				return ee(api_response($this->model->getUser(), true));

			}else{
				return ee(api_response($this->model->error , false));
			}
		}
	}