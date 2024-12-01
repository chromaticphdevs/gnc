<?php 	
	
	class LevelSetting extends Controller
	{

		public function __construct()
		{
			$this->levelModel = model('LevelSettingModel');
		}

		public function index()
		{

			$data = [
				'levels' => $this->levelModel->all()
			];


			return $this->view('level_setting/index' , $data);
		}
	}