<?php

  class API_VideoTutorial extends Controller
  {

    public function __construct()
    {
      $this->videoTutorial = $this->model('VideoTutorialModel');
    }
    public function reorderItems()
    {
      $post = request()->inputs();

      $items = $post['items'];

      /*
      *array key as orders
      *values are id video ids
      */
      $this->videoTutorial->reorderItems($items);
    }
  }
