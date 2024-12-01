<?php 	

	class API_LevelSettting extends Controller
	{

		public function __construct()
		{
			$this->levelSetting = model('LevelSettingModel');
		}
		public function update()
		{
			$posts = $_POST;

			if(!is_numeric($posts['amount']))
			{
				ee(api_response('invalid amount' , FALSE));
			}else{
				$result = $this->levelSetting->dbupdate([
					'amount' => $posts['amount']
				] , $posts['id']);

				if($result)
					ee(api_response('amount updated'));
			}
			

		}
	}