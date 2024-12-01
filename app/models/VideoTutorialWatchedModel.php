<?php

  class VideoTutorialWatchedModel extends Base_model
  {

    public $table = 'video_links_watched';

    public function getWithTutorials($videoTutorials , $user_id)
    {

      $watchedVideos = $this->getWatchedVideos($user_id);

      $watchedIds    = [];

      foreach($watchedVideos as $key => $row) {
        $watchedIds[] = $row->link_id;
      }

      foreach($videoTutorials as $key => $row)
      {
        if(in_array($row->id , $watchedIds))
          $row->isWatched = true;
      }

      return $videoTutorials;
    }

    public function getNext($user_id)
    {
      /*
      *get a video link that is not watched by the user yet
      *ordered by the video link position 1 result
      */
      $this->db->query(

        "SELECT * FROM video_links
          WHERE id not in(
            SELECT link_id from $this->table
              WHERE user_id = '$user_id'
          )
        ORDER BY video_links.position asc
        LIMIT 1"
      );

      return $this->db->single();
    }

    /*get last watched video*/
    public function getLast($user_id)
    {
      $this->db->query(

        "SELECT * FROM video_links
          WHERE id  = (
            SELECT link_id from $this->table
              WHERE user_id = '$user_id'
              ORDER BY id desc limit 1
          )"
      );

      return $this->db->single();
    }

    
    public function getWatchedVideos($user_id)
    {
      $data = [
        $this->table,
        '*',
        " user_id = '{$user_id}'"
      ];

      return $this->dbHelper->resultSet(...$data);
    }

    public function extractIds($watchedVideos)
    {
      $watchedIds = [];

      foreach($watchedVideos as $key => $row) {
        $watchedIds[] = $row->link_id;
      }

      return $watchedIds;
    }
  }
