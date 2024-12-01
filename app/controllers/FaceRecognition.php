<?php 	

	class FaceRecognition extends Controller
	{

		public function __construct()
		{
			$this->faceRecognitionModel = $this->model('faceRecognitionModel');
		}

		public function register_user()
		{

			if($this->request() === 'POST')
			{	
				$imageSource = $_POST['image'];

				$data = [
					'fullname' => $_POST['fullname'],
					'age'      => $_POST['age'],
					'gender'   => $_POST['gender']
				];

				$result = $this->faceRecognitionModel->register($imageSource , $data);	

				if($result) {
					echo 'Face Added Successfuly';
				}else{
					echo '';
				}
			}else
			{
				$data = [
					'title' => 'Face Recognition', 
					'subTitle' => 'Register'
				];

				$this->view('face_recogniton/register' , $data);
			}
			
		}

		public function login_user()
		{
			if($this->request() === 'POST') 
			{
				$imageSource = $_POST['image'];

				$result = $this->faceRecognitionModel->login($imageSource);	

				echo json_encode($result);

			}else{
				$data = [
					'title' => 'Face Recognition', 
					'subTitle' => 'Login'
				];

				$this->view('face_recogniton/login' , $data);
			}
		}
	}