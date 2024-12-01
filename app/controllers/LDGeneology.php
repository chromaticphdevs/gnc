<?php 	

	class LDGeneology extends Controller
	{

		public function __construct()
		{
			$this->geneologyModel = $this->model('LDGeneologyModel');
		}

		public function binary()
		{
			$userid = Session::get('user')['id'];

			$user = $this->geneologyModel->get_user_as_sne($userid);

			$uplines = $this->uplines($user);

			$data = [
				'title' => 'Geneology',
				'geneology' => $uplines,
				'user'     => $user
			];

			$this->view('lending/geneology/binary' , $data);

		}
		private function uplines($user)
		{
			if(empty($user))
				die("Old Account cannot track geneology");
			/*fifthlevel*/
			$geneology['level2'] = [
				'1.1' => $this->geneologyModel->downline($user->id , 'left'),
				'1.2' => $this->geneologyModel->downline($user->id , 'right'),
			];

			$level = $geneology['level2'];

			$geneology['level3'] = [
				'1.1' => $this->geneologyModel->downline($level['1.1']->id , 'left'),
				'1.2' => $this->geneologyModel->downline($level['1.1']->id , 'right'),
				'1.3' => $this->geneologyModel->downline($level['1.2']->id , 'left'),
				'1.4' => $this->geneologyModel->downline($level['1.2']->id , 'right')
			];

			$level = $geneology['level3'];

			$geneology['level4'] = [
				'1.1' => $this->geneologyModel->downline($level['1.1']->id , 'left'),
				'1.2' => $this->geneologyModel->downline($level['1.1']->id , 'right'),
				'1.3' => $this->geneologyModel->downline($level['1.2']->id , 'left'),
				'1.4' => $this->geneologyModel->downline($level['1.2']->id , 'right'),


				'1.5' => $this->geneologyModel->downline($level['1.3']->id , 'left'),
				'1.6' => $this->geneologyModel->downline($level['1.3']->id , 'right'),
				'1.7' => $this->geneologyModel->downline($level['1.4']->id , 'left'),
				'1.8' => $this->geneologyModel->downline($level['1.4']->id , 'right')
			];

			$level = $geneology['level4'];

			$geneology['level5'] = [
				'1.1' => $this->geneologyModel->downline($level['1.1']->id , 'left'),
				'1.2' => $this->geneologyModel->downline($level['1.1']->id , 'right'),
				'1.3' => $this->geneologyModel->downline($level['1.2']->id , 'left'),
				'1.4' => $this->geneologyModel->downline($level['1.2']->id , 'right'),
				'1.5' => $this->geneologyModel->downline($level['1.3']->id , 'left'),
				'1.6' => $this->geneologyModel->downline($level['1.3']->id , 'right'),
				'1.7' => $this->geneologyModel->downline($level['1.4']->id , 'left'),
				'1.8' => $this->geneologyModel->downline($level['1.4']->id , 'right'),


				'1.9' => $this->geneologyModel->downline($level['1.5']->id , 'left'),
				'1.10' => $this->geneologyModel->downline($level['1.5']->id , 'right'),
				'1.11' => $this->geneologyModel->downline($level['1.6']->id , 'left'),
				'1.12' => $this->geneologyModel->downline($level['1.6']->id , 'right'),
				'1.13' => $this->geneologyModel->downline($level['1.7']->id , 'left'),
				'1.14' => $this->geneologyModel->downline($level['1.7']->id , 'right'),
				'1.15' => $this->geneologyModel->downline($level['1.8']->id , 'left'),
				'1.16' => $this->geneologyModel->downline($level['1.8']->id , 'right')
			];
			return $geneology;
		}


		public function test()
		{	
			$data = [
				'title' => 'Test Title'
			];

			$this->view('lending/geneology/binary' , $data);
		}

	}