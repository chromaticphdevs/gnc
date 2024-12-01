<?php namespace classes;

  class VideoTutorialLinkConvert
  {
    private static $instance = null;


    public static function getInstance()
		{
			if(self::$instance == null){
				self::$instance = new VideoTutorialLinkConvert();
			}

			return self::$instance;
		}


    public static function convert($type , $link)
    {

      $src = '';

      $baseLinks = [
        'facebook' => 'https://www.facebook.com/plugins/video.php?href',
        'youtube'  => 'https://www.youtube.com/embed'
      ];

      switch(strtolower($type))
      {
        case 'facebook':
          $src = $baseLinks['facebook'].'='.$link;
        break;

        case 'youtube':
          $src = $baseLinks['youtube'].'/'.$link;
        break;
      }

      return $src;
    }
  }
