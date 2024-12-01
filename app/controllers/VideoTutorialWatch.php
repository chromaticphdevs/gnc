<?php
  use classes\VideoTutorialLinkConvert;

  require_once CLASSES.DS.'VideoTutorialLinkConvert.php';

  class VideoTutorialWatch extends Controller
  {

    public function __construct()
    {
      $this->videoTutorial = $this->model('VideoTutorialModel');
      $this->videoTutorialWatched = $this->model('VideoTutorialWatchedModel');

      if(!Session::check('USERSESSION')){
        Flash::set("Accessing Private Page");
        return redirect("Users/login");
      }
    }

    public function index()
    {
      $user_id = Session::get('USERSESSION')['id'];
      $videoTutorials = $this->videoTutorial->dbget_assoc('position');
      $watchedVideos  = $this->videoTutorialWatched->getWatchedVideos($user_id);
      $watchedVideoIds = $this->videoTutorialWatched->extractIds($watchedVideos);
      $videoTutorialsWithWatchedVideos = $this->videoTutorialWatched->getWithTutorials($videoTutorials , $user_id);
      $nextVideo = $this->videoTutorialWatched->getNext($user_id);
      /*
      *Active video is set to the veryfirst video tutorial
      *arranged by position
      */
      $activeVideo = $this->videoTutorial->getFirst();
      /*
      *IF a user has already watched a video
      *Set active video to the last watched video
      */
      if(!empty($watchedVideos))
        $activeVideo = $this->videoTutorialWatched->getLast($user_id);
      /*
      *if a video id is set set that video
      *to active
      */
      if(isset($_GET['video_id']))
        $activeVideo = $this->videoTutorial->dbget(unseal($_GET['video_id']));


      $data = [
        'activeVideo' => $activeVideo,
        'videoTutorialsWithWatchedVideos' => $videoTutorialsWithWatchedVideos,
        'watchedVideoIds' => $watchedVideoIds,
        'user_id'         => $user_id,
        'linkConverter'  => VideoTutorialLinkConvert::getInstance(),
        'nextVideo'      => $this->videoTutorialWatched->getNext($user_id)
      ];

      return $this->view('video_tutorial/watch' , $data);
    }

    public function update()
    {
      $post = request()->inputs();

      // $data = array_remove_kitem(['submit'] , $post);

      $data = [
        'user_id' => $post['user_id'],
        'link_id' => $post['link_id']
      ];

      $result = $this->videoTutorialWatched->store($data);
      /*failed update*/
      if(!$result){
        flash_err();
        return request()->return();
      }

      Flash::set("Video is set to watched");

      $link_id = seal($post['link_id']);

      return redirect("VideoTutorialWatch?video_id={$link_id}");
    }
  }
