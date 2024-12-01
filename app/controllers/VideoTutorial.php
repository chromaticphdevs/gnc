<?php

	use classes\VideoTutorialLinkConvert;

	require_once CLASSES.DS.'VideoTutorialLinkConvert.php';

	class VideoTutorial extends Controller
	{

		public function __construct()
		{
			$this->VideoTutorialModel = $this->model('VideoTutorialModel');
		}

		/*Customer view*/
		public function index()
		{
			return redirect("VideoTutorialWatch");
			// if($this->request() === 'POST')
			// {
			// }else{
			//
			// 	$data = [
			// 		'youtube_links' => $this->VideoTutorialModel->get_videos("YouTube"),
			// 		'facebook_links' => $this->VideoTutorialModel->get_videos("Facebook")
			// 	];
			//
			// 	$data['videos'] = $this->VideoTutorialModel->dbget_assoc('position');
			// 	$data['linkConverter'] = VideoTutorialLinkConvert::getInstance();
			//
			// 	return $this->view('video_tutorial/user_view_tutorial', $data);
			// }
		}

		public function add_video()
		{

			if($this->request() === 'POST')
			{

				$result=$this->VideoTutorialModel->add_link($_POST['link'],$_POST['link_type'],$_POST['title']);

				if($result){
					redirect("/VideoTutorial/add_video/");
				}else{
					redirect("/VideoTutorial/add_video/");
				}

			}else{

				//prev

				$data = [
					'youtube_links' => $this->VideoTutorialModel->get_videos("YouTube"),
					'facebook_links' => $this->VideoTutorialModel->get_videos("Facebook")
				];

				$data['videos'] = $this->VideoTutorialModel->dbget_assoc('position');
				$data['linkConverter'] = VideoTutorialLinkConvert::getInstance();

				return $this->view('video_tutorial/add_link', $data);
			}

		}

		public function edit_video_info()
		{
			if($this->request() === 'POST')
			{

				$result=$this->VideoTutorialModel->edit_link_info($_POST['id'],$_POST['title'],$_POST['link'], $_POST['link_type']);

				if($result){
					redirect("/VideoTutorial/add_video/");
				}else{
					redirect("/VideoTutorial/add_video/");
				}

			}else{

				$data = [
					'link_info' => $this->VideoTutorialModel->get_link_info($_GET['id'])
				];

				$this->view('video_tutorial/edit_link',$data);
			}
		}

		public function delete_video($id)
		{
			$result=$this->VideoTutorialModel->delete_video($id);
			if($result){
				redirect("/VideoTutorial/add_video/");
			}else{
				redirect("/VideoTutorial/add_video/");
			}
		}
	}
