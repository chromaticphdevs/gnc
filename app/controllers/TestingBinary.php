<?php 	

	class TestingBinary extends Controller
	{
		public function __construct()
		{

			$this->test_binary_model = $this->model('test_binary_model');
		}


		public function add_points()
		{

			if($this->request() === 'POST')
			{
				$points   = $_POST['points'];
				$position = $_POST['position'];
				$user_id  = $_POST['user_id'];

				$url = $_POST['url'];

				$res = $this->test_binary_model->submit_commissions($user_id , $points , $position);

				if($res)
				{
					Flash::set("Points added on {$position} ($points)");
					redirect($url);

				}else{
					die("SOMETHING WENT WRONG");
				}
			}
		}


		public function classPoints($position , $points)
		{

			$point = new stdClass();

			$point->position = $position;
			$point->points   = $points;
		}
	}