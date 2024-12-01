<?php

  class VideoTutorialWatched extends Controller
  {

    public function __construct()
    {
      $this->videoTutorial = $this->model('VideoTutorialModel');
      $this->videoTutorialWatched = $this->model('videoTutorialWatchedModel');
    }
  }
