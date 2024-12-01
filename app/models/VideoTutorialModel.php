
<?php

	class VideoTutorialModel extends Base_model
	{

		public $table = 'video_links';

		public function set_time_zone()
		{
			$this->db->query("SET time_zone = '+08:00'");
       		$this->db->execute();
		}

		public function getFirst()
		{
			$result = parent::dbget_assoc('position');

			if($result)
				return $result[0];
			return false;
		}
		public function get_videos($type)
		{
			$this->db->query(
                "SELECT *
				FROM `video_links` WHERE type ='$type'"
            );

            return $this->db->resultSet();
		}


		public function add_link($link,$type,$title)
		{
			if($type=='Youtube')
			{
				$cut_link = explode("/",$link);
			    $link = $cut_link[3];
			}

			$make_query="INSERT INTO `video_links`(`link`, `type`, `title`) VALUES ('$link','$type','$title')";

			$this->db->query($make_query);
			return $this->db->execute();
		}

		public function get_link_info($id)
		{
			$this->db->query(
          "SELECT *
		 			FROM `video_links` WHERE id ='$id'"
      );
      return $this->db->single();
		}

		public function edit_link_info($id, $title, $link, $type)
		{
			if($type=='Youtube')
			{
				$cut_link = explode("/",$link);
			    $link = $cut_link[3];
			}

			$make_query="UPDATE `video_links` SET `title`='$title',`link`='$link' WHERE id='$id'";

			$this->db->query($make_query);
			return $this->db->execute();
		}

		public function delete_video($id)
		{

			$make_query="DELETE FROM `video_links` WHERE id='$id'";

			$this->db->query($make_query);
			return $this->db->execute();
		}

		/**
		*REORDER ITEMS
		*/

		public function reorderItems($items)
		{
			$updateOK = true;

			foreach($items as $key => $row)
			{
				$itemposupdate = parent::dbupdate([
					'position' => $key
				] , $row);
				/*An error occured*/
				if(!$itemposupdate)
					$updateOK = false;
			}

			return $updateOK;
		}
	}
